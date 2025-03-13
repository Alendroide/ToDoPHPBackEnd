<?php

require_once __DIR__."/../models/task.model.php";

class TaskController{
    
    private $model;

    public function __construct(){
        $this->model = new TaskModel();
    }

    public function create($userId){
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->name) || !isset($data->description)){
            header("HTTP/2 400");
            die(json_encode(["message"=>"Missing data"]));
        }
        if(!is_string($data->name) || !is_string($data->description)){
            header("HTTP/2 400");
            die(json_encode(["message"=>"Name and description must be strings"]));
        }
        $data->user = $userId;
        $this->model->create($data);
    }

}

?>