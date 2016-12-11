<?php

require_once 'polaczenie.php';  //class polaczenie sets up connection to db.. 
require_once 'SqlBasicSets.php';
    
class Tweet extends SqlBasicSets{
    
    //public static $conn = null;   //w klasie rodzicu
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
        
        $columns = self::describeTable('Tweets');
        $sql = "SELECT * FROM Tweets WHERE id = $id";
        $result = self::$conn->query($sql);
        
        if ( $result == true && $result->num_rows == 1 ) {
            $row = $result->fetch_assoc();
           
            $loadedTweet = new Tweet();
            foreach($columns as $col){
                $loadedTweet->$col = $row["$col"];
            }           
            return $loadedTweet;
        }
        return null;
    }
    
    public static function loadAllTweetsByUserId($user_id){             
        $columns = self::describeTable('Tweets');                   //pobrane kolumny danej tabeli
        $sql = "SELECT * FROM Tweets WHERE user_id = $user_id";
        $returnTable = [];

        if ( $result = self::$conn->query($sql) ) {
            foreach ( $result as $row ) {                                                       
                $loadedTweets4user = new Tweet();
                foreach($columns as $col){
                    $loadedTweets4user->$col = $row["$col"];
                }
                $returnTable[] = $loadedTweets4user;
            }
            return $returnTable;
        }
        return null;
    }
    
    public static function loadAllTweets(){
        $columns = self::describeTable('Tweets');
        
        $sql = "SELECT * FROM Tweets";
        $returnTable = [];
        if ( $result = self::$conn->query($sql) ) {
            foreach ( $result as $row ) {
                $allTweets = new Tweet();
                foreach($columns as $col){
                    $allTweets->$col = $row["$col"];
                }
                $returnTable[] = $allTweets;
            }
            return $returnTable;
        }
    }
    
        public function saveToDb() {
        if ( self::$conn != NULL ) {                                //
            if ( $this->id == -1 ) {
                $sql = "INSERT INTO Tweets (user_id, tweet, creation_date)"
                        . " values('$this->user_id', '$this->tweet', '$this->creation_date')";
                $result = self::$conn->query($sql);                 //połączenie do bazy    
                
                if ( $result == true ) {                            //pobieram ostatni id i przypisuje do mojego id

                    $this->id = self::$conn->insert_id;
                    return true;
                }
            } else {

                $sql = "UPDATE Tweets SET "
                        . "user_id = '$this->user_id', "
                        . "tweet = '$this->tweet', "
                        . "creation_date = '$this->creation_date'"
                        . " where id = $this->id";

                $result = self::$conn->query($sql);

                if ( $result == true ) {
                    return true;
                }
            }
        } else {
            echo "Brak połączenia\n";
        }
        return false;
    }
    
}


//$polaczenie = new prototypPolaczenia('warsztaty2');
//Tweet::$conn = $polaczenie->getConn();
//
//
//$ob = new Tweet();
//$ob = Tweet::loadTweetById(1);
//$ob->setTweet('zmiana treści tego tweeta');
//$ob->saveToDb();
//var_dump(Tweet::loadAllTweetsByUserId(19));
//var_dump(Tweet::loadAllTweets());
//var_dump(Tweet::loadTweetById(1));


//$ob->describeTable('Users');

//var_dump($ob->describeTable('Tweets'));