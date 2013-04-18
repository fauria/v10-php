<?php

class Dispatcher
{
	var $request;
	var $controller_name;
	var $method_name;
	var $arguments = array();
	var $dir_path = array();
	
	public function __construct()
	{
		$base_path = explode('/', base_folder);
		array_pop($base_path);
		
		$this->request = explode('/', $_SERVER['REQUEST_URI']);
		
		array_shift($this->request);

		foreach($this->request as $index => $segment)
		{
			$folder = array_pop($base_path);
			if($segment == 'index.php' || $segment == $folder || $segment == '')
			{
				unset($this->request[$index]);
			}
		}
				
		while($element = array_shift($this->request))
		{	
			if($ext = strstr($element, '.'))
			{
				$extensions = explode(',', allowed_extensions);

				if(in_array($ext, $extensions))
				{
					$element = strstr($element, '.', TRUE);
				}
			}

			if(is_dir('controllers/'.implode('/', $this->dir_path).'/'.$element))
			{
				array_push($this->dir_path, $element);
			}
			else
			{
				if(is_file('controllers/'.implode('/', $this->dir_path).'/'.$element.'.php'))
				{
					$this->controller_name = $element;
				}
				else
				{
					$this->controller_name = default_controller;
					array_unshift($this->request, $element);
				}
				break;
			}
		}
				
		$this->method_name = array_shift($this->request) or $this->method_name = default_method;
		$this->arguments = $this->request;
		
	}
	
	public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		error_reporting(E_ALL);
		echo '<html><head><title>An error as ocurred.</title></head><body><div style="background-color:#efefef;margin:2%;"><h1>An error has ocurred. Here is the description:</h1>';
		echo '<table border="1" cellpadding="10">';
		echo "<thead><tr><th>Error code</th><th>Message</th><th>File</th><th>Line</th><th>Context</th></tr></thead>";
		echo "<tbody><tr><td>$errno</td><td>$errstr</td><td>$errfile</td><td>$errline</td><td>$errcontext</td></tr></tbody>";
		echo "</table>";
		
		if($handle = fopen($errfile, 'r'))
		{
			$line = 0;
			$min_line = $errline - 10;
			$max_line = $errline + 10;
			echo '<h2>Source code excerpt from'.$errfile.':</h2><table border="1" cellpadding="2">';
			echo "<thead><tr><th>Line</th><th>Source</th></tr></thead><tbody>";
			while(!feof($handle))
			  {
				$line++;
				if($line < $min_line)
				{
					fgets($handle);
					continue;
				}
				if($line > $max_line)
				{
					break;
				}
				if($line == $errline)
				{
					echo "<tr style=\"background:#fc6565;\"><td>".$line."</td><td>".fgets($handle)."</td><tr>";
				}
				else
				{
					echo "<tr><td>".$line."</td><td>".fgets($handle)."</td><tr>";
				}

			  }
			echo '</tbody></table>';
			fclose($handle);
		}
		echo '<h2>If you dont want to display this tables, set "<i>use_v10_error_handler = false</i>" on file "<i>'.base_folder.'v10/config.php</i>".</h2>';
		echo '</div></body></html>';
				
	}
	
}

?>
