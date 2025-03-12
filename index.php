<?php

header("Content-type: application/json");

$URI = explode("/",$_SERVER["REQUEST_URI"]);
$table = strtolower($URI[2]);
$method = $_SERVER["REQUEST_METHOD"];

$className = ucfirst($table)."Controller";
$controllerName = __DIR__."/controllers/".$table.".controller.php";

switch($table){
    case 'login':
        if($method != 'POST'){
            header("HTTP/2 400");
            die(json_encode([ "message" => "400 - Method not allowed" ]));
        }

        require_once __DIR__."/controllers/user.controller.php";
            $class = new UserController;
        die($class->login());
        break;
    
    case 'register':
        if($method != 'POST'){
            header("HTTP/2 400");
            die(json_encode([ "message" => "400 - Method not allowed" ]));
        }
        
        require_once __DIR__."/controllers/user.controller.php";
            $class = new UserController;
        die($class->register());
        break;
    
    case 'tasks':
        header("HTTP/2 404");
        die(json_encode([ "message" => "404 - Not Found"]));
        break;
    
    default:
        header("HTTP/2 404");
        die(json_encode([ "message" => "404 - Not Found"]));
        break;
}
?>