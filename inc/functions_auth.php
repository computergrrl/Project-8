<?php
require __DIR__ . "/bootstrap.php";

//function to create a user upon registering
function createUser($username, $password) {
global $db;

$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
$stmt->bindParam('username', $username );
$stmt->bindParam('password', $password );
$stmt->execute();


}

//function to get user info for user with specified username
function getUser($username) {
  global $db;
  $sql = $db->prepare("SELECT * FROM users WHERE username = ?");
  $sql->bindValue(1, $username);
  $sql->execute();
  $results = $sql->fetch(PDO::FETCH_ASSOC);
  return $results;

}

//function to get the user by logged in id
function getUserById() {
  $user_id = decodeJWT('sub');

  global $db;
  $sql = $db->prepare("SELECT * FROM users WHERE id = :id");
  $sql->bindParam('id', $user_id);
  $sql->execute();
  return $sql->fetch(PDO::FETCH_ASSOC);

}

function verifyLogin($username , $password) {
//check database to see if user exists
$pw =  getuser($username);
//if no user with that username exists then return false
      if(empty($pw)) {
        return false;
      }
      if(password_verify($password, $pw['password'])) {
      return true;
    }
  }

function updatePassword($password, $user_id) {
    global $db;
    $sql = $db->prepare("UPDATE users SET password = :password WHERE id=:user_id");
    $sql->bindParam('password', $password);
    $sql->bindParam('user_id', $user_id);
    $sql->execute();

    return true;

}


/* function to test if valid cookie exists. If it does the user
is considered authenticated and function returns true */
function isAuthenticated() {
      if (!request()->cookies->has('access_token')) {
          return false;
      }
      else {
        return true;
      }
}

/*  function for requiring authorization. If user is NOT authorized then
they're redirected to login page  */
function requireAuth() {
    //if user is NOT logged in then redirect them to the login page
    if (!isAuthenticated()) {
      $accessToken = new \Symfony\Component\HttpFoundation\Cookie(
        "access_token", "Expired", time()-3600, '/', getenv('COOKIE_DOMAIN'));
      redirect('/login.php', ['cookies' => [$accessToken]]);
    }
}

//function for creating a JWT
function createJWT($username) {

        $user = getUser($username);

      //set expiration variable for half an hour from now
        $expTime = time() + 120;

        //creating the JWT
        $jwt = \Firebase\JWT\JWT::encode([
            'iss' => request()->getBaseUrl(),
            'sub' => "{$user['id']}",
            'exp' => $expTime,
            'iat' => time(),
            'nbf' => time(),
        ], getenv("SECRET_KEY"),'HS256');

         /*use Symfony HttpFoundation package to create cookie, and pass in the
          newly created JWT*/
        $accessToken = new Symfony\Component\HttpFoundation\Cookie(
          'access_token', $jwt, $expTime, '/', getenv('COOKIE_DOMAIN'));

        /**** redirect to the homepage and include
              the $accessToken array with redirect****/
        redirect('/',['cookies' => [$accessToken]]);

}

/*  Function to decode the JWT ---   Optional "$claim" parameter may be passed
in order to return a specific element from the JWT claims array*******/
function decodeJWT($claim = null) {

        $jwt = \Firebase\JWT\JWT::decode(
        request()->cookies->get('access_token'),
        getenv('SECRET_KEY'),
        ['HS256']
    );

    if($claim === null) {
        return $jwt;
    }

    else return $jwt->{$claim};
}
/****************************************************************************
FOLLOWING 2 FUNCTIONS COPIED DIRECTLY FROM BOOK-VOTING APP
IN THE TREEHOUSE USER AUTHENTICATION COURSE
******************************************************************/
function display_errors() {
    global $session;

    if (!$session->getFlashBag()->has('error')) {
        return;
    }

    $messages = $session->getFlashBag()->get('error');

    $response = '<span class="error">';
    foreach ($messages as $message) {
        $response .= "{$message}<br />";
    }
    $response .= '</span>';

    return $response;
}
function display_success() {
    global $session;

    if(!$session->getFlashBag()->has('success')) {
        return;
    }

    $messages = $session->getFlashBag()->get('success');

    $response = '<span class="success">';
    foreach($messages as $message ) {
        $response .= "{$message}<br>";
    }
    $response .= '</span>';

    return $response;
}
