<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-9-15
 * Time: 下午4:37
 */

namespace core;


class Loader
{
    public static function autoload($class){
        self::includeFile($class);
    }


    public static function register(){
        spl_autoload_register('core\\Loader::autoload',true,true);
    }

    public static function includeFile($class){
       //查找文件，PSR-4
        $filePlace = str_replace('\\','/',$class);
        $file= APP_PATH.$filePlace.".php";
        if(file_exists($file)){
            include $file;
            return true;
        }
        return false;
    }

    /**
     * 添加psr4空间命名
     */
    public static function addPsr4($namespace){

            return APP_PATH.$namespace."\\";
    }

}