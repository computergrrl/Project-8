<?php
require __DIR__ . "/functions_auth.php";

$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

$hashpw = password_hash($password, PASSWORD_DEFAULT);

if ($password != $confirmPassword) {
    $session->getFlashBag()->add('error', 'Passwords entered don\'t match!  Please try again');
    redirect('../register.php');
}  else {
  //add user to database
    createUser($username, $hashpw);
    createJWT($username);

}
