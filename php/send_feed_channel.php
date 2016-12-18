<?php
	// Load configuration file outside of doc root
	$root = $_SERVER['DOCUMENT_ROOT'];
	$config = parse_ini_file($root . '/../config.ini');

	//Connecting to sql db.
	$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);

	if($connection === false){
		//TODO: Add error
	}

	$feed = mysqli_real_escape_string($connection,$_POST[feed_link]);
	$channel = mysqli_real_escape_string($connection,$_POST[feed_channel]);
	libxml_use_internal_errors(true);
	$feed_to_array = simplexml_load_file($feed);
	if(false === $feed_to_array){
		echo 'No XML was found at this destination. Please try again.';
		echo '<br><br><input type="button" value="Back" onClick="history.back();return true;"><br><br>';
		exit;
	} else {
		$autoSiteLink = $feed_to_array->channel->link;
		$feedtitle = $feed_to_array->channel->title;
		//Sending form data to sql db.
		$newsFeedExist = mysqli_query($connection,"SELECT * FROM newsfeeds WHERE rsslink = '$feed'");
		$newsFeedExist_rows = $newsFeedExist->num_rows;

		$chanid = mysqli_query($connection,"SELECT * FROM channels WHERE channame = '$channel'");
		$num_rows = $chanid->num_rows;
		if ($num_rows === 0){
			mysqli_query($connection,"INSERT INTO channels (channame) VALUES ('$channel')");
		}

		if ($newsFeedExist_rows === 0){
			mysqli_query($connection,"INSERT INTO newsfeeds (rsslink, rssSrcSite, feedtitle)
			VALUES ('$_POST[feed_link]','$autoSiteLink','$feedtitle')");
		}

		$chanExist = mysqli_query($connection,"
		SELECT * FROM `channelfeed-links`
		WHERE newsfeedid = (SELECT id FROM newsfeeds WHERE rsslink='$feed')
		AND channelid = (SELECT id FROM channels WHERE channame='$channel')");
		$channum_rows = $chanExist->num_rows;

		if ($channum_rows === 0){
			mysqli_query($connection,"INSERT INTO `channelfeed-links`(newsfeedid,channelid)
			VALUES ((SELECT id FROM newsfeeds WHERE rsslink='$feed'),
			(SELECT id FROM channels WHERE channame='$channel'));");
		}
	}

	//close the db connection
	mysqli_close($connection);

	//Go back to page
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit;

?>
