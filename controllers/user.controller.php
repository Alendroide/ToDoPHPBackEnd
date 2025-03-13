<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../models/user.model.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController{
    
    private $model;

    public function __construct(){
        $this->model = new UserModel();
    }

    public function login(){
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->username) || !isset($data->password)) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Missing credentials"]));
        }
        if(!is_string($data->username) || !is_string($data->password) ) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Username and password must be a string"]));
        }
        if(strlen($data->username) > 20) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Username too long"]));
        }
        $user = $this->model->login($data);
        
        // JWT signing
        
        $key = 'pepelin';
        $payload = ["id"=>$user["id"],"username" => $user["username"]];

        $token = JWT::encode($payload,$key,"HS256");
        
        echo json_encode(["message" => "Logged in successfully", "access_token"=>$token]);
    }

    public function register(){
        $data = json_decode(file_get_contents("php://input"));
        if(!isset($data->username) || !isset($data->password)) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Missing credentials"]));
        }
        if(!is_string($data->username) || !is_string($data->password) ) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Username and password must be a string"]));
        }
        if(strlen($data->username) > 20) {
            header("HTTP/2 400");
            die(json_encode(["message"=>"Username too long"]));
        }
        $hash = password_hash($data->password,PASSWORD_BCRYPT);
        $data->password = $hash;
        $this->model->register($data);
        echo json_encode(["message" => "User created successfully"]);
    }
}

?>