<?php

include_once 'slq-statements.php';

// To protect MySQL injection
$username = $_POST['username'];
$password = $_POST['password'];

$result = getUserPassword($username);

foreach($result as $row){
  if(crypt($password, $row['password']) == $row['password']){
    session_start();
    $_SESSION["feedifyusername"] = $username;
    header("location: ../" . $_GET['page']);
  } else {
      echo "<br>" . crypt($hashedInput, $row['password']);
      echo "<br>" . crypt($row['password']);
      echo "Wrong Username or Password";
  }
}
?>
