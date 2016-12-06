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

if ($id){
    $row = getPostsById($id);
}
else if($chan == "all")
{
    $row = getPostsByAll($limit, $offset);
} else {
    $row = getPostsByChan($chan, $limit, $offset);
}
foreach($row as $row)
{
    if($row["archived"] == 1){
        $imgcode = '<p class="text-center" style="position: absolute;color: #00b1c1;background: black;">Archived</p>
        <img src="thumbnails/'. $row["imgSrc"] .'" class="img-responsive article-image">';
   } else {
        $imgcode = '<a href="thumbnails/full/' . $row["imgSrc"] .'" target="_blank" class="thumbnail"><img src="thumbnails/'. $row["imgSrc"] .'" class="img-responsive article-image"></a>';
    };

    if($row["redditlink"] != ""){
        $redditcode = ' | <a href="' . $row["redditlink"] . '">Reddit Comments</a>';
    } else {
        $redditcode = '';
    };

    if(isSavedPost($_SESSION['feedifyusername'],$row["id"])){
      $savedPostCode = 'Saved Post';
    } else {
      $savedPostCode = '<a href="" class="save-for-later">Save for later</a>';
    }

	echo '<div id="'. $row["id"] .'" class="article-container container-fluid row-center dont-break-out row">
			<div class="image col-sm-2 col-xs-12">
			' . $imgcode . '
			</div>
		<div class="article-wrapper container col-sm-10 col-xs-12">
			<div class="title">
				<h3><a href="'. $row["link"] .'" onclick="trackOutboundLink(\''.$row["link"].'\')" class="articlelink '. $row["id"] .'">'. $row["title"] .'</a></h3>
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
			<div class="social">
				' .$savedPostCode. ' | <a href=" ' . $row["link"] . '" data-image="'. $row["imgSrc"] .'" data-title="'. $row["title"] .'" data-desc="'. $row["metDesc"] .'" class="btnShare">Share</a>' . $redditcode . '
			</div>
		</div>
	</div>';
}
?>
