<?php /* Smarty version Smarty-3.1.15, created on 2017-06-18 22:38:26
         compiled from "D:\webroot\demo\view\admin\common_admin\cpmsg.php" */ ?>
<?php /*%%SmartyHeaderCode:2680759469062306b73-91301087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '334f4a6a9a42d0b791c7dc4379c44e085b9afa0b' => 
    array (
      0 => 'D:\\webroot\\demo\\view\\admin\\common_admin\\cpmsg.php',
      1 => 1440510692,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2680759469062306b73-91301087',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'classname' => 0,
    'message' => 0,
    'url' => 0,
    'title' => 0,
    'ext_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_59469062352353_84229973',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59469062352353_84229973')) {function content_59469062352353_84229973($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('./left_bar.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="cl cpmsg">
  <div class="infobox cl">
    <h4 class="<?php echo $_smarty_tpl->tpl_vars['classname']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</h4>
    <p class="marginbot"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" class="lightlink"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a></p>
    <?php echo $_smarty_tpl->tpl_vars['ext_message']->value;?>

  </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ('./right_bar.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
