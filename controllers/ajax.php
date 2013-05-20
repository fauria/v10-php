<?php

class Ajax
{
	public function __construct()
	{

	}
	
	public function test()
	{
		$my_array = array(
			'hello' => 'world',
			'from' => 'ajax',
			'at' => date('h:i:s')
		);
		http_header(200);
		header('Content-type: application/json');
		print(json_encode($my_array));
	}
}

?>
