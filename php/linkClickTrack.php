<?php
	// Load configuration file outside of doc root
	$root = $_SERVER['DOCUMENT_ROOT'];
	$config = parse_ini_file($root . '/../config.ini'); 

	//Connecting to sql db.
	$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
	if($connection === false){
		//TODO: Add error
	}

	$link = $_GET['link'];
	echo "$link";
	mysqli_query($connection,"UPDATE `posts` SET `vote`= vote+1 WHERE `link` = '$link'") or die("Error in Selecting " . mysqli_error($connection));
	//header("Location: $link");

	//close the db connection
	mysqli_close($connection);
?>