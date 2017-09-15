<?php
class Server{

	private $server ;

	private $config=[
		'heartbeat_check_interval' => 20,
		'heartbeat_idle_time' => 60*60,
		'daemonize' => true,
		'worker_num'=>2,
		'log_file'		=> '/www/web/swool/public_html/ws.log',
		'ssl_cert_file' => "/www/web/swool/public_html/config/server.crt",
		'ssl_key_file' => '/www/web/swool/public_html/config/server.key'
	];


	public function __construct()
	{
		$this->server = new swoole_websocket_server("0.0.0.0",443,SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);

		$this->server->set($this->config);

		$this->server->on("Open",array($this,"onOpen"));
		$this->server->on("Close",array($this,"onClose"));
		$this->server->on("Message",array($this,"onMessage"));
		$this->server->on("Task",array($this,"onTask"));
		$this->server->on("Finish",array($this,"onFinish"));
		$this->server->on("WorkerStart",array($this,"onWorkerStart"));
		$this->server->start();
	}


	public function onOpen($serv,$req){
		echo "onConnect>>> Fd:\n";
	}

	public function onClose($serv,$fd){
		echo "onClose>>> Fd:$fd , \n";
	}

	public function onMessage($serv,$frame){
		echo "onReceiver>>>   \n";
		$data = json_decode($frame->data,true);
		$path = @$data['path'];
		$data['params']['fd'] = $frame->fd;
		$params = $data['params'];
		$serv->index->run("",$params);
		$serv->push($frame->fd,"test");
	}

	public function onTask($serv,$task_id,$from_id,$data){
		echo "onTask>>>  TaskId:$task_id, FromId:$from_id,Data:$data \n";
		//调度任务，操作数据

	}

	public function onFinish($serv,$task_id,$data){
		echo "onFinish>>>  TaskId:$task_id,Data:$data \n";
	}

	public function onWorkerStart($serv,$work_id){
		include "run.php";
		$serv->index = new  \swoole\Run();
	}

}


$server = new Server();

?>