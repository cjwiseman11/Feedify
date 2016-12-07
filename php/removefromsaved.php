<?php
include_once 'slq-statements.php';
session_start();
removeSavedPost($_SESSION['feedifyusername'], $_GET['id']);

return true;
?>
