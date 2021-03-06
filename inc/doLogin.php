<?php
require __DIR__ . "/functions_auth.php";

$username = request()->get('username') ;
$password = request()->get('password') ;
$user = getUser($username);

if(empty($user)) {
    $session->getFlashBag()->add('error', 'User was not found');
    redirect('../login.php');
}

if(!verifyLogin($username, $password)) {
  redirect('../login.php');
}

createJWT($username);
