<?php 

$url = $_GET['url'];

$feed_to_array = simplexml_load_file("https://www.reddit.com/submit.rss?url=" . $url);
$link = $feed_to_array->entry->link['href'];

echo $link;
?>