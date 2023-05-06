<?php
namespace app;
use FFI\Exception;
session_start();
loader();

use core\Router;
use core\View;
use core\AttendanceInfo;

// Write info about visiting to 'info' folder
AttendanceInfo::writeGeneral();
AttendanceInfo::countUser();

// This is the main function. It runs the router and renders the 404 page if the router returns false and the 404 view exists.
if(Router::run() == false && View::hasView('404')){
    View::render('404');
}

// This is the loader function. It loads all the files and initializes the database.
function loader(){
    $rootPath = __DIR__.DIRECTORY_SEPARATOR;
    $_ENV['ROOT_PATH'] = $rootPath;
    $loadFunc = function($dir, $ignore = array()){
        $dir = str_replace('.', DIRECTORY_SEPARATOR, $dir);
        $files = scandir($dir);
        foreach($files as $file){
            if($file != '.' && $file != '..' && !in_array($file, $ignore) && is_file($dir.DIRECTORY_SEPARATOR.$file) && pathinfo($file, PATHINFO_EXTENSION) == 'php'){
                includeFile($dir.DIRECTORY_SEPARATOR.$file);
            }
        }
    };
    $loadFunc($rootPath.'config');
    $loadFunc($rootPath.'core.interfaces');
    includeFile($rootPath.'core'.DIRECTORY_SEPARATOR.'DB.php');
    $loadFunc($rootPath.'core.models');
    $loadFunc($rootPath.'models');
    $loadFunc($rootPath.'core');
    includeFile($rootPath.'providers'.DIRECTORY_SEPARATOR.'Provider.php');
    $loadFunc($rootPath.'providers');

    $loadFunc($rootPath.'controllers.Http');
    $loadFunc($rootPath.'controllers.API');

    includeFile(__DIR__ . DIRECTORY_SEPARATOR.'router.php');

    initDb();
}

// This function includes a file and replaces the directory separator with the correct one.
function includeFile($file){
    if(in_array($file, get_included_files()))
        return;
    if(file_exists($file)){
        if(DIRECTORY_SEPARATOR == '\\')
            include_once str_replace('/', DIRECTORY_SEPARATOR, $file);
        else
            include_once str_replace('\\', DIRECTORY_SEPARATOR, $file);
    }else{
        throw new Exception("File not found: $file");
    }
}

// This function initializes the database by creating the tables.
function initDb(){
    $providersPath = __DIR__.DIRECTORY_SEPARATOR.'providers';
    $files = scandir($providersPath);
    foreach($files as $file){
        if($file != '.' && $file != '..' && $file != 'Provider.php'){
            $provider = 'app\providers\\'.str_replace('.php', '', $file);
            $provider = new $provider();
            $provider->createTable();
        }
    }
}