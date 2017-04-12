<?php   
    $offset = $page - 1;
    $results = getPostsByAll($lim, $offset);

    foreach($results as $row) {
        include "templates/post.php"; //is this shit?
    }
?>
