<?php
$rssvalue = $_GET['val'];

function rssValidate($rssvalue){
	libxml_use_internal_errors(true);
  $feed_to_array = simplexml_load_file($rssvalue);
  if(false === $feed_to_array){
    return false;
  } else {
    return true;
  }
}

if(rssValidate($rssvalue)){
  echo "true";
}
