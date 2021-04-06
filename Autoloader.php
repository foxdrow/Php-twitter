<?php
namespace App;

class Autoloader{

    static function register(){

        spl_autoload_register([
            __CLASS__, 
            'autoload']);
    }

    static function autoload($class){
        
        $classPath = str_replace(__NAMESPACE__ . '\\', '', $class);
        $classPath = str_replace('\\', '/', $classPath);

        $fichier = __DIR__ . '/' . $classPath . '.php';
        if(file_exists($fichier)){
            require_once $fichier;
        }
    }
}