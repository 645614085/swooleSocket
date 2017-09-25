<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9
 * Time: 18:30
 */
namespace Controller;

class indexController
{
    public $params = null;

    public function __construct()
    {
        $this->params = "construct";

        echo "Controller>>>开始执行\n";
    }

    public function __destruct()
    {
        $this->params = "destruct";
        echo "Controller >>>结束执行 \n";
        // TODO: Implement __destruct() method.
    }

    public function indexAction($params)
    {
        echo $this->params;
       // echo "complete goto indexAction" . serialize($params), "\n";
        echo "执行任务中！！！\n";
    }
}