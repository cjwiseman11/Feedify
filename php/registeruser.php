<?php
include_once 'slq-statements.php';

$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);
$email = stripslashes($_POST['email']);

if(userExists($username,$email)){
  header("location: ../register.php?fail");
} else {
  registerUser($username, $password, $email);
  header("location: ../register.php?success");
}


?>
