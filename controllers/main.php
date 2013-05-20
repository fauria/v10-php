<?php

class Main
{
	private $redis;
	
	public function __construct()
	{
		//session_start();
		include('v10/redis.php');
		$redis = new Redis();
		@$redis->is_availabl();
	}
	
	public function index()
	{
		$services = array(
			'is_mysql' => check_socket(mysql_host, mysql_port),
			'is_redis' => check_socket(redis_host, redis_port),
			'is_mongodb' => check_socket(mongodb_host, mongodb_port)
		);

		load_view('main', $services);
	}

}


?>
