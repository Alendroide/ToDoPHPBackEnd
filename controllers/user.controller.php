<?php

require_once __DIR__."/../models/user.model.php";

class UserController{
    
    private $model;

    public function __construct(){
        $this->model = new UserModel();
    }

    public function login(){
        $data = json_decode(file_get_contents("php://input"));
        $verified = $this->model->login($data);
        if($verified){
            echo json_encode(["message" => "Logged in successfully"]);
        }
        else{
            echo json_encode(["message" => "Incorrect username or password"]);
        }
    }

    public function register(){
        $data = json_decode(file_get_contents("php://input"));
        $hash = password_hash($data->password,PASSWORD_BCRYPT);
        $data->password = $hash;
        $this->model->register($data);
        echo json_encode($data);
    }
}

?>