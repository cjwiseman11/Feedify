<?php if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start(); session_start(); include_once 'statements/slq-statements.php';
if(isset($_COOKIE['rememberme'])){
    $_SESSION["feedifyusername"] = checkrememberme();
}
include 'statements/querystring-reader.php';

include "templates/header.php"; //nav, hero and <head>
include "templates/controlbox.php";
include "templates/postcontainer.php";
include "templates/pagination.php";
include "templates/footer.php";
?>