<?php

// Load configuration file outside of doc root
$root = $_SERVER['DOCUMENT_ROOT'];
$config = parse_ini_file($root . '/../config.ini');

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
if($connection === false){
	//TODO: Add error
}

echo $username;

// To protect MySQL injection
$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);
$username = mysqli_real_escape_string($connection,$username);
$password = mysqli_real_escape_string($connection,$password);

$sql = "SELECT * FROM `members` WHERE username='$username' and BINARY password='$password'";

$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


// Mysql_num_row is counting table row
$count = mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
    // Register $myusername, $mypassword and redirect to file "login_success.php"
    session_start();
    $_SESSION["feedifyusername"] = $username;
    header("location: ../" . $_GET['page']);
} else {
    echo "Wrong Username or Password";
}
?>
