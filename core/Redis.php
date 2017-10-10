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

    private $redis = null;

    private function __construct()
    {
        $this->redis = new \Redis();
        $redisConfig = env("redis");
        $this->redis->pconnect($redisConfig['host'], $redisConfig['port']);
    }


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function redis()
    {

        return $this->redis;

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