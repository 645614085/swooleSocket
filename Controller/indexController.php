<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9
 * Time: 18:30
 */
namespace Controller;

use core\Redis;
use Model\testModel;

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
       // var_dump(testModel::where(['c1'=>2])->select());
        var_dump(testModel::add(['c1'=>'aaa','c2'=>'bbbb','c3'=>'cccc']));
        var_dump(Redis::getInstance()->redis()->keys("*"));
    }
}