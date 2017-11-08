<?php
use app\push\controller\Message;
	/**
	  *监听publish
	*/
	ini_set('default_socket_timeout', -1);  //不超时
	
	$redis = new Redis();
	$redis->connect('127.0.0.1',6379);
	$redis->subscribe(array('hejing'),'callback');
	$a = new Message();
	$a->callback();
	function callback(){
		echo 'yes';
	}
	