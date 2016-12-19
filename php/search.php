<?php
include_once 'slq-statements.php';

$searchtype = $_GET['type'];
$searchvalue = $_GET['val'];

if($searchtype == "rows"){
  $returnData = searchFeeds($searchvalue);

  foreach($returnData as $row){
    $result .= "<p><a href class='result-item' title='add feed to rss box for submission'>" . $row["rsslink"] . "</a></p>";
  }
  echo $result;

} else if($searchtype == "url"){
  if (filter_var($searchvalue, FILTER_VALIDATE_URL) === FALSE) {
    echo "false";
  } else {
    echo "true";
  }
} else if($searchtype == "rss"){
  //Is this okay? To do.. ethically?
  $text = file_get_contents($searchvalue);
  $doc = new DOMDocument('1.0');
  libxml_use_internal_errors(true);
  $doc->loadHTML($text);
  foreach($doc->getElementsByTagName('link') AS $link) {
      $type = $link->getAttribute('type');
      $final = $link->getAttribute('href');
      if(strpos($type, 'rss') !== FALSE) {
        $result .= "<p><a href class='result-item'>$final</a></p>";
      } else if(strpos($type, 'atom') !== FALSE){
        $result .= "<p><a href class='result-item'>$final</a></p>";
      }
  }
  foreach($doc->getElementsByTagName('a') AS $anchor) {
      $href = $anchor->getAttribute('href');
      $final = $anchor->getAttribute('href');
      if(strpos($href, '.rss') !== FALSE) {
        $result .= "<p><a href class='result-item'>$final</a></p>";
      } else if(strpos($href, '.atom') !== FALSE){
        $result .= "<p><a href class='result-item'>$final</a></p>";
      }
    }
    echo $result;
}
