<?php
include_once 'slq-statements.php';
session_start();
removeRememberMe($_SESSION["feedifyusername"]);
session_destroy();
header("location: ../" . $_GET['page']);
?>
