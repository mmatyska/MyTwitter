<?php

require_once 'polaczenie.php';
require_once 'SqlBasicSets.php';
//vdoc
class User extends SqlBasicSets{

    /**
     *
     * @var mysqli | null 
     */
    //public static $conn = null;   //w klasie rodzicu
    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->email = "";
        $this->hashedPassword = "";
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getHashedPassword() {
        return $this->hashedPassword;
    }

    function getEmail() {
        return $this->email;
    }

//    function setId($id) {
//        $this->id = $id;
//    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setHashedPassword($hashedPassword) {
        $this->hashedPassword = password_hash($hashedPassword, PASSWORD_BCRYPT);
    }

    function setEmail($email) {
        $this->email = $email;
    }

    public function saveToDb() {
        if ( self::$conn != NULL ) {                                //
            if ( $this->id == -1 ) {
                $sql = "INSERT INTO Users (username, email, hashedPassword)"
                        . " values('$this->username', '$this->email', '$this->hashedPassword')";
                $result = self::$conn->query($sql);                 //połączenie do bazy    
                
                if ( $result == true ) {                            //pobieram ostatni id i przypisuje do mojego id
                    //var_dump($this->id);
                    //echo('bbb');
                    $this->id = self::$conn->insert_id;
                    return true;
                }
            } else {

                $sql = "UPDATE Users SET "
                        . "username = '$this->username', "
                        . "email = '$this->email', "
                        . "hashedPassword = '$this->hashedPassword'"
                        . " where id = $this->id";

                $result = self::$conn->query($sql);                 //połączenie do bazy

                if ( $result == true ) {
                    //$this->id = self::$conn->insert_id;
                    return true;
                }
            }
        } else {
            echo "Brak połączenia\n";
        }
        return false;
    }

    public static function loadUserById($id) {
        
        $columns = self::describeTable('Users');
        $sql = "SELECT * FROM Users WHERE id=$id";
        $result = self::$conn->query($sql);
       
        if ( $result == true && $result->num_rows == 1 ) {
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            foreach($columns as $col){
                $loadedUser->$col = $row["$col"];
            }
            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers() {     //wrzucam całą tabelę więc parametr jest zbędny
        $columns = self::describeTable('Users');
        $sql = "SELECT * FROM Users";
        $returnTable = [];
        
        if ( $result = self::$conn->query($sql) ) {
            foreach ( $result as $row ) {              
                
                $loadedUser = new User();
                foreach($columns as $col){
                    $loadedUser->$col = $row["$col"];
                }
                
                $returnTable[] = $loadedUser;
            }
        }
        return $returnTable;
    }   
    
    public function delete() {
        if ( $this->id != -1 ) {

            if ( self::$conn->query("DELETE FROM Users WHERE id=$this->id") ) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return $this;   //for chaining..
    }

}

//$conn = new prototypPolaczenia('warsztaty2');
//User::$conn = $conn->getConn();
////$ob = new User();
//var_dump($ob = User::loadUserById(19));
//var_dump($ob = User::loadAllUsers());
////var_dump($ob);
////$ob->setId(1);
//$ob->setUsername('Marcin');
//$ob->setEmail('marcin75@gmail.com');
////
//$ob->setHashedPassword('zxc123');
//$ob->saveToDb();


//$obj1 = new User();
//$obj1 = User::loadUserById(20);
//$obj1->setUsername('Jan');
//$obj1->setEmail('jan1455@wp.pl');
//$obj1->setHashedPassword('1234');
//$obj1->saveToDb();
//$obj1->delete();

//var_dump($obj1 = User::loadUserById(7));
//$obj1->setUsername('Andrzej');
//$obj1->saveToDb();
//echo $obj1->getEmail();

//var_dump(User::loadAllUsers());         //?? zadziała też user::loadAllUsers()  //(user z małej litery...)
//$ob->
//var_dump(User::loadAllUsers());
//$ob = User::loadUserById(18);
//$ob->setEmail('janusz1989@wp.pl');
//$ob->delete();
//$ob->saveToDb();
//var_dump($ob->getId());
