<?php

define('default_controller', 'main');
define('default_method', 'index');

define('base_host', 'http://'.$_SERVER['HTTP_HOST'].'/');
define('base_folder', implode(array_slice(array_reverse(preg_split('/\//', $_SERVER['PHP_SELF'], 0, PREG_SPLIT_NO_EMPTY)),1, 1)).'/');

define('main_email', 'example@example.com');

define('mongodb_host', 'localhost');
define('mongodb_port', 27017);
define('default_database', 'test');
define('default_collection', 'items');
define('array_mode', TRUE);

define('redis_host', 'localhost');
define('redis_port', 6379);

define('mysql_host', 'localhost');
define('mysql_port', 3306);
define('mysql_database', 'test');
define('mysql_user', 'root');
define('mysql_pass', 'root');

define('allowed_extensions', implode(',', array('.html', '.htm', '.php')));

define('use_v10_error_handler', FALSE);
define('load_v10_functions', implode(',', array('all')));

define('with_accents', 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ');
define('without_accents', 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy');

if(base_folder != '/')
{
	define('base_url', base_host.base_folder);
}
else
{
	define('base_url', base_host);
}
?>