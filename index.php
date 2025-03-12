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

        die(json_encode([ "message" => "Logged In" ]));
        break;
    case 'register':
        if($method != 'POST'){
            header("HTTP/2 400");
            die(json_encode([ "message" => "400 - Method not allowed" ]));
        }
        
        header("HTTP/2 201");
        die(json_encode([ "message" => "Registered" ]));
        break;
    default:
        if(file_exists($controllerName)){

            require_once $controllerName;
            $class = new $className;
        
            switch($method) {
                case 'GET':
                    $class->getAll();
                    break;
                case 'POST':
                    $class->create();
                    break;
                default:
                    header("HTTP/2 400");
                    die(json_encode([ "message" => "400 - Method not allowed"]));
                    break;
            }
        
        }
        else{
            header("HTTP/2 404");
            die(json_encode([ "message" => "404 - Not Found"]));
        }
        break;
}
?>