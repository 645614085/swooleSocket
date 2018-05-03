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

    private $pool ;

    public $config = array();

    //构造方法私有，无法外部实例化
    private function __construct($config = array())
    {
        $this->config = $config;
        $this->pool = new \SplQueue();
        //$this->connect();
    }

    //唯一方式获取数据库连接对象
    public static function getInstance($config = array()){
        if(self::$instance==null){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * @param $mysql
     * 回收连接资源
     */
    public function put($mysql){
        $this->pool->push($mysql);
    }

    /**
     * @return mixed|null
     * 获取连接池中的数据库链接，协程
     */
    public function get(){
        if (count($this->pool)>0){
           return $this->pool->pop();
        }
        $this->connect();

        return $this->db;
    }


    //connect db
    //mysql 协程
    public function connect(){
        $dsn = sprintf('mysql:host=%s;dbname=%s',$this->config['dbHost'],$this->config['dbName']);
        $this->db = new \Swoole\Coroutine\MySQL($dsn,$this->config['dbUser'],$this->config['dbPwd']);
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