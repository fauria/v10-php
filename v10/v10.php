<?php

function dump($var) //OK
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function load_controller($controller, $folder = null) //OK
{	
	$path = 'controllers/'.$folder.'/'.$controller.'.php';
	
	if(file_exists($path))
	{
		if(class_exists($controller))
		{
			trigger_error("Attempt to redeclare controller class $controller", E_USER_WARNING);
			return null;
		}
		else
		{
			include($path);
			return new $controller();
		}
	}
	else
	{
		if(is_dir('controllers/'.$folder))
		{
			die();
		}
		trigger_error("Controller $controller not found on controllers/$folder", E_USER_ERROR);
	}
}

function load_view($view, $data = array()) //OK
{
	$path = 'views/'.$view.'.php';
	if(file_exists($path))
	{
		if(count($data) > 0)
		{
			extract($data);
		}		
		include($path);
	}
	else
	{
		trigger_error("View $view not found.", E_USER_WARNING);
		return false;
	}	
}

function dump_view($view, $data = array()) //REVISAR
{
	extract($data);
	ob_start();
	require('views/'.$view.'.php');
	return ob_get_clean();
}

function load_model($model, $folder = null)
{
	$path = 'models/'.$folder.'/'.$model.'.php';
	if(file_exists($path))
	{
		if(class_exists($model))
		{
			trigger_error("Attempt to redeclare model class $model", E_USER_WARNING);
			return null;
		}
		else
		{
			if(!class_exists('R'))
			{
				require_once('v10/rb.php');
				try 
				{
					R::setup('mysql:host='.mysql_host.';dbname='.mysql_database,mysql_user,'mysql_pass');
				}
				catch(PDOException $e)
				{
					trigger_error('Can not connect to MySQL on host '.mysql_host.' using supplied credentials.', E_USER_ERROR);
				}
			}
			include($path);
			return new $model;
		}
	}
	else
	{
		trigger_error("Document ".getcwd().'/'.$path." not found.", E_USER_ERROR);
		return false; 
	}
}

function load_document($document, $folder = null) //OK
{
	$path = 'documents/'.$folder.'/'.$document.'.php';
	if(file_exists($path))
	{
		if(class_exists($document))
		{
			trigger_error("Attempt to redeclare document class $document", E_USER_WARNING);
			return null;
		}
		else
		{
			if(!class_exists('Db'))
			{
				require_once('v10/db.php');
			}
			include($path);
			return new $document;
		}
	}
	else
	{
		trigger_error("Document ".getcwd().'/'.$path." not found.", E_USER_ERROR);
		return false; 
	}
}

function load_lang($iso31661a2) //REVISAR
{
	unset($lang);
	return include("i18n/$iso31661a2.php");
}

function redirect($url, $code=301) //OK
{
	header("Location: ".$url, TRUE, $code);
}

function uri_segment($n = 1) //OK
{
	$request = explode('/', $_SERVER['REQUEST_URI']);
	array_shift($request);

	$base_path = explode('/', base_folder);
	array_pop($base_path);
	
	foreach($request as $index => $segment)
	{
		$folder = array_pop($base_path);
		if($segment == 'index.php' || $segment == $folder || $segment == '')
		{
			unset($request[$index]);
		}
	}
	
	if(isset($request[$n]))
	{
		return $request[$n];
	}
	else
	{
		return false;
	}
}

function current_request() //OK
{
	$request = explode('/', $_SERVER['REQUEST_URI']);
	array_shift($request);
	
	$base_path = explode('/', base_folder);
	array_pop($base_path);
	
	foreach($request as $index => $segment)
	{
		$folder = array_pop($base_path);
		if($segment == 'index.php' || $segment == $folder || $segment == '')
		{
			unset($request[$index]);
		}
	}
	
	return $request;
}

function xss_clean($data)
{
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	return $data;
}

?>