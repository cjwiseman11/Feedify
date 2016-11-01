<?php
// Load configuration file outside of doc root
$root = $_SERVER['DOCUMENT_ROOT'];
$config = parse_ini_file($root . '/../config.ini'); 

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);

if($connection === false){
	//TODO: Add error
}
//$sql = "select * from newsfeeds where channels = '$chan'";
$sql = "SELECT * FROM `channels` ORDER BY id ASC";

//fetch table rows from mysql db
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
echo "<p>";
echo "<div class='feed-item'>";
while($row = mysqli_fetch_assoc($result))
{
	echo "<a href='?p=1&lim=10&chan=" . $row["channame"] . "'>" . $row["channame"] . "</a>, "; 
}
echo "</div></p>";

//close the db connection
mysqli_close($connection);
?>