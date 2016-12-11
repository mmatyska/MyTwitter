<?php

require_once 'polaczenie.php';

class SqlBasicSets{
    public static $conn = null;
    
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
    
    
    public static function describeTable($tableName){
        $sql = "describe $tableName";
        $describedTab = [];
        if($result = self::$conn->query($sql)){
            foreach ($result as $row) { 
                //if($row['Field'] != 'id'){            
                   $describedTab[] = $row['Field']; 
                //}
            }
        } else {
            echo self::$conn->error;
            return false;
        }
        return $describedTab;
    }    
   
    protected function showGeneral($sql){
        
        $returnTab = [];
        if ($result = self::$conn->query($sql)) {
            foreach ($result as $row) {
                $returnTab[] = $row;
            }
        } else {
            echo self::$conn->error;
            return false;
        }
        return $returnTab;
    }

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
    
    public function showJoined1toMany($table1, $table2 ,$field1, $field2, $setField, $idSearched){
        
    }
}


/*
$polaczenie = new prototypPolaczenia('warsztaty2');
SqlBasicSets::$conn = $polaczenie->getConn();

$a = new SqlBasicSets();
//var_dump(SqlBasicSets::$conn = $polaczenie->getConn());
$a->describeTable('Users');

var_dump($a->describeTable('Tweets'));
 */