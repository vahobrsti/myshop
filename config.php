<?php
//site variables
defined('HOST') or define('HOST',getenv('HTTP_HOST'));
defined('ROOTFOLDER') or define('ROOTFOLDER',str_replace('\\','/',dirname(__FILE__).'/'));

//database config
defined('DBUSER') or define('DBUSER','root');
defined('DBPASS') or define('DBPASS','mysql');
defined('DBHOST') or define('DBHOST','localhost');
defined('DBNAME')or define('DBNAME','shop');
