<?php
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
$basename = basename($_SERVER['SCRIPT_FILENAME']);
$basename = explode('.',$basename );
define('CURSCRIPT', reset($basename));

$tss = isset($_GET['th'])?$_GET['th']:"==============";
error_log(date('Y-m-d h:i:sa').':'."startTime:".time().$tss."\r\n",3,"urllog".date('Y-m-d')."log");
if(isset($_GET['th'])){
    sleep(1000);
}else{
}
error_log(date('Y-m-d h:i:sa').':'."endTime:".time().$tss."\r\n",3,"urllog".date('Y-m-d')."log");


include ROOT_PATH.'inc/class/application.class.php';
error_reporting( E_ALL & ~E_NOTICE );
application::init();
application::run();
?>