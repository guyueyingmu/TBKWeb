<?php
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
$basename = basename($_SERVER['SCRIPT_FILENAME']);
$basename = explode('.',$basename );
define('CURSCRIPT', reset($basename));
include ROOT_PATH.'inc/class/application.class.php';
//error_reporting( E_ALL & ~E_NOTICE );
application::init();
application::run();
?>