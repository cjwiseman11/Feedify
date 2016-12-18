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
    $statement = $db->prepare("SELECT c.* FROM `posts` as c
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
  $statement = $db->prepare("SELECT * FROM newsfeeds");
  $statement->execute();
  $row = $statement->fetchAll();
  return $row;
}

function getMemberFeedList($username){
  $db = connectToDatabase();
  $row = getMemberId($username);
  $statement = $db->prepare("SELECT * FROM newsfeeds
                              WHERE id NOT IN (SELECT feedid FROM `memberfeeds`
                                WHERE `memberid` = :memberid)");
  $statement->execute(array(':memberid' => $row["id"]));
  $row = $statement->fetchAll();
  return $row;
}

function getFeedListForChan($chan){
    $db = connectToDatabase();
    $statement = $db->prepare("SELECT c.* FROM `newsfeeds` as c
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

function getUsernamefromID($memberid){
  $db = connectToDatabase();
  $memberusername = $db->prepare("SELECT `username` FROM `members` WHERE id = :memberid");
  $memberusername->execute(array(':memberid' => $memberid));
  $result = $memberusername->fetchAll();
  return $result[0]["username"];
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
  $statement = $db->prepare("SELECT c.* FROM `posts` as c
        INNER JOIN `savedposts` AS m
            ON c.id = m.postid
        INNER JOIN `members` as b
            ON b.id = m.memberid
        WHERE b.username = :username");
  $statement->execute(array(':username' => $username));
  $row = $statement->fetchAll();
  return $row;
}

function isSavedPost($username, $postid){
  $memberid = getMemberID($username);
  $isSaved = false;
  $db = connectToDatabase();
  $statement = $db->prepare("SELECT * FROM `savedposts` WHERE postid = :postid AND memberid = :memberid");
  $statement->execute(array(':postid' => $postid, ':memberid' => $memberid["id"]));
  if($statement->rowCount() > 0) {
    $isSaved = true;
  }
  return $isSaved;
}

function removeSavedPost($username, $postid){
  $memberid = getMemberID($username);
  $db = connectToDatabase();
  $statement = $db->prepare("DELETE FROM `savedposts` WHERE postid = :postid AND memberid = :memberid");
  $statement->execute(array(':postid' => $postid, ':memberid' => $memberid["id"]));
}

function registerUser($username, $password, $email){
  $hash = crypt($password);
  $db = connectToDatabase();
  $statement = $db->prepare("INSERT INTO `members`(`username`,`password`,`email`) VALUES (:username, :password, :email)");
  $statement->execute(array(':username' => $username, ':password' => $hash, ':email' => $email));
}

function userExists($username, $email){
  $db = connectToDatabase();
  $statement = $db->prepare("  SELECT * FROM `members` WHERE username = :username OR email = :email");
  $statement->execute(array(':username' => $username, ':email' => $email));
  if($statement->rowCount() > 0) {
    $isUser = true;
  } else {
    $isUser = false;
  }
  return $isUser;
}

function getUserPassword($username){
  $db = connectToDatabase();
  $statement = $db->prepare("SELECT `password` FROM `members` WHERE username = :username LIMIT 1");
  $statement->execute(array(':username' => $username));
  $row = $statement->fetchAll();
  return $row;
}

function setKeepLoggedIn($username){
  $memberid = getMemberID($username);
  $token = crypt($username);
  $db = connectToDatabase();
  $statement = $db->prepare("INSERT INTO `keeploggedin`(`memberid`,`token`) VALUES (:memberid, :token)");
  $statement->execute(array(':memberid' => $memberid["id"], ':token' => $token));
  $cookie = $memberid["id"] . ':' . $token;
  setcookie('rememberme', $cookie, time()+60*60*24*30, "/");
}

function rememberMe() {
    $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
    if ($cookie) {
        list ($memberid, $token) = explode(':', $cookie);
        $username = getUsernamefromID($memberid);
        if (!(crypt($username, $token) == $token)) {
            return false;
        }

        $usertokenrows = fetchTokenByUserName($username);
        foreach($usertokenrows as $row){
          if ($row["token"] == $token) {
              return $token;
              break;
          }
        }
    }
}

function fetchTokenByUserName($username){
  $memberid = getMemberID($username);
  $db = connectToDatabase();
  $statement = $db->prepare("SELECT `token` FROM `keeploggedin` WHERE memberid = :memberid");
  $statement->execute(array(':memberid' => $memberid["id"]));
  $row = $statement->fetchAll();
  return $row;
}

function checkrememberme(){
  $token = rememberMe();
  if($token){
      $db = connectToDatabase();
      $statement = $db->prepare("SELECT m.* FROM `members` AS m
                  INNER JOIN `keeploggedin` AS k
                      ON k.memberid = m.id
                  WHERE k.token = :token");
      $statement->execute(array(':token' => $token));
      $row = $statement->fetchAll();
      return $row[0]["username"];
  }
}

function removeRememberMe($username){
  if (isset($_COOKIE['rememberme'])) {
    //unset($_COOKIE['rememberme']);
    setcookie('rememberme', null, -1, '/');
    $db = connectToDatabase();
    $memberid = getMemberID($username);
    $statement = $db->prepare("DELETE FROM `keeploggedin` WHERE memberid = :memberid");
    $statement->execute(array(':memberid' => $memberid["id"]));
  }
}

function getChannelsList(){
  $db = connectToDatabase();
  $statement = $db->prepare("SELECT * FROM `channels` ORDER BY id ASC");
  $statement->execute();
  return $statement->fetchAll();
}

function getFeedsByUser($username){
  $db = connectToDatabase();
  $memberid = getMemberId($username);
  $statement = $db->prepare("SELECT n.* FROM `newsfeeds` AS n
    INNER JOIN `memberfeeds` AS k
    ON k.feedid = n.id
    WHERE k.memberid = :memberid
    ORDER BY id ASC");
  $statement->execute(array(':memberid' => $memberid["id"]));
  return $statement->fetchAll();
}

function addToMemberFeed($feed, $user){
  $db = connectToDatabase();
  $row = getMemberID($user);
  $statement = $db->prepare("INSERT INTO `memberfeeds`(`memberid`, `feedid`) VALUES (:memberid, :feedid)");
  $statement->execute(array(':feedid' => $feed, ':memberid' => $row["id"]));
}

function removeFromMemberFeed($feed, $user){
  $db = connectToDatabase();
  $row = getMemberID($user);
  $statement = $db->prepare("DELETE FROM `memberfeeds` WHERE `feedid`=:feedid AND `memberid`=:memberid");
  $statement->execute(array(':feedid' => $feed, ':memberid' => $row["id"]));
}
