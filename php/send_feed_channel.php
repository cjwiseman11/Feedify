<?php
	session_start();
	include_once 'slq-statements.php';
	include_once 'rss-validator.php';

	$feed = $_POST['feed_link'];
	$channel = $_POST['new-channel'];
	if($channel == ""){
		$channel = $_POST['channel-selector'];
	}
	$hidden = $_POST['optionsRadios'];

	if(rssValidate($feed)){

		if (!(getChannelId($channel))){
			addToMemberChannel($channel, $_SESSION['feedifyusername'], $hidden);
		}

		if (!(checkNewsFeed($feed))){
			libxml_use_internal_errors(true);
			$feed_to_array = simplexml_load_file($feed);

			$auto_site_link = $feed_to_array->channel->link;
			$feed_title = $feed_to_array->channel->title;

			addToNewsfeeds($feed, $auto_site_link, $feed_title);
			addToMemberFeed($feed, $_SESSION['feedifyusername']);
		}

		if (!checkIfChannelFeedLinkExists($feed, $channel)){
			addChannelFeedLink($feed, $channel);
		  header("location: ../?chan=$channel");
		} else {
			echo "Feed already linked";

		}

	} else {
		echo "false";
		return false;
	}
?>
