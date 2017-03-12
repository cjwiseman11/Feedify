<?php
include_once 'slq-statements.php';

//Connecting to sql db.
function compareTitleSimilarities($string, $postid){
    $db = connectToDatabase();
    $statement = $db->prepare("SELECT * FROM posts WHERE (`Date` > DATE_SUB(now(), INTERVAL 1 DAY));");
    $statement->execute();
    $row = $statement->fetchAll();

	foreach ($row as $row){
		similar_text($string, $row['title'], $percentage );
		if($percentage > 50){
			echo "Similar $percentage";
		}
	}
}


compareTitleSimilarities("Brexit: David Davis warns MPs to leave bill unchan", 1);
?>