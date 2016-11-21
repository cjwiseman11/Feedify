<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
$config = parse_ini_file('config.ini'); 

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
if($connection === false){
	//TODO: Add error
}

$feedQuery = mysqli_query($connection,"SELECT rsslink FROM `newsfeeds`");
$i=0;

function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
    echo "Creating thumbnail.../n<br>";
    list($original_width, $original_height, $original_type) = getimagesize($filepath);
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);

    if ($original_type === 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    } else if ($original_type === 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    } else if ($original_type === 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    } else {
        return false;
    }

    $old_image = $imgcreatefrom($filepath);
    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background

    // figuring out the color for the background
    if(is_array($background) && count($background) === 3) {
      list($red, $green, $blue) = $background;
      $color = imagecolorallocate($new_image, $red, $green, $blue);
      imagefill($new_image, 0, 0, $color);
    // apply transparent background only if is a png image
    } else if($background === 'transparent' && $original_type === 3) {
      imagesavealpha($new_image, TRUE);
      $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagefill($new_image, 0, 0, $color);
    }

    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
    $imgt($new_image, $thumbpath);
    return file_exists($thumbpath);
}

while ($row = mysqli_fetch_array($feedQuery)){
	$ogImage = null;
	$feedstring = $row['rsslink'];
	$feed = mysqli_real_escape_string($connection, $feedstring);
	print "$feed<br>\n";
	$feed_to_array = simplexml_load_file($feed);
	
	if (strpos($feedstring, 'reddit.com') !== false || strpos($feedstring, 'youtube.com') !== false ) {
		$autoLink = $feed_to_array->entry->link['href'];
		$autoDate = $feed_to_array->entry->updated;
		//print_r($feed_to_array);
		print($autoLink);
	} else {	
		$autoLink = $feed_to_array->channel->item->link;
		$autoDate = $feed_to_array->channel->item->pubDate;
	}

	print "got link, pubdate $autoLink $autoDate<br>\n";
	
	$doc = new DOMDocument();
	@$doc->loadHTMLFile($autoLink);
	$xpath = new DOMXPath($doc);
	$query = '//*/meta[starts-with(@property, \'og:\')]';
	$metas = $xpath->query($query);
	$rmetas[i] = array();
	foreach ($metas as $meta) {
		$property = $meta->getAttribute('property');
		$content = $meta->getAttribute('content');
		$rmetas[i][$property] = $content;
	}
	print "got og tags<br>\n";
	$i++;
	$upTit = $rmetas[i]['og:title'];
	
	//Connecting to sql db.
	$dupeSubmission = mysqli_query($connection,"SELECT * FROM `posts` WHERE link LIKE '$autoLink'");
	$num_rows = $dupeSubmission->num_rows;
	print "checking if dupe link<br>\n";
	
	if ($num_rows===0){
		//Error Handling
		print "is new link<br>\n";
		if($upTit == ''){
			$upTit = $autoLink;
			$Desc = "Cannot retrieve data from link";
			$setLink = $autoLink;
			print "couldn't find data <br>\n";
		}else{
			// Get Description and set link
			$tags = get_meta_tags($autoLink);
			$Desc = $tags['description'];
			$setLink = $autoLink;
			$ogImage = $rmetas[i]['og:image'];
			print "found data<br>\n";
		}
		$channelquery = "select channels from newsfeeds where rsslink = '$feed'";
		$channelresult = mysqli_query($connection, $channelquery) or die("Error in Selecting " . mysqli_error($connection));
		while ($row = mysqli_fetch_array($channelresult)){
			$chickendipper = $row['channels'];
		}
		print "got channel: $chickendipper<br>\n";
		print "Attempted to add to db... <br>\n";
		
		//Get newsfeedId
		$newsfeedidresult = mysqli_query($connection, "SELECT id FROM newsfeeds WHERE rsslink = '$feed'");
		
		if (!$newsfeedidresult) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		while ($row = mysqli_fetch_array($newsfeedidresult)){
			$newsfeedid = $row['id'];
		}
		print "got NFID: $newsfeedid<br>\n";
		$upTit = mysqli_real_escape_string($connection, $upTit);
		$Desc = mysqli_real_escape_string($connection, $Desc);
        
		$result = mysqli_query($connection,"INSERT INTO posts (title, link, metDesc, type, feedsrc, pubDate, imgSrc, channels, newsfeedid)
		VALUES ('$upTit', '$setLink', '$Desc', 'auto', '$feed', '$autoDate', '', '$chickendipper', '$newsfeedid')");
		
		if($ogImage == !null){
			$info = getimagesize($ogImage);
			$ext = image_type_to_extension($info[2]);
			$getIdQuery = mysqli_query($connection,"SELECT id FROM `posts` WHERE link = '$setLink'");
			while($row = mysqli_fetch_assoc($getIdQuery)){
                $imageName = "thumb_" . $row["id"] . $ext;
				$imageSrc = __DIR__ . "/public_html/feedify/thumbnails/full/" . $imageName;
				$id = $row["id"];
				copy($ogImage, $imageSrc);
			}
			//$imgSrcRelative = "thumbnails/full/" . $imageName; //THis is not needed now cause saving just imagename
			mysqli_query($connection,"UPDATE `posts` SET `imgSrc`='$imageName' WHERE link = '$setLink'");
			echo "Image added:" . $imgSrcRelative;
			echo "<br>\n";
            createThumbnail($imageSrc, __DIR__ . "/public_html/feedify/thumbnails/" . $imageName, "300", "164", $background=false);
		} else {
			echo "No Image Found, setting to default<br>\n";
			mysqli_query($connection,"UPDATE `posts` SET `imgSrc`='thumb_default.jpg' WHERE link = '$setLink'");
		}
		
		if (!$result)
		  {
		  echo("<b>Error description: " . mysqli_error($connection) . "<br>\n<br>\n</b>");
		  }else{
				print "Added to Database<br>\n<br>\n";
			}
		}else{
			print"is Dupe Link Closing <br>\n<br>\n";
		}
}
//close the db connection
mysqli_close($connection);
?>
