<?php

require_once('v10/config.php');
require_once('v10/v10.php');
require_once('v10/dispatcher.php');

class V10 extends Dispatcher
{
	var $controller;
	
	public function __construct()
	{	
		parent::__construct();
		
		if(use_v10_error_handler)
		{
			set_error_handler("V10::error_handler");
		}

		if($this->controller_name == '' || (strstr($this->controller_name, '.', TRUE) == 'index'))
		{
			$this->controller_name = default_controller;
		}
		
		if(strstr($this->method_name, '.', TRUE) == 'index')
		{
			$this->method_name = default_method;
		}
		
	}
	
	function run()
	{	
		$this->controller = load_controller($this->controller_name, implode('/', $this->dir_path).'/');
		
		if(!in_array($this->method_name, get_class_methods($this->controller)))
		{
			array_unshift($this->arguments, $this->method_name);
			$this->method_name = default_method;
		}
		
		define('current_controller', $this->controller_name);
		define('current_method', $this->method_name);
	
		call_user_func_array(array ($this->controller, current_method), $this->arguments);
	}	
	
}

$v10 = new V10();

$v10->run();



?>