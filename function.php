<?php
/**
 * 公共函数文件
 */


if(!function_exists("env")){
    function env($config){
        $file = APP_PATH."config/".$config.".php";
        if(file_exists($file)){
            $data = require ($file);
        }else{
            $data = array();
        }
        return $data;
    }
}