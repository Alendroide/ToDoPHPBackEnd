<?php

// JWT DECODING

require_once __DIR__."/vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyToken() {
    if(!isset((getallheaders())["Authorization"])) {
        header("HTTP/2 403");
        die(json_encode(["message" => "Token not provided"]));
    }
    if(!isset(explode(" ",((getallheaders())["Authorization"]))[1])){
        header("HTTP/2 400");
        die(json_encode(["message" => "Token malformed"]));
    }
    $key = 'pepelin';
    $jwt = explode(" ",((getallheaders())["Authorization"]))[1];
    $headers = new stdClass();
    try{
        $decoded = JWT::decode($jwt,new Key($key,'HS256'),$headers);
    }
    catch(DomainException $error){
        header("HTTP/2 403");
        die(json_encode(["message" => "Invalid token"]));
    }
    return ($decoded->id);
}

// Response logic

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
        
        // Decode token
        $userId = verifyToken();
        
        require_once __DIR__."/controllers/task.controller.php";
        $task = new TaskController;

        if($method == 'POST'){
            $task->create($userId);
        }
        
        break;
    
    default:
        header("HTTP/2 404");
        die(json_encode([ "message" => "404 - Not Found"]));
        break;
}
?>