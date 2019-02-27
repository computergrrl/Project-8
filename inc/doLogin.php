<?php
require __DIR__ . "/functions_auth.php";

$username = request()->get('username') ;
$password = request()->get('password') ;
$user = getUser($username);

if(empty($user)) {
    redirect('../login.php');
}

if(!verifyLogin($username, $password)) {
  redirect('../login.php');
}

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
