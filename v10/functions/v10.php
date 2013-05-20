<?php

function dump($var) 
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function load_controller($controller, $folder = null) 
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
			trigger_error("Controller $controller not found on controllers/$folder", E_USER_ERROR);
		}
		else
		{
			trigger_error("Folder $folder not found on controllers/", E_USER_ERROR);
		}
	}
}

function load_view($view, $data = array()) 
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

function dump_view($view, $data = array())
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

function load_document($document, $folder = null)
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

function load_lang($iso31661a2)
{
	unset($lang);
	return include("i18n/$iso31661a2.php");
}

function redirect($url, $code=301)
{
	header("Location: ".$url, TRUE, $code);
}

function uri_segment($n = 1)
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

function current_request()
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

function http_header($code)
{
	$ret = false;
	switch($code)
	{
		case 100:
			$ret = '100 Continue';
			break;
		case 101:
			$ret = '101 Switching Protocols';
			break;
		case 102:
			$ret = '102 Processing';
			break;
		case 200:
			$ret = '200 OK';
			break;
		case 201:
			$ret = '201 Created';
			break;
		case 202:
			$ret = '202 Accepted';
			break;
		case 203:
			$ret = '203 Non-Authoritative Information';
			break;
		case 204:
			$ret = '204 No Content';
			break;
		case 205:
			$ret = '205 Reset Content';
			break;
		case 206:
			$ret = '206 Partial Content';
			break;
		case 207:
			$ret = '207 Multi-Status';
			break;
		case 208:
			$ret = '208 Already Reported';
			break;
		case 226:
			$ret = '226 IM Used';
			break;
		case 300:
			$ret = '300 Multiple Choices';
			break;
		case 301:
			$ret = '301 Moved Permanently';
			break;
		case 302:
			$ret = '302 Found';
			break;
		case 303:
			$ret = '303 See Other';
			break;
		case 304:
			$ret = '304 Not Modified';
			break;
		case 305:
			$ret = '305 Use Proxy';
			break;
		case 306:
			$ret = '306 Switch Proxy';
			break;
		case 307:
			$ret = '307 Temporary Redirect';
			break;
		case 308:
			$ret = '308 Permanent Redirect';
			break;
		case 400:
			$ret = '400 Bad Request';
			break;
		case 401:
			$ret = '401 Unauthorized';
			break;
		case 402:
			$ret = '402 Payment Required';
			break;
		case 403:
			$ret = '403 Forbidden';
			break;
		case 404:
			$ret = '404 Not Found';
			break;
		case 405:
			$ret = '405 Method Not Allowed';
			break;
		case 406:
			$ret = '406 Not Acceptable';
			break;
		case 407:
			$ret = '407 Proxy Authentication Required';
			break;
		case 408:
			$ret = '408 Request Timeout';
			break;
		case 409:
			$ret = '409 Conflict';
			break;
		case 410:
			$ret = '410 Gone';
			break;
		case 411:
			$ret = '411 Length Required';
			break;
		case 412:
			$ret = '412 Precondition Failed';
			break;
		case 413:
			$ret = '413 Request Entity Too Large';
			break;
		case 414:
			$ret = '414 Request-URI Too Long';
			break;
		case 415:
			$ret = '415 Unsupported Media Type';
			break;
		case 416:
			$ret = '416 Requested Range Not Satisfiable';
			break;
		case 417:
			$ret = '417 Expectation Failed';
			break;
		case 418:
			$ret = '418 I\'m a teapot';
			break;
		case 420:
			$ret = '420 Enhance Your Calm';
			break;
		case 422:
			$ret = '422 Unprocessable Entity';
			break;
		case 423:
			$ret = '423 Locked';
			break;
		case 424:
			$ret = '424 Method Failure';
			break;
		case 425:
			$ret = '425 Unordered Collection';
			break;
		case 426:
			$ret = '426 Upgrade Required';
			break;
		case 428:
			$ret = '428 Precondition Required';
			break;
		case 429:
			$ret = '429 Too Many Requests';
			break;
		case 431:
			$ret = '431 Request Header Fields Too Large';
			break;
		case 444:
			$ret = '444 No Response';
			break;
		case 449:
			$ret = '449 Retry With';
			break;
		case 450:
			$ret = '450 Blocked by Windows Parental Controls';
			break;
		case 451:
			$ret = '451 Unavailable For Legal Reasons';
			break;
		case 494:
			$ret = '494 Request Header Too Large';
			break;
		case 495:
			$ret = '495 Cert Error';
			break;
		case 496:
			$ret = '496 No Cert';
			break;
		case 497:
			$ret = '497 HTTP to HTTPS';
			break;
		case 499:
			$ret = '499 Client Closed Request';
			break;
		case 500:
			$ret = '500 Internal Server Error';
			break;
		case 501:
			$ret = '501 Not Implemented';
			break;
		case 502:
			$ret = '502 Bad Gateway';
			break;
		case 503:
			$ret = '503 Service Unavailable';
			break;
		case 504:
			$ret = '504 Gateway Timeout';
			break;
		case 505:
			$ret = '505 HTTP Version Not Supported';
			break;
		case 506:
			$ret = '506 Variant Also Negotiates';
			break;
		case 507:
			$ret = '507 Insufficient Storage';
			break;
		case 508:
			$ret = '508 Loop Detected';
			break;
		case 509:
			$ret = '509 Bandwidth Limit Exceeded';
			break;
		case 510:
			$ret = '510 Not Extended';
			break;
		case 511:
			$ret = '511 Network Authentication Required';
			break;
		case 598:
			$ret = '598 Network read timeout error';
			break;
		case 599:
			$ret = '599 Network connect timeout error';
			break;
		default:
			return FALSE;
			break;							
	}
	header('HTTP/1.1 '.$ret);
}

function check_socket($host, $port)
{
	if($s = @fsockopen($host, $port))
	{
    	fclose($s);
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

?>