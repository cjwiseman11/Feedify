<?php if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start(); session_start(); include_once "models/locations.php";include_once "$controllerloc/slq-statements.php";

//Check user is logged in and has rememberme
include "$controllerloc/user-check.php";

//Get QueryString Variables e.g. p=1&lim=10
include "$controllerloc/save-qs-variables.php";

//Load posts
include "$viewsloc/posts.php";

if($memberloggedin){
    include "$viewsloc/member-loggedin.html";
}
?>