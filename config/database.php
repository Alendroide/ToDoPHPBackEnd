<?php

class Database{

    private $host = "localhost";
    private $port = "3306";
    private $username = "root";
    private $password = "";
    private $database = "pepeToDo";

    public $db;
    private $stmt;

    public function __construct(){
        try{
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->database";
            $this->db = new PDO( $dsn, $this->username, $this->password );
            $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(PDOException $e){
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function prepare($query){
        return $this->db->prepare($query);
    }
}

?>