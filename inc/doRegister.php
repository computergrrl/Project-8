<?php
require __DIR__ . "/functions_auth.php";

$username = request()->get('username');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

$hashpw = password_hash($password, PASSWORD_DEFAULT);

if ($password != $confirmPassword) {
    redirect('../register.php');
}  else {
    createUser($username, $hashpw);
}
