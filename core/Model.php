<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-9-25
 * Time: 下午5:49
 */

namespace core;


class Model
{

    private $_instance = null;

    protected  $table = null;

    private $modelParams = array();

    private $sql = array();

    public function __construct()
    {
       $config = env("database");
       $this->_instance = DB::getInstance($config);
    }


    public function __call($name, $arguments)
    {
        echo "CALL: \n";
        if(method_exists($this,"model".ucfirst($name))){
            return call_user_func_array([$this,"model".ucfirst($name)],$arguments);
        }
        return false;
    }

    public static function __callStatic($name, $arguments)
    {
        echo "CALLSTATIC:\n";
        $model = new static();
        if(method_exists($model,"model".ucfirst($name))){
            return call_user_func_array([$model,"model".ucfirst($name)],$arguments);
        }
    }

    public function executeQuery($sql){//需要添加断线重连
        echo $sql,"\n";
        $result = $this->_instance->db()->prepare($sql);
        $result->execute($this->modelParams);
        var_dump($this->modelParams);
        if(end($result->errorInfo())=="MySQL server has gone away"){//断线重连
            $this->_instance->connect();
            $result = $this->_instance->db()->prepare($sql);
            $result->execute($this->modelParams);
        }
        $this->modelParams = array();
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        return $result->fetchall();
    }


    /**
     * @param array $params
     * curd
     */

    //add
    public function modelAdd($params = array()){
        $column = "";
        $values = "";
        foreach($params as $key=>$val){
            $column .= "`$key`, ";
            $values .= ":".$key."Value, ";
            $this->modelParams[":".$key."Value"]=$val;
        }
        $column = rtrim($column,", ");
        $values = rtrim($values,", ");
        $sql = "insert into ".$this->table."($column)value($values)";
        return $this->executeQuery($sql);
    }


    //del
    public function modelDel($params = array()){
        if(isset($this->sql['where'])&& $this->sql['where']){
            $sql = "delete from ".$this->table.$this->sql['where'];
            return $this->executeQuery($sql);
        }
        return false;
    }


    //update
    public function modelUpdate($params = array()){
         if(count($params)>0 && isset($this->sql['where'])){
             $updateSql = " set ";
             foreach($params as $key=>$val){
                 $updateSql .= "  `$key`= ".":".$key."Value, ";
                 $this->modelParams[":".$key."Value"] = $val;
             }
         $sql = "update ".$this->table.rtrim($updateSql,", ")." ".$this->sql['where'];
         $this->executeQuery($sql);
         }

        return false;
    }

    //select
    public  function modelSelect(){
        $sql = "select * from " .$this->table.@$this->sql['where'].@$this->sql['limit'];
        return $this->executeQuery($sql);
    }

    //where
    public function modelWhere($params){
        $this->sql['where'] = " where ";
        foreach($params as $key=>$val){
            $this->modelParams[':'.$key.'Where'] = $val;
            $this->sql['where'] .= " `$key` = :{$key}Where and ";
        }
        $this->sql['where'] = rtrim($this->sql['where'],"and ");
        return $this;
    }

    public function modelLimit($begain,$limit){
       if($begain && $limit){
           $this->sql['limit'] = " limit $begain $limit ";
       }
        return $this;
    }

}