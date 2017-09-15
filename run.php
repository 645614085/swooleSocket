<?php
namespace swoole;

define("APP_PATH",__DIR__.'/');
include_once ("function.php");

class Run{

    private $dispatch = array();


    public function dispatch($path,$params){
        $config = env("default");

        $path = explode("/",$path);

        $path = array_filter($path);

        $controller = @$path[0]?strtolower(array_shift($params)).$config['controllerExtra']:$config['defaultController'];
        $controller = "\\swoole\\Controller\\".$controller;
        $action = @$path[0]?strtolower(array_shift($params)).$config['actionExtra']:$config['defaultAction'];

        if(!class_exists($controller)){
            die("controller <$controller> is undefined \n");
        }
        if(!method_exists($controller,$action)){
            die("action <$action> is undefined! \n");
        }
        if(!isset($this->dispatch[$controller])){
            echo "set Controller => $controller \n";
            $this->dispatch[$controller] = new $controller();
        }
        echo "dispatch \n";
        $this->dispatch[$controller]->$action($params);

    }


    public function loadClass($class){
        echo "class:",$class,"\n";
        $filename = end(explode("\\",trim($class,"\\")));
        $controllers = APP_PATH."Controller/".$filename.".php";
        if(file_exists($controllers)){
            echo $controllers."has include \n";
            include $controllers;
        }
    }


    public  function run($path,$params){
        spl_autoload_register(array($this, 'loadClass'));
        $this->dispatch($path,$params);
    }



}