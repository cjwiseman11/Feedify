<?php

    if($_GET['c'] == "savedposts"){
        $results = getSavedPosts($_SESSION['feedifyusername']);
    } else {
        $offset = $page - 1;
        if($chan == "all"){
            $results = getPostsByAll($lim, $offset);
        } else {
            $results = getPostsByChan($chan, $lim, $offset);
        }
    }

    foreach($results as $row) {
        include "templates/post.php"; //is this shit?
    }
?>