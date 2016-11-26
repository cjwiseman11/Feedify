<?php
function connectToDatabase(){
    $root = $_SERVER['DOCUMENT_ROOT'];
    $config = parse_ini_file($root . '/../config.ini');
    $user = $config['username'];
    $pass = $config['password'];
    $dbname = $config['dbname'];
    $db = new PDO("mysql:host=localhost;dbname=$dbname",$user,$pass);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $db;
}
function getPostsById($id){
    
    $db = connectToDatabase();
    $statement = $db->prepare("SELECT * FROM `posts` WHERE id = :id");
    $statement->execute(array(':id' => $id));
    $row = $statement->fetchAll();
    return $row;
}
function getPostsByAll($limit, $offset){
    $db = connectToDatabase();
    $statement = $db->prepare("select * from posts ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $statement->execute(array(':limit' => $limit, ':offset' => $offset ));
    $row = $statement->fetchAll();
    return $row;
}
function getPostsByChan($chan, $limit, $offset){
    $db = connectToDatabase();
    $statement = $db->prepare("SELECT * FROM `posts` as c
        INNER JOIN `channelfeed-links` AS m
            ON m.newsfeedid = c.newsfeedid
        INNER JOIN `channels` as b
            ON m.channelid = b.id
        WHERE b.channame = :chan
        ORDER BY c.id DESC
        LIMIT :limit OFFSET :offset");
    $statement->execute(array(':chan' => $chan, ':limit' => $limit, ':offset' => $offset ));
    $row = $statement->fetchAll();
    return $row;
    
}