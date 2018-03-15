<?php /* Smarty version Smarty-3.1.15, created on 2017-06-18 22:38:26
         compiled from "D:\webroot\demo\view\common\header.php" */ ?>
<?php /*%%SmartyHeaderCode:141359469062400776-39900458%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c88f667af69061ded134fc004d4640267e44175' => 
    array (
      0 => 'D:\\webroot\\demo\\view\\common\\header.php',
      1 => 1497715044,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '141359469062400776-39900458',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TAE' => 0,
    'CM' => 0,
    'CA' => 0,
    '_G' => 0,
    'query_text' => 0,
    'global_str' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5946906243d9d8_65151887',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5946906243d9d8_65151887')) {function content_5946906243d9d8_65151887($_smarty_tpl) {?><!doctype html>
<html  class="taeapp <?php if ($_smarty_tpl->tpl_vars['TAE']->value==1) {?>tae<?php } else { ?>web<?php }?> _<?php echo $_smarty_tpl->tpl_vars['CM']->value;?>
 _<?php echo $_smarty_tpl->tpl_vars['CM']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['CA']->value;?>
" >
<head>
<meta charset="utf-8">
<title><?php if ($_smarty_tpl->tpl_vars['_G']->value['title']) {?><?php echo $_smarty_tpl->tpl_vars['_G']->value['title'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['title'];?>
<?php }?>-锦尚中国淘客系统</title>
<link href="/favicon.ico" type="image/x-icon" rel=icon />
<meta name="author" content="uz-system.com 7x24 service d_cms@qq.com"/>
<meta name="system_info" content="by uz-system version <?php echo $_smarty_tpl->tpl_vars['_G']->value['version'];?>
"/>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['_G']->value['keywords'];?>
"/>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['_G']->value['description'];?>
"/>

<meta name="tk" content="0|<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['taodianjing_url'];?>
|<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['tdj_type'];?>
"/>
<meta name="get" content="<?php echo $_smarty_tpl->tpl_vars['query_text']->value;?>
"/>
<meta name="set" content="<?php echo $_smarty_tpl->tpl_vars['global_str']->value;?>
"/>
<script type="text/javascript" src="http://a.alimama.cn/tkapi.js"></script>
<script type="text/javascript" src="/assets/global/js/global.js"></script>

<link rel="stylesheet" type="text/css" href="/assets/global/css/global.css" media="all" />
</head>
<body>
<div class="uz_system"></div>
<?php }} ?>
