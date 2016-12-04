<?php if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start(); session_start(); include_once 'php/slq-statements.php';?>
<!doctype php>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="author" content="Chris Wiseman">
	<title>Feedify.</title>
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
	<script>
	<?php
		//Get current channel and save into variable
        if($_GET['chan']){
            $chan = $_GET['chan'];
        } else {
            $chan = "all";
        }

        if($_GET['lim']){
            $lim = $_GET['lim'];
        } else {
            $lim = "10";
        }

        if($_GET['p']){
            $page = $_GET['p'];
        } else {
            $page = "1";
        }
	?>

        //Random Button Logic
$('#randomify').click(function(){
    var randomLink = "";
    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() {
        randomLink = this.responseText; //Will alert: 42
        window.location.href = JSON.parse(randomLink);
    };
    oReq.open("get", "php/randomArticle.php", true);
    $(this).text('Loading...');
    oReq.send();
    return false;
});
	</script>
	<script>
		<!--FB Share Test-->
		window.fbAsyncInit = function(){
		FB.init({
			appId: '1144002758989306', status: true, cookie: true, xfbml: true });
		};
		(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
			if(d.getElementById(id)) {return;}
			js = d.createElement('script'); js.id = id;
			js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
			ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));

		function postToFeed(title, desc, url, image){
			var obj = {method: 'feed',link: url, picture: 'http://www.peppertech.co.uk/'+image,name: title,description: desc};
			function callback(response){}
			FB.ui(obj, callback);
		}
	</script>
    <script>
    /**
    * Function that tracks a click on an outbound link in Analytics.
    * This function takes a valid URL string as an argument, and uses that URL string
    * as the event label. Setting the transport method to 'beacon' lets the hit be sent
    * using 'navigator.sendBeacon' in browser that support it.
    */
    var trackOutboundLink = function(url) {
       ga('send', 'event', 'outbound', 'click', url, {
         'transport': 'beacon',
         'hitCallback': function(){document.location = url;}
       });
    }
    </script>
  </head>
<body>
<div id="member-login" class="text-right container">
<?php
    if(!isset($_SESSION['feedifyusername'])): ?>
            <form class="form-inline form-group-sm" method="post" action="php/checklogin.php">
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
            <p>Hello <?php echo $_SESSION['feedifyusername']; ?> <a href="php/logout.php">Logout</a>
							<br>
							<a href="">View saved posts</a>
						</p>
        </div>
    <?php endif; ?>
</div>
<div id="main-wrapper" class="container">
	<div class="row">
		<div id="heading-section" class="text-center">
			<h1 id="home"><a href="/feedify" title="home">Feedify</a><small> Beta</small></h1>
			<div id="channel-list">
				<?php include('php/createChannelsList.php');?>
			</div>
		</div>
	</div>
    <div class="row">
        <div id="first-time" class="col-sm-12">
            <div class="col-sm-11">
                <h2>Welcome to Feedify. A simple RSS Feed.</h2>
                <p>To create your very own channel, input the RSS feed into the "RSS URL" box below, and then add the channel name you'd like it to appear on and then click submit - that's it!</p>
                <p>Feeds will get updated every 30 mins and all feeds will appear on the ALL channel</p>
                <p>More features to come! Let me know if you want more stuff or you see any defects :) </p>
            </div>
            <div class="col-sm-1">
                <a href="#" id="ft-close">Close</a>
            </div>
        </div>
    </div>
	<div class="row">
		<div id="feed-section" class="col-sm-12">
			<div id="control-section" class="col-sm-6">
                <h2><small>Current Channel: <?php echo $chan ?> <a href="#" id="seefeedlist">(Feed list)</a></small></h2>
				<p>Limit feed by: <a href="#" id="lim5">5</a> | <a href="#" id="lim10">10</a> | <a href="#" id="lim15">15</a> | <a href="#" id="lim20">20</a></p>
				<p>Page: <?php echo $page; ?>
				<p><?php
					$nextpage = $page + 1;
					$prevpage = $page - 1;
					if($page == 1){
						echo "<a href='?p=2&lim=$lim&chan=$chan'>Next Page ></a>";
					} else if($page >1){
						echo "<a href='?p=1&lim=$lim&chan=$chan'><< First</a> | <a href='?p=$prevpage&lim=$lim&chan=$chan'>< Previous</a> | <a href='?p=$nextpage&lim=$lim&chan=$chan'>Next ></a>";
					}
				?></p>
			</div>
			<div id="submit-section" class="col-sm-6">
				<h2><small>Submit RSS:</small></h2>
				<form action="php/send_feed_channel.php" method="post" onsubmit="return sendRSS();" class="form-inline">
				<div class="form-group">
					<input type="text" name="feed_link" class="form-control" id="feedLink" placeholder="RSS URL">
				</div>
				<div class="form-group">
					<input type="text" name="feed_channel" class="form-control" value="<?php echo  $chan ?>" placeholder="Channel">
				</div>
				<input type="submit" class="btn btn-default">
				<div class="alert alert-danger col-sm-12 hide" role="alert">
				<p>You must submit an RSS feed.</p>
				</div>
				</form>
				<br>
                <a href="//RandomArticle" id="randomify" type="submit" class="btn btn-default">Random Article</a>
                <br><br>
			</div>
		</div>
        <div class="row">
            <div id="feedlist" class="col-sm-12">
                <p>The feeds in this channel are:</p>
                <?php include('php/createFeedsList.php');?>
            </div>
        </div>
        <!--This is where the feed will appear -->
        <div id="news-feedjson" class="col-sm-12">
            <?php include('php/createSavedPosts.php');?>
        </div>
        <!--End Feed-->

        <!--Had sticky vote selection, still want? -->
        <!--Update Vote was here but is not needed for now chcked v0.6 -->
        <br>
	</div>
	<div class="row">
		<div id="footer-section" class="col-sm-12">
			<p>Page: <?php echo $page; ?>
			<p><?php
				$nextpage = $page + 1;
				$prevpage = $page - 1;
				if($page == 1){
					echo "<a href='?p=2&lim=$lim&chan=$chan'>Next Page ></a>";
				} else if($page >1){
					echo "<a href='?p=1&lim=$lim&chan=$chan'><< First</a> | <a href='?p=$prevpage&lim=$lim&chan=$chan'>< Previous</a> | <a href='?p=$nextpage&lim=$lim&chan=$chan'>Next ></a>";
				}
			?></p>
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
