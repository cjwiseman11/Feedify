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
					<p>Hello <?php echo $_SESSION['feedifyusername']; ?> | <a href="index.php">Home</a> | <a href="php/logout.php">Logout</a>
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
      <h2>Saved Posts</h2>
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
