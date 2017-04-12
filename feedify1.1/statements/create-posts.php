<?php
    include "statements/querystring-reader.php";
    $offset = 0;
    $results = getPostsByAll($lim, $offset);
    foreach($results as $row) {
        include "templates/post.php"; //is this shit?
    }
?>
