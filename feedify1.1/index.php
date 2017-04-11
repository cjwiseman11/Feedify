<?php if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start(); session_start(); include_once 'statements/slq-statements.php';
if(isset($_COOKIE['rememberme'])){
    $_SESSION["feedifyusername"] = checkrememberme();
}
//include 'php/getQueryStringParams.php';
include "templates/header.php";
include "templates/controlbox.php";

include "statements/create-posts.php";

include "templates/footer.php";
?>