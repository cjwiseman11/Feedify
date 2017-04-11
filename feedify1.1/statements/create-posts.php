<?php
    $limit = 10;
    $offset = 1;
    $results = getPostsByAll($limit, $offset);
    foreach($results as $row) {
        $checkTime = strtotime();
        $postTime = strtotime($row['date']);
        $diff = $checkTime - $postTime;
        echo $diff;
        include "templates/post.php"; //is this shit?
    }
?>
