<?php
if(!defined('IN_TTAE')) exit('Access Denied');
define('TTAE_VERSION','5.6');
define('TTAE_UPDATE_TIME','20170613');
define('SYSTEM_TYPE',3);
define('SYSTEM',1);
//define('DEBUG', true);

if(function_exists('error_reporting')) error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);//E_ALL
//if(function_exists('error_reporting')) error_reporting(E_ALL);
$_confog = array('cache_list'=>array(),'db'=>array(),'cache_config'=>'','sms'=>array());
$_config['cache_list'] = array('setting','all_channel','channels','friend_link','pics_type','pics','ad','goods_cate','table','group','article_cate','duihuan_cate','style_cate','img_cate','nav');
$_config['cache_type']='auto';	// auto || memcache || baichuan || fileServer || file ||  aliyun_ocs










$_config['authkey'] = 'mjM20MfmrH';
$_config['db']=array (
  'dbhost' => 'localhost',
  'dbport' => 3306,
  'dbuser' => 'root',
  'dbpw' => '123456',
  'dbcharset' => 'utf8',
  'dbname' => 'tbk_test',
  'pconnect' => 0,
  'tablepre' => 'ttae_',
);

?>