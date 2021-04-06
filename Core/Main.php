<?php

namespace App\Core;

use App\Controllers\UsersController;

class Main{

    public function start(){
        $URI = $_SERVER['REQUEST_URI'];

        if(!empty($URI) && $URI[-1] === '/' && $URI != '/'){
            $URI = substr($URI, 0, -1);

            http_response_code(301);

            header('Location: '.$URI);
        }
        
        $params = explode('/', $_GET['params']);

        if($params[0] != '' && $params[0] != "index"){
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)) . 'Controller';
            $controller = new $controller();

            $action = (isset($params[0])) ? array_shift($params) : 'index';
            
            if(method_exists($controller, $action)){

                (isset($params[0])) ? $controller->$action($params) : $controller->$action();

            }else{

            }

        }else{
            $userController = new UsersController;
            $userController->index();
        }
    }
}