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

if($_GET['lim']){
    $limit = $_GET['lim'];
} else {
    $limit = "10";
}

if($_GET['p']){
    $page = $_GET['p'];
} else {
    $page = "1";
}
$id = $_GET['id'];

if($limit > 20){
	$limit = 20;
}

$offset = ($page - 1) * $limit;


if($chan == "all")
{
	$sql = "select * from posts ORDER BY id DESC LIMIT $limit OFFSET $offset";
} 
else if ($id){
	$sql = "SELECT * FROM `posts` WHERE id = $id";
} else {
	//$sql = "select * from posts WHERE channels = '$chan' ORDER BY id DESC";
	$sql = "SELECT * FROM `posts` as c
		INNER JOIN `channelfeed-links` AS m
			ON m.newsfeedid = c.newsfeedid
		INNER JOIN `channels` as b
			ON m.channelid = b.id
		WHERE b.channame = '$chan'
		ORDER BY c.id DESC
		LIMIT $limit OFFSET $offset";
}
//fetch table rows from mysql db
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
while($row = mysqli_fetch_assoc($result))
{
    if($row["archived"] == 1){
        $imgcode = '<p class="text-center" style="position: absolute;color: #00b1c1;background: black;">Archived</p>
        <img src="thumbnails/'. $row["imgSrc"] .'" class="img-responsive article-image">';
   } else {
        $imgcode = '<a href="thumbnails/full/' . $row["imgSrc"] .'" target="_blank" class="thumbnail"><img src="thumbnails/'. $row["imgSrc"] .'" class="img-responsive article-image"></a>';
    };
	echo '<div id="'. $row["id"] .'" class="article-container container-fluid row-center dont-break-out row">
			<div class="image col-sm-2 col-xs-12">
			' . $imgcode . '
			</div>
		<div class="article-wrapper container col-sm-10 col-xs-12">
			<div class="title">
				<h3><a href="'. $row["link"] .'" onclick="trackOutboundLink(\''.$row["link"].'\') class="articlelink '. $row["id"] .'">'. $row["title"] .'</a></h3>
			</div>
			<div class="description">
				<h4>'. $row["metDesc"] .'</h4>
			</div>
			<div class="date small"> 
				<p>Date Posted:' . $row["date"] .'<br>
				Post Date: ' . $row["pubDate"] .'</p>
			</div>
			<div class="feedsrc small">
			<p>' . $row["feedsrc"] . '</p>
			</div>
			<div class="feedshare">
				<a href=" ' . $row["link"] . '" data-image="'. $row["imgSrc"] .'" data-title="'. $row["title"] .'" data-desc="'. $row["metDesc"] .'" class="btnShare">Share</a>
			</div>
		</div>
	</div>';
}

//close the db connection
mysqli_close($connection);
?>