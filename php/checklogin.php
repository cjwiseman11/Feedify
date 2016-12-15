<?php

include_once 'slq-statements.php';

if(rememberMe()){
    $_SESSION["feedifyusername"] = checkrememberme();
} else {
  // To protect MySQL injection
  $username = $_POST['username'];
  $password = $_POST['password'];
  $rememberme = $_POST['rememberme'];

  $result = getUserPassword($username);

  foreach($result as $row){
    if(crypt($password, $row['password']) == $row['password']){
      session_start();
      $_SESSION["feedifyusername"] = $username;
      if($rememberme){
        if(rememberMe()){
          //Do we need anything here?
        } else {
          setKeepLoggedIn($username);
        }
      }
      header("location: ../" . $_GET['page']);
    } else {
        echo "Wrong Username or Password";
    }
  }
}


?>
