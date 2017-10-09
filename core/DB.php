<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-9
 * Time: 上午9:45
 */

namespace core;


class DB
{
    //声明句炳变量，保存当前连接
    private static $instance = null;

    //数据库连接句炳
    private $db = null;

    public $config = array();

    //构造方法私有，无法外部实例化
    private function __construct($config = array())
    {
        $this->config = $config;
        $this->connect();
    }

    //唯一方式获取数据库连接对象
    public static function getInstance($config = array()){
        if(self::$instance==null){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    //获取数据库句炳
    public function db(){
        return $this->db;
    }

    //connect db
    public function connect(){
        $dsn = sprintf('mysql:host=%s;dbname=%s',$this->config['dbHost'],$this->config['dbName']);
        $this->db = new \PDO($dsn,$this->config['dbUser'],$this->config['dbPwd']);
    }

    //防止科隆
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    //防止重建
    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }


}