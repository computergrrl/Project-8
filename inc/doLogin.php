<?php
require __DIR__ . "/functions_auth.php";

$username = request()->get('username') ;
$password = request()->get('password') ;
verifyLogin($username, $password);
