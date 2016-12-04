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

function getFullFeedList(){
    $db = connectToDatabase();
    $statement = $db->prepare("select * from newsfeeds");
    $statement->execute();
    $row = $statement->fetchAll();
    return $row;
}

function getFeedListForChan($chan){
    $db = connectToDatabase();
    $statement = $db->prepare("SELECT * FROM `newsfeeds` as c
        INNER JOIN `channelfeed-links` AS m
            ON m.newsfeedid = c.id
        INNER JOIN `channels` as b
            ON m.channelid = b.id
        WHERE b.channame = :chan");
    $statement->execute(array(':chan' => $chan));
    $row = $statement->fetchAll();
    return $row;
}

function getMemberID($username){
  $db = connectToDatabase();
  $memberid = $db->prepare("SELECT id FROM `members` WHERE username = :username");
  $memberid->execute(array(':username' => $username));
  $memberidrow = $memberid->fetch();
  return $memberidrow;
}

function saveforlater($postid,$username){
  $db = connectToDatabase();
  $memberidrow = getMemberId($username);
  $statement = $db->prepare("INSERT INTO `savedposts`(`memberid`, `postid`) VALUES (:memberid,:postid)");
  $statement->execute(array(':memberid' => $memberidrow["id"], ':postid' => $postid));
  //$row = $statement->fetchAll();
}

function getSavedPosts($username){
  $db = connectToDatabase();
  $statement = $db->prepare("SELECT * FROM `posts` as c
        INNER JOIN `savedposts` AS m
            ON m.postid = c.id
        INNER JOIN `members` as b
            ON m.memberid = b.id
        WHERE b.username = :username");
  $statement->execute(array(':username' => $username));
  $row = $statement->fetchAll();
  return $row;
}
