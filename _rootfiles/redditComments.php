<?php 
// Load configuration file outside of doc root
$root = $_SERVER['DOCUMENT_ROOT'];
$config = parse_ini_file($root . 'config.ini'); 

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
if($connection === false){
	//TODO: Add error
}

//$url = $_GET['url'];

$sql = "select link from posts ORDER BY id DESC LIMIT 10 ";
//fetch table rows from mysql db
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

while($row = mysqli_fetch_assoc($result)){
    $url = $row['link'];
    $feed_to_array = simplexml_load_file("https://www.reddit.com/submit.rss?url=" . $url);
    $link = $feed_to_array->entry->link['href'];
    
    if($link){
        $submitUrlSQL = "UPDATE `posts` SET `redditlink`='$link' WHERE `link` = '$url' AND date > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        mysqli_query($connection, $submitUrlSQL) or die("Error in Selecting " . mysqli_error($connection));
    }

}

//close the db connection
mysqli_close($connection);
?>