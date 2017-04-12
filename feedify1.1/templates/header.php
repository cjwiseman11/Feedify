<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="author" content="Chris Wiseman">
	<title>Feedify.</title>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <link href="css/bulma.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/feedifyQueryString.js"></script>
</head>
<body>
      <nav class="nav">
        <div class="nav-left">
            <a href="/feedify" title="home" id="home" class="nav-item">Feedify</a>
        </div>
        <div class="nav-center">
            <a class="nav-item">
            <span class="icon">
                <i class="fa fa-github"></i>
            </span>
            </a>
            <a class="nav-item">
            <span class="icon">
                <i class="fa fa-twitter"></i>
            </span>
            </a>
        </div>

        <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
        <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </span>

        <!-- This "nav-menu" is hidden on mobile -->
        <!-- Add the modifier "is-active" to display it on mobile -->
        <?php if(!isset($_SESSION['feedifyusername'])): ?>
            <div class="nav-right nav-menu">
                <a class="nav-item">
                Home
                </a>
                <a class="nav-item">
                Saved Posts
                </a>
                <span class="nav-item">
                <a class="button is-primary">
                    <span>Submit Feed</span>
                </a>
                </span>
            </div>
        <?php else : ?>
            <span class="nav-item">
                <a class="button is-primary">
                    <span>Log in</span>
                </a>
            </span>
        <?php endif; ?>
    </nav>
