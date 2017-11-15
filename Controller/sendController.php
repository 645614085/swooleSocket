<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-11-14
 * Time: 下午5:59
 */

namespace Controller;


use Ext\Server;

class sendController
{
    public function indexAction(){

        Server::send("send a string for replay");
    }


    public function testAction($params){


    }
}
