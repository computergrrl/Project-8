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
$pw =  getuser($username);

if(password_verify($password, $pw['password'])) {
  echo "You've logged in!";
} else {
      echo "Login was unsuccessful!!!";
}
}
