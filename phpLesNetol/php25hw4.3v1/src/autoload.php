<?php

define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function($filename){

    $rootpath = rtrim(__DIR__, DS) . DS;
    $filepath = str_replace('\\', DS,$filename) . '.php';
    $path = $rootpath . $filepath;

    if (file_exists($path)) {
        require_once $path;
    }
});