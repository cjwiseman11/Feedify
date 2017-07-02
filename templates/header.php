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
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
      <nav class="nav">
        <div class="nav-left">
            <a href="?chan=all" title="home" id="home" class="nav-item">Feedify</a>
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
        <?php if(isset($_SESSION['feedifyusername'])): ?>
        <span class="nav-toggle">
            <p>Menu</p>
        </span>
        <div class="nav-right nav-menu">
            <a href="?c=home" class="nav-item">Home</a>
            <a href="?c=savedposts" class="nav-item">Saved Posts</a>
            <a href="statements/logout.php" class="nav-item">Logout</a>
            <span class="nav-item">
                <a href="?c=feeds" class="button is-primary">
                    <span>Submit Feed</span>
                </a>
            </span>
        </div>
        <?php else : ?>
        <span class="nav-toggle">
            <p>Log in</p>
        </span>
        <div class="nav-right nav-menu">
            <form class="nav-item" method="post" action="statements/checklogin.php">
                <span>
                    <div class="field">
                        <p class="control">
                            <input name="username" class="input username" type="text" placeholder="Username">
                        </p>
                    </div>
                </span>
                <span>
                    <div class="field">
                        <p class="control">
                            <input name="password" class="input password" type="password" placeholder="Password"> 
                        </p>
                    </div>
                </span>
                <span>
                    <div class="field">
                        <p class="control">
                            <label class="checkbox">
                            <input name="rememberme" type="checkbox">Remember me</label>
                        </p>
                    </div>
                </span>
                <span>
                    <button type="submit" class="button is-primary">Login</button>
                </span>
            </form>
        </div>
        <?php endif; ?>
    </nav>
