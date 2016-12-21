<?php if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start(); session_start(); include_once 'php/slq-statements.php';?>
<!doctype php>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="author" content="Chris Wiseman">
	<title>Submit Feeds and Create Channels - Feedify.</title>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!--Replace This Section
	<link rel="shortcut icon" href="http://designshack.net/favicon.ico">
	<link rel="icon" href="http://designshack.net/favicon.ico">
	-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/feedifyQueryString.js"></script>
  </head>
<body>
<div id="member-login" class="text-right container">
<?php
    if(!isset($_SESSION['feedifyusername'])): ?>
            <form class="form-inline form-group-sm" method="post" action="php/checklogin.php?page=saved-posts.php">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input name="username" type="text" class="form-control" id="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
    <?php else : ?>
        <div id="member-loggedin">
					<p>Hello <?php echo $_SESSION['feedifyusername']; ?> | <a href="index.php">Home</a> | <a href="your-feeds.php">Your Feeds</a> | <a href="php/logout.php">Logout</a>
						</p>
        </div>
    <?php endif; ?>
</div>
<div id="main-wrapper" class="container">
	<div class="row">
		<div id="heading-section" class="text-center">
			<h1 id="home"><a href="/feedify" title="home">Feedify</a><small> Beta</small></h1>
		</div>
	</div>
	<div class="row">
		<div id="feed-section" class="col-sm-12">
      <h2><small>Submit Feeds and Create Channels</small></h2>
      <p>Hello <?php echo $_SESSION['feedifyusername']; ?>, here you can create your very own channels for Feedify and submit news feeds to each one</p>
      <p>You can choose to make your channel private, which will mean it won't appear in "All" or as a public channel</p>
      <p>Below you can also find a list of feeds already found on the site, which you can add to your channels or a public channel if appropriate</p>
      <hr>
    </div>
    <div class="col-sm-6 submit-section">
      <form action="php/send_feed_channel.php" method="post" onsubmit="return sendRSS();" class="form col-sm-8">
      <div class="form-group">
        <label class="control-label" for="feed_link">Please input a full RSS Link including HTTP, or <a href="#search-area" id="search-area-link">use the search area</a></label>
        <input type="text" name="feed_link" class="form-control" id="rssfeedsubmit" placeholder="RSS URL" required>
        <span class='help-block' id='rssresponse-helpblock'>Valid Feed Detected! Yay!</span>
      </div>
			<select id="channel-selector" class="form-control">
			  <option>Choose a channel</option>
			  <option id="create-channel">Create your own...</option>
				<?php foreach(getChannelsList() as $row){
					echo "<option>" . $row['channame'] . "</option>";
				}?>
			</select>
			<input type="text" name="new-channel" class="form-control" id="new-channel-entry" placeholder="New channel here" required>
			<span class='help-block' id='new-channel-message'>This channel already exists.</span>
			<div id="private-channel-radio" class="radio-selection">
				<br>
				<p>Would you like this channel to be hidden or public?</p>
	      <div class="radio">
	        <label>
	          <input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
	          Keep this channel hidden please
	        </label>
	      </div>
	      <div class="radio">
	        <label>
	          <input type="radio" name="optionsRadios" id="optionsRadios2" value="0" checked>
	          Make the channel public, for all to see
	        </label>
	      </div>
			</div>
			<br>
      <input type="submit" class="btn btn-default">
      <div class="alert alert-danger col-sm-12 hide" role="alert">
      <p>You must submit an RSS feed.</p>
      </div>
      </form>
		</div>
    <div id="search-area" class="col-sm-6 search">
      <div class="form-group">
        <p>Please input an RSS Link or a web URL:</p>
        <input type="text" name="feed_link" class="form-control" id="feedLink" placeholder="RSS URL">
      </div>
      <div class="search-results">
        <p>Start typing to search...</p>
      </div>
    </div>
	</div>
	<div class="row">
		<div id="footer-section" class="col-sm-12">
			<p class="text-center">Feedify &copy; 2016</p>
		</div>
	</div>
<!-- Bottom Scripts Below -->
<script defer src="js/bootstrap.min.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83935695-1', 'auto');
    ga('send', 'pageview');
</script>
<script defer type="text/javascript" src="js/scripts.js"></script>
</body>
</html>
