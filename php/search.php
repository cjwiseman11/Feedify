<?php
include_once 'slq-statements.php';

$searchvalue = $_GET['val'];
$returnData = searchFeeds($searchvalue);

foreach($returnData as $row){
  $result .= "<p><a href class='result-item' title='add feed to rss box for submission'>" . $row["rsslink"] . "</a></p>";
}

echo $result;
