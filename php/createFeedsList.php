<?php
// Load configuration file outside of doc root
$root = $_SERVER['DOCUMENT_ROOT'];
$config = parse_ini_file($root . '/../config.ini'); 

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);

if($connection === false){
	//TODO: Add error
}

if($_GET['chan']){
    $chan = $_GET['chan'];
} else {
    $chan = "all";
}

if($chan == "all")
{
	$sql = "select * from newsfeeds";
}else {
	//$sql = "select * from newsfeeds where channels = '$chan'";
	$sql = "SELECT * FROM `newsfeeds` as c
			INNER JOIN `channelfeed-links` AS m
				ON m.newsfeedid = c.id
			INNER JOIN `channels` as b
				ON m.channelid = b.id
			WHERE b.channame = '$chan'";
}

//fetch table rows from mysql db
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
echo "<p>";
echo "<div class='feed-item'>";
while($row = mysqli_fetch_assoc($result))
{
	echo "<a href='" . $row["rssSrcSite"] . "'>" . $row["rsslink"] . "</a><br>"; 
}
echo "</div></p>";

//close the db connection
mysqli_close($connection);
?>