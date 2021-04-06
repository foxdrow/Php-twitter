<?php
namespace App\Controllers;

abstract class Controller{

    public function render(string $pathView, $data = []){
        require_once ROOT.'/Views/'.$pathView.'.php';
    }
}