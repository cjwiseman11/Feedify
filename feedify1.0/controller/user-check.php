<?php
if(isset($_COOKIE['rememberme'])){
    $_SESSION["feedifyusername"] = checkrememberme();
    $memberloggedin = true;
} else {
    $memberloggedin = false;
}
?>