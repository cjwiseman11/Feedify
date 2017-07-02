<?php   
    $offset = $page - 1;
    $results = getChannelsList();

    foreach($results as $row) {
        include "templates/channel.php";
    }
?>
