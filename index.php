<?php
use App\Autoloader;
use App\Core\Main;

define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once ROOT.'/Autoloader.php';
Autoloader::register();

if(strstr(substr($_SERVER['REQUEST_URI'], 1), '/', true) === "index"){
    $url = substr(strstr(substr($_SERVER['REQUEST_URI'], 1), '/'), 1);
    $url = ["params" => $url];
    $_GET = $url;
} else {
    $url = substr($_SERVER['REQUEST_URI'], 1);
    $url = ["params" => $url];
    $_GET = $url;
}

$app = new Main();

$app->start();

