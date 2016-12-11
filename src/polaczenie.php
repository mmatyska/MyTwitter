<?php
 
class prototypPolaczenia {
    protected $ip = '127.0.0.1';
    protected $user = 'marcin';
    protected $password = 'zxc123';
    protected $database = '';
 
    /** @var mysqli|null */
    protected $conn = null;
    //$result = self::$conn->query($sql);  
    public function __construct($database = '')
    {
        $this->conn = mysqli_connect($this->ip, $this->user, $this->password, $this->database = $database);
        if ($this->conn->connect_error) {
            echo $this->conn->connect_error;
        }
        return $this;                                   //none..........
    }
 
    function __destruct()
    {
        $this->conn->close();
        $this->conn = null;
    }
 
    public function getConn()
    {
        //var_dump($this->conn);
        return $this->conn;
    }
 
    /**
     * 
     * @param type $sql
     * @return boolean
     */
    
    protected function boolQuery($sql)                                      
    {
        if (!$this->conn->query($sql)) {
            echo $this->conn->error;
            return false;
        }
        return $this->conn->insert_id;                                      //uwaga...
    }
 
    public function createDatabase($database = 'test')
    {
        $dbSelected = mysqli_select_db($this->conn, $database);
        if (!$dbSelected) {
            if (!$this->conn->query('CREATE DATABASE ' . $database)) {        
                echo $this->conn->error;
                return false;
            }
        }
        return true;
    }
 
    public function createTable($tableName)
    {
        if (!$this->conn->query('DESCRIBE ' . $tableName)) {
            $sql = "CREATE TABLE $tableName (id int AUTO_INCREMENT, PRIMARY KEY(id))ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";
            return $this->boolQuery($sql);
        }
        return true;
    }
 
    public function deleteFromTable($tableName)
    {
        $sql = "DELETE FROM " . $tableName;
        return $this->boolQuery($sql);
    }
 
    public function addColumn($tableName, array $args)
    {
        $sql = "ALTER TABLE $tableName ADD " . implode(' ', $args);
        return $this->boolQuery($sql);
    }
 
    public function modifyColumn($tableName, array $args)
    {
        $sql = "ALTER TABLE $tableName MODIFY COLUMN " . implode(' ', $args);
        return $this->boolQuery($sql);
    }
 
    public function deleteColumn($tableName, $args)
    {
        $sql = "ALTER TABLE $tableName DROP COLUMN $args";
        return $this->boolQuery($sql);
    }
 
    public function deleteTable($name = 'test')
    {
        $sql = "DROP TABLE " . $name;
        return $this->boolQuery($sql);
    }
 
    public function deleteDatabase($name = 'test')
    {
        $sql = "DROP DATABASE " . $name;
        return $this->boolQuery($sql);
    }
    
    public function showTables(){
        $sql = "SHOW TABLES ";
        $showTab = [];
        if ($result = $this->conn->query($sql)) {
            foreach ($result as $row) { 
                foreach($row as $r){
                    $showTab[] = $r;
                }   
            }
        } else {
            echo $this->conn->error;
            return false;
        }
        return $showTab;
    }
    
    
    public function describeTable($tableName){
        $sql = "describe $tableName";
        $describedTab = [];
        if($result = $this->conn->query($sql)){
            foreach ($result as $row) { 
                if($row['Field'] != 'id'){
                   $describedTab[] = $row['Field']; 
                }
            }
        } else {
            echo $this->conn->error;
            return false;
        }
        return $describedTab;
    }    
   
    protected function showGeneral($sql){
        
        $returnTab = [];
        if ($result = $this->conn->query($sql)) {
            foreach ($result as $row) {
                $returnTab[] = $row;
            }
        } else {
            echo $this->conn->error;
            return false;
        }
        return $returnTab;
    }

    /**
     * 
     * @param type $var
     * @return type
     */
    public function show($var){
        $sql = "SELECT * FROM ".$var;
        return $this->showGeneral($sql);
    }
    
    
    public function showIfFound($var, $condition){
        $sql = "SELECT * FROM ".$var." WHERE ".$condition;
        return $this->showGeneral($sql);
    }
    
    public function czystySql($var){
        $sql = $var;
        return $this->showGeneral($sql);
    }
    
    /*
    //do przemyślenia / do zrobienia metoda .... + jakaś funkcja autoinkrementująca ??
    SELECT $table1.$field['$setField'] 
          from 
              $table1 
          INNER JOIN 
              $table2 
          ON 
              $table1.$field['fk1'] = $table2.$field['pk'] 
          WHERE 
              $table2.$field['pk'] = $idSearched;
    */
    public function showJoined1toMany($table1, $table2 ,$field1, $field2, $setField, $idSearched){
        
    }
}
