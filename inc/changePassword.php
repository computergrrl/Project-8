<?php
require __DIR__ . "/functions_auth.php";
$current_password = request()->get('current_password') ;
$password =         request()->get('password') ;
$confirm_password = request()->get('confirm_password') ;

$getuser = getUserById();
$username = $getuser['username'];
$user_id = $getuser['id'];

if ($password != $confirm_password) {
    $session->getFlashBag()->add('error', 'New passwords do not match, please try again.');
    redirect('../account.php');
}

if(!verifyLogin($username, $current_password)) {
    $session->getFlashBag()->add('error', 'Incorrect user password entered');
    redirect('../account.php');
}

$newpass = password_hash($password, PASSWORD_DEFAULT) ;

if(updatePassword($newpass, $user_id)) {
  $session->getFlashBag()->add('success', 'Password updated successfully');
  redirect('../account.php');
}
