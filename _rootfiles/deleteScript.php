<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
$config = parse_ini_file('config.ini');

//Connecting to sql db.
$connection = mysqli_connect("10.169.0.142",$config['username'],$config['password'],$config['dbname']);
if($connection === false){
	//TODO: Add error
}

$getrows = "SELECT imgSrc FROM posts WHERE date <= (NOW() - INTERVAL 1 MONTH) AND archived = 0";
$result = mysqli_query($connection, $getrows) or die("Error in Selecting " . mysqli_error($connection));
$deleted = 0;

while($row = mysqli_fetch_assoc($result)){
    if(unlink("/var/sites/p/peppertech.co.uk/public_html/feedify/thumbnails/full/" . $row['imgSrc'])){
        echo "File Deleted.";
        $deleted++;
      }
}

echo "FullImages: Successfully archived $deleted assets<br>";

$getrows = "SELECT imgSrc FROM posts WHERE date <= (NOW() - INTERVAL 2 MONTH) AND archived = 0";
$result = mysqli_query($connection, $getrows) or die("Error in Selecting " . mysqli_error($connection));
$deleted = 0;

while($row = mysqli_fetch_assoc($result)){
    if(unlink("/var/sites/p/peppertech.co.uk/public_html/feedify/thumbnails/" . $row['imgSrc'])){
        $deleted++;
        echo "File Deleted.";
      }
}

$sql = "UPDATE posts SET archived = true WHERE date <= (NOW() - INTERVAL 1 MONTH) AND archived = 0";
mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

echo "Thumbs: Successfully archived $deleted assets";

//close the db connection
mysqli_close($connection);
?>
