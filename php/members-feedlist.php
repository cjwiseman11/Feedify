<?php
if($_GET['chan']){
    $chan = $_GET['chan'];
} else {
    $chan = "all";
}

if($chan == "all")
{
	$rowAll = getMemberFeedList($_SESSION["feedifyusername"]);
}else {
    $rowAll = getFeedListForChan($chan);
}
$rowUser = getFeedsByUser($_SESSION["feedifyusername"]);
echo "<div class='member-feedlist container'>";
  echo "<p>Filter by channel: ";
  $result = getChannelsList();
  foreach(getChannelsList() as $row){
    echo "<a href='?chan=" . $row['channame'] . "'>" . $row['channame'] . "</a> | ";
  }
  echo "</p>";
  echo "<div class='your-feeds col-sm-6'>";
    echo "<p>Your Feeds:</p>";
      foreach($rowUser as $row)
      {
        if($row["feedtitle"] == ""){
      	   echo "Remove | <a href='" . $row["rssSrcSite"] . "'>" . $row["rsslink"] . "</a><br>";
         } else {
           echo "Remove | <a href='" . $row["rssSrcSite"] . "'>" . $row["feedtitle"] . "</a><br>";
         }
      }
    echo "</div>";
    echo "<div class='your-feeds col-sm-6'>";
      echo "<p>All Feeds:</p>";
      foreach($rowAll as $row)
      {
        if($row["feedtitle"] == ""){
           echo "<a class='addFeed' href='php/add-remove.php?type=add&id=". $row["id"] ."'>Add</a> | <a href='" . $row["rssSrcSite"] . "'>" . $row["rsslink"] . "</a><br>";
         } else {
           echo "<a class='addFeed' href='php/add-remove.php?type=add&id=". $row["id"] ."'>Add</a> | <a href='" . $row["rssSrcSite"] . "'>" . $row["feedtitle"] . "</a><br>";
         }
      }
  echo "</div>";
echo "</div>";
?>
