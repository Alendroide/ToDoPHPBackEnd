<?php

require_once __DIR__."/../config/database.php";

class UserModel{
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function login($data){
        // Search user in database
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$data->username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If not found, 404
        if(!isset($user["password"])) die(json_encode(["message" => "404 - Not Found"]));
        // If found, compare passwords
        if(password_verify($data->password,$user["password"])) return true;
        
        // If the passwords don't match, return false
        return false;
    }

    public function register($data){

        // Check if user already exists on database
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$data->username);
        $stmt->execute();
        $existingUser = $stmt->fetch();
        if(isset($existingUser["username"])) die(json_encode(["message" => "400 - Bad Request"]));

        // If it doesn't, register the user
        $sql = "INSERT INTO users(username,password) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$data->username);
        $stmt->bindParam(2,$data->password);
        if(!($stmt->execute())){
            die(json_encode(["message" => "400 - Bad Request"]));
        }
    }
}
?>