<?php

require_once 'polaczenie.php';  //class polaczenie sets up connection to db.. 

class Tweet{
    
    public static $conn = null;
    private $id, $user_id, $tweet, $creation_date;
    
    public function __construct() {
        $this->id = -1;
        $this->user_id = 0; // -1 ?
        $this->tweet = '';
        $this->creation_date = '';
    }
    
    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getTweet() {
        return $this->tweet;
    }

    function getCreation_date() {
        return $this->creation_date;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    function setTweet($tweet) {
        $this->tweet = $tweet;
        return $this;
    }

    function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
        return $this;
    }

    public static function loadTweetById($id){
        $sql = "SELECT * FROM Tweets WHERE id = $id";
        $result = self::$conn->query($sql);
        if ( $result == true && $result->num_rows == 1 ) {
            $row = $result->fetch_assoc();
            $loadedTweet = new Tweet();
            $loadedTweet -> id = $row['id'];
            $loadedTweet -> user_id = $row['user_id'];
            $loadedTweet -> creation_date = $row['creation_date'];
            
            return $loadedTweet;
        }
        return null;
    }
    
}


$polaczenie = new prototypPolaczenia('warsztaty2');
Tweet::$conn = $polaczenie->getConn();


$ob = new Tweet();
//$ob = Tweet::loadTweetById(1);
var_dump($ob);
