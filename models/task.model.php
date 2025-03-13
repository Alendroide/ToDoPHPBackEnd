<?php

require_once __DIR__."/../config/database.php";

class TaskModel{
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function create($data){
        // Create the task in db
        $sql = "INSERT INTO tasks(name,description,user) VALUES(?,?,?)";
        $stmt = $this->db->prepare($sql);
        
        // Bind params
        $stmt->bindParam(1,$data->name);
        $stmt->bindParam(2,$data->description);
        $stmt->bindParam(3,$data->user);

        // Success or 404
        if(!($stmt->execute())){
            header("HTTP/2 400");
            die(json_encode(["message" => "400 - Bad Request"]));
        }
        die(json_encode(["message"=>"Task created successfully"]));
    }

    public function getAll($userId){
        $sql = "SELECT * FROM tasks WHERE user = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1,$userId);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tasks; 
    }
}
?>