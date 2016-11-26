<?php
if($_GET['chan']){
    $chan = $_GET['chan'];
} else {
    $chan = "all";
}

if($chan == "all")
{
	$row = getFullFeedList();
}else {
    $row = getFeedListForChan($chan);
}

echo "<p>";
echo "<div class='feed-item'>";
foreach($row as $row)
{
	echo "<a href='" . $row["rssSrcSite"] . "'>" . $row["rsslink"] . "</a><br>"; 
}
echo "</div></p>";
?>