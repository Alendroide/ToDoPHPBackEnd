<?php

require_once __DIR__."/../config/database.php";

class UserModel{
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $sql = "SELECT username FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>