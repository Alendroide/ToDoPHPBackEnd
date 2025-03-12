<?php

require_once __DIR__."/../models/user.model.php";

class UserController{
    
    private $model;

    public function __construct(){
        $this->model = new UserModel();
    }

    public function getAll(){
        $data = $this->model->getAll();
        echo json_encode($data);
    }

    public function create(){
        echo("Hola");
    }
}

?>