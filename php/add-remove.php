<?php
include_once 'slq-statements.php';
session_start();
  $feed = $_GET['id'];
  $type = $_GET['type'];

  if($type == 'add'){
    addToMemberFeed($feed, $_SESSION["feedifyusername"]);
  } else if($type == 'remove'){
    removeFromMemberFeed($feed);
  }
?>
