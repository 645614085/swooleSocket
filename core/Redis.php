<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-10
 * Time: 下午2:20
 */

namespace core;


class Redis
{

    private static $instance = null;

    private $pool ;

    private function __construct()
    {
        $this->pool = new \SplQueue();
    }


    public function put($redis)
    {
        $this->pool->push($redis);
    }

    public function get(){
        if (count($this->pool)>0){
            return $this->pool->pop();
        }

        $redis = new \Swoole\Coroutine\Redis();
        $redisConfig = env('redis');
        return $redis->connect($redisConfig['host'],$redisConfig['port']);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
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