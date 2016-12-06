<?php
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

include_once 'slq-statements.php';
session_start();
if(!isset($_SESSION['feedifyusername'])){
    echo "<p>Please log in to view saved posts</p>";
} else {
  $rows = getSavedPosts($_SESSION['feedifyusername']);
  foreach($rows as $rows)
  {
      if($rows["archived"] == 1){
          $imgcode = '<p class="text-center" style="position: absolute;color: #00b1c1;background: black;">Archived</p>
          <img src="thumbnails/'. $rows["imgSrc"] .'" class="img-responsive article-image">';
     } else {
          $imgcode = '<a href="thumbnails/full/' . $rows["imgSrc"] .'" target="_blank" class="thumbnail"><img src="thumbnails/'. $rows["imgSrc"] .'" class="img-responsive article-image"></a>';
      };

      if($rows["redditlink"] != ""){
          $redditcode = ' | <a href="' . $rows["redditlink"] . '">Reddit Comments</a>';
      } else {
          $redditcode = '';
      };

  	echo '<div id="'. $rows["0"].'" class="article-container container-fluid row-center dont-break-out row">
  			<div class="image col-sm-2 col-xs-12">
  			' . $imgcode . '
  			</div>
  		<div class="article-wrapper container col-sm-10 col-xs-12">
  			<div class="title">
  				<h3><a href="'. $rows["link"] .'" onclick="trackOutboundLink(\''.$rows["link"].'\')" class="articlelink '. $rows["0"] .'">'. $rows["title"] .'</a></h3>
  			</div>
  			<div class="description">
  				<h4>'. $rows["metDesc"] .'</h4>
  			</div>
  			<div class="date small">
  				<p>Date Posted:' . $rows["date"] .'<br>
  				Post Date: ' . $rows["pubDate"] .'</p>
  			</div>
  			<div class="feedsrc small">
  			<p>' . $rows["feedsrc"] . '</p>
  			</div>
  			<div class="social">
  				<a href="" class="remove-from-saved">Removed from Saved Posts</a> | <a href=" ' . $rows["link"] . '" data-image="'. $rows["imgSrc"] .'" data-title="'. $rows["title"] .'" data-desc="'. $rows["metDesc"] .'" class="btnShare">Share</a>' . $redditcode . '
  			</div>
  		</div>
  	</div>';
  }
}
?>
