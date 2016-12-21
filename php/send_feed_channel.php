<?php
	session_start();
	include_once 'slq-statements.php';
	include_once 'rss-validator.php';

	$feed = $_POST['feed_link'];
	$channel = $_POST['new-channel'];
	$hidden = $_POST['optionsRadios'];

	
	if(rssValidate($feed)){
		libxml_use_internal_errors(true);
		$feed_to_array = simplexml_load_file($feed);

		$auto_site_link = $feed_to_array->channel->link;
		$feed_title = $feed_to_array->channel->title;

		//Sending form data to sql db.
		$news_feed_exist = checkNewsFeed($feed);

		$chanid = getChannelId($channel);

		if (!$chanid){
			addToMemberChannel($channel, $_SESSION['feedifyusername'], $hidden);
		}

		if (!$news_feed_exist){
			addToNewsfeeds($feed, $auto_site_link, $feed_title);
			addToMemberFeed($feed, $_SESSION['feedifyusername']);
		}

		if (!checkIfChannelFeedLinkExists($feed, $channel)){
			addChannelFeedLink($feed, $channel);
		}
	} else {
		echo "false";
		return false;
	}
?>
