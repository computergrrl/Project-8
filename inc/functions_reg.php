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
