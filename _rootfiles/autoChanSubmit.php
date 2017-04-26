<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0');
$config = parse_ini_file('config.ini'); 

//Connecting to sql db.
$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
if($connection === false){
	//TODO: Add error
}

$feedQuery = mysqli_query($connection,"SELECT rsslink FROM `newsfeeds`");
$similarityQuery = mysqli_query($connection, "SELECT * FROM posts WHERE (`Date` > DATE_SUB(now(), INTERVAL 1 DAY));");
$i=0;

function removeCommonWords($input){
 
 	// EEEEEEK Stop words
	$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
 
	return preg_replace('/\b('.implode('|',$commonWords).')\b/i','',$input);
}

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
		
		//compareTitleSimilarities($upTit, $id);
		while ($row2 = mysqli_fetch_array($similarityQuery)){
			$titleToCheck = removeCommonWords($upTit);
			echo "\n<br>$titleToCheck";
			$titleInLoop = removeCommonWords($row2['title']);
			echo "\n<br>$titleInLoop";
			similar_text($titleToCheck, $titleInLoop, $percentage );
			echo "\n<br>$percentage";
			if($percentage > 50){
				$newId = $row2['id'];
				if($newId != $id){
					mysqli_query($connection,"INSERT INTO `relatedTitles`(`originalPostID`, `similarPostID`, `percent`) VALUES ($id, $newId,$percentage)");
				}
			}
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
