<?php

$row = getChannelsList();
echo "<p>";
echo "<div class='feed-item'>";
foreach($row as $row)
{
	echo "<a href='?p=1&lim=10&chan=" . $row["channame"] . "'>" . $row["channame"] . "</a>, ";
}
echo "</div></p>";

if(isset($_SESSION['feedifyusername'])) {
	$row = getMembersChannels($_SESSION['feedifyusername']);
	if($row){
		echo "Your Channels: ";
		foreach($row as $row){
			echo "<a href='?p=1&lim=10&chan=" . $row["channame"] . "'>" . $row["channame"] . "</a>, ";
		}
	}
}
?>
