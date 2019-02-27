<?php
require __DIR__ . "/bootstrap.php";

function createUser($username, $password) {
global $db;

$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
$stmt->bindParam('username', $username );
$stmt->bindParam('password', $password );
$stmt->execute();

redirect('../index.php');

}

function getUser($username) {
  global $db;
  $sql = $db->prepare("SELECT * FROM users WHERE username = ?");
  $sql->bindValue(1, $username);
  $sql->execute();
  $results = $sql->fetch(PDO::FETCH_ASSOC);
  return $results;

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

//function to check if user is logged in (authenticated)
function isAuthenticated() {
      if (!request()->cookies->has('access_token')) {
          return false;
      }
      else {
        return true;
      }
}

function requireAuth() {
    if (!isAuthenticated()) {
      $accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', getenv('COOKIE_DOMAIN'));
      redirect('/login.php', ['cookies' => [$accessToken]]);
    }
}
