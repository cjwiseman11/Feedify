<?php
	// Load configuration file outside of doc root
	$root = $_SERVER['DOCUMENT_ROOT'];
	$config = parse_ini_file($root . '/../config.ini'); 

	//Connecting to sql db.
	$connection = mysqli_connect("localhost",$config['username'],$config['password'],$config['dbname']);
	if($connection === false){
		//TODO: Add error
	}

    $ids_array = array();

    $result = mysqli_query($connection,"SELECT id FROM posts WHERE date > DATE_SUB(NOW(), INTERVAL 1 WEEK)") or die("Error in Selecting " . mysqli_error($connection));


    while($row = mysqli_fetch_array($result))
    {
        $ids_array[] = $row['id'];
    }

    $randomentry = $ids_array[array_rand($ids_array)];

    $randomLink = mysqli_query($connection,"SELECT link FROM posts WHERE id = $randomentry") or die("Error in Selecting " . mysqli_error($connection));
    
    while($row = mysqli_fetch_array($randomLink)){
       $randomLinkString = $row['link'];
        break;
    }

	//close the db connection
	mysqli_close($connection);

    echo json_encode($randomLinkString);
?>