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
  </head>
<body>
<div id="main-wrapper" class="container">
  <p>Register</p>
  <form class="form-inline form-group-sm" method="post" action="php/registeruser.php">
      <div class="form-group">
          <label for="username">Username</label>
          <input name="username" type="text" class="form-control" id="username" placeholder="Username" required>
      </div>
      <div class="form-group">
          <label for="password">Password</label>
          <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
      </div>
      <div class="form-group">
          <label for="email">Email</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="Email" required>
      </div>
      <button type="submit" class="btn btn-default">Login</button>
  </form>
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
