<?php

$rowAll = getMembersFeeds($_SESSION["feedifyusername"]);

foreach($rowAll as $row){
  echo $rowAll["channame"]
}

?>
