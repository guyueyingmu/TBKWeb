<?php /* Smarty version Smarty-3.1.15, created on 2017-06-18 22:45:42
         compiled from "install\main.php" */ ?>
<?php /*%%SmartyHeaderCode:2597459469216b64026-29320302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca3a07c76351fa8db6ba631695c2558c7780ca44' => 
    array (
      0 => 'install\\main.php',
      1 => 1497713421,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2597459469216b64026-29320302',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TAE' => 0,
    'CM' => 0,
    'CA' => 0,
    'version' => 0,
    '_G' => 0,
    'query_text' => 0,
    'global_str' => 0,
    'updatetime' => 0,
    'system' => 0,
    'siteurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_59469216e3ed17_33269934',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59469216e3ed17_33269934')) {function content_59469216e3ed17_33269934($_smarty_tpl) {?><!doctype html>
<html  class="taeapp <?php if ($_smarty_tpl->tpl_vars['TAE']->value==1) {?>tae<?php } else { ?>web<?php }?> _<?php echo $_smarty_tpl->tpl_vars['CM']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['CA']->value;?>
">
<head>
<meta charset="utf-8">
<title>锦尚中国淘宝客系统安装</title>
<link href="/favicon.ico" type="image/x-icon" rel=icon />
<meta name="author" content="uz-system.com 7x24 service d_cms@qq.om"/>
<meta name="system_info" content="by uz-system version <?php echo $_smarty_tpl->tpl_vars['version']->value;?>
"/>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['_G']->value['keywords'];?>
"/>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['_G']->value['description'];?>
"/>
<meta name="tk" content="<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['pid'];?>
|<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['taodianjing_url'];?>
|1"/>
<meta name="get" content="<?php echo $_smarty_tpl->tpl_vars['query_text']->value;?>
"/>
<meta name="set" content="<?php echo $_smarty_tpl->tpl_vars['global_str']->value;?>
"/>

<script type="text/javascript" src="/assets/global/js/jquery-1.8.3.min.js"></script> 
<script type="text/javascript" src="/assets/global/js/global.js"></script>
<link rel="stylesheet" type="text/css" href="/assets/global/css/global.css" media="all" />
<link rel="stylesheet" type="text/css" href="/assets/global/css/animator.min.css" media="all" />
</head>
<body data-tae="<?php echo $_smarty_tpl->tpl_vars['TAE']->value;?>
">
<div class="uz_system"></div>

<script type="text/javascript" src="/install/static/install.js"></script>
<link rel="stylesheet" type="text/css" href="/install/static/install.css" media="all" />
<link rel="stylesheet" type="text/css" href="/install/static/bootstrap.min.css" media="all" />
<link rel="stylesheet" type="text/css" href="/install/static/buttons.css" media="all" />



<div class="body"  data-version="<?php echo $_smarty_tpl->tpl_vars['version']->value;?>
" data-updatetime="<?php echo $_smarty_tpl->tpl_vars['updatetime']->value;?>
" data-system="<?php echo $_smarty_tpl->tpl_vars['system']->value;?>
" data-tae="<?php echo $_smarty_tpl->tpl_vars['TAE']->value;?>
">


<div class="hd ff">
<div class="hd_m ff ">
<h1  class="step1 hide">第1步 程序安装</h1>
<h1 class="step2 hide">第2步 程序设置</h1>
<h1 class="step3 hide">第3步 安装成功</h1>
</div>
</div>


<div class="install_box cl ff">
	
   
   
    <div class="box box1 cl ">
        
        <div class="cl box_m">
            <div class="box_l">数据库地址</div>
            <div class="box_c"><input name="address" type="text" value="<?php if ($_smarty_tpl->tpl_vars['TAE']->value==0) {?>localhost<?php }?>" class="input-xlarge"></div>
            <div class="box_r">默认localhost</div>
        </div>
         <div class="cl box_m">
            <div class="box_l">数据库端口</div>
            <div class="box_c"><input name="port" type="text" value="3306" class="input-xlarge"></div>
            <div class="box_r">默认3306</div>
        </div>
         <div class="cl box_m" style="display:none">
            <div class="box_l">数据库表前缀</div>
            <div class="box_c"><input name="pre" type="text" value="ttae_" cclass="input-xlarge"></div>
            <div class="box_r">默认ttae_</div>
        </div>
         <div class="cl box_m">
            <div class="box_l">数据库用户名</div>
            <div class="box_c"><input name="username" type="text" value="" cclass="input-xlarge"></div>
            <div class="box_r"></div>
        </div>
        
         <div class="cl box_m">
            <div class="box_l">数据库密码</div>
            <div class="box_c"><input name="password" type="text" value="" class="input-xlarge"></div>
            <div class="box_r"></div>
        </div>
        
         <div class="cl box_m">
            <div class="box_l">数据库名称</div>
            <div class="box_c"><input name="name" type="text" value="" class="input-xlarge"></div>
            <div class="box_r"></div>
        </div>
        
         <div class="box_msg"></div>
          <div class="cl box_b">
            
            <input type="button" value="立即安装" class="button  button-primary button-pill button-large install_btn"  style="display:none;">
             <input type="button"  value="一键检查" class="button  button-caution button-pill button-large check_btn">
        </div>

        </div>
        
        
        
        <div class="box box2 cl hide">
        
      
        
        <div class="cl box_m">
            <div class="box_l">管理员账号</div>
            <div class="box_c"><input name="user_name" type="text" value="" class="input-xlarge"></div>
            <div class="box_r"></div>
        </div>
         <div class="cl box_m">
            <div class="box_l">管理员密码</div>
            <div class="box_c"><input name="user_password" type="text" value="" class="input-xlarge"></div>
            <div class="box_r"></div>
        </div>
        
         <div class="cl box_m form-group hide">
            <div class="box_l">测试数据</div>
            <div class="box_c radio_box fff" style="margin-top:5px;">

           
           <label for="inset_test_data1" class="z">
           <input id="inset_test_data1" type="radio"  name="inset_test_data" value="1" checked >&nbsp;安装</label>
           
           <label for="inset_test_data2" class="z" style="margin-left:30px;">
            <input  id="inset_test_data2" type="radio" name="inset_test_data"  value="0" >&nbsp;不安装</label>
           
           
            </div>
            <div class="box_r">推荐安装</div>
        </div>
       
        
         <div class="box_msg"></div>
          <div class="cl box_b">
            
            <input type="button" value="立即提交" class="button  button-primary button-pill button-large install_data_btn" >

        </div>

        </div>
        
        
          <div class="box box3 cl hide">
        
      
        
        <div class="cl box_m box_m_over">
            <div class="box_l">进入首页</div>
            <div class="box_c"><a href="/index.php" class="index_url"><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
</a></div>
            <div class="box_r"></div>
           </div>
          <div class="cl box_m">   
            <div class="box_l">进入后台</div>
            <div class="box_c"><a href="/admin.php" class="admin_url"><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/admin.php</a></div>
            <div class="box_r"></div>
        </div>
         </div>

        <div class="ft cl ac">
        <p>当前版本<?php echo $_smarty_tpl->tpl_vars['version']->value;?>
,更新时间:<?php echo $_smarty_tpl->tpl_vars['updatetime']->value;?>
</p>
        <p>
        Copyright © 2014 <a href="http://www.52jscn.com/taoke" target="_blank">锦尚中国淘客系统</a> 
        版权所有
        </p>
        </div>
        
</div>


</div>

</body>
</html><?php }} ?>
