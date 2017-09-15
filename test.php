<?php

class A
{

    public function __construct()
    {
        echo "开始一个类\n";
    }

    public function handel(){
        echo "执行这个函数\n";
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        echo "结束一个类 \n";
    }

}


$a = new  A();
$a->handel();
for($i=0;$i<10;$i++){
    echo "已经等待 $i.......\n";
}
echo "结束。\n";

?>
