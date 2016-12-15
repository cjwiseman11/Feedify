<?php
include_once 'slq-statements.php';

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

if(userExists($username,$email)){
  header("location: ../register.php?fail");
} else {
  registerUser($username, $password, $email);
  header("location: ../register.php?success");
}


?>
