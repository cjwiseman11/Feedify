<?php
include_once 'slq-statements.php';
$db = connectToDatabase();
$statement = $db->prepare("SELECT `rsslink` FROM `newsfeeds`");
$statement->execute();
$row = $statement->fetchAll();

foreach($row as $row){
  $feed_to_array = simplexml_load_file($row["rsslink"]);
  $feedtitle = $feed_to_array->channel->title;
  $db = connectToDatabase();
  $statement = $db->prepare("UPDATE `newsfeeds` SET `feedtitle`= :feedtitle WHERE rsslink = :feedlink");
  $statement->execute(array(':feedtitle' => $feedtitle, ':feedlink' => $row["rsslink"]));
}


?>
