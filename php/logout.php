<?php
session_start();
session_destroy();
header("location: ../" . $_GET['page']);
?>
