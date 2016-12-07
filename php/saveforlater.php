<?php
include_once 'slq-statements.php';
session_start();
if(!isset($_SESSION['feedifyusername'])){
    echo "error";
} else {
  saveforlater($_GET['id'], $_SESSION['feedifyusername']);
}
?>
