<?php

define('default_controller', 'main');
define('default_method', 'index');

define('base_host', 'http://localhost:8888/');
define('base_folder', implode(array_slice(array_reverse(preg_split('/\//', $_SERVER['PHP_SELF'], 0, PREG_SPLIT_NO_EMPTY)),1, 1)).'/');

define('mongodb_host', 'localhost');
define('default_database', 'test');
define('default_collection', 'items');
define('array_mode', TRUE);

define('mysql_host', 'localhost');
define('mysql_database', 'test');
define('mysql_user', 'root');
define('mysql_pass', 'root');

define('allowed_extensions', implode(',', array('.html', '.htm', '.php')));

define('use_v10_error_handler', TRUE);

define('with_accents', 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ');
define('without_accents', 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy');

define('base_url', base_host.base_folder);
?>