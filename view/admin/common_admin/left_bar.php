{include file="../../common/header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/admin2.css" media="all" />

<div class="admin cl " data-version="{$_G.version}" data-updatetime="{$_G.update_time}" >

<table cellpadding="0" cellspacing="0" width="100%" height="100%" style="width: 100%;">
<tbody>
  <tr>
    <td valign="top" width="160" class="menutd "><a href="{$URL}" title="uz-system.com" ><img src="{$IMGDIR}/logo.png" /></a>
      <div id="leftmenu" class="menu"> 
      
      
      {foreach from=$_G.menu item=nav key=key}
      {foreach from=$nav.nav item=v key=k name = menu}
          {if $SYSTEM_TYPE >=$nav.type && $smarty.foreach.menu.index ==0 && $nav.select ==1}
                <div class="line"></div>
                <ul {if $CURMODULE==$key}class="on"{/if}>          
                  <li><a {if $CURMODULE==$key && $CURACTION==$k } class="tabon" {/if} href="{$URL}m={$key}&a={$v.a}"   ><em  title="打开"></em>{$nav.name}</a></li>
                </ul>
         {/if}
          {/foreach}
        {/foreach} </div>
      <div class="line"></div>
      <div class="copyright"><p><br />
<br />
</p>
        <p>Copyright © 2014</p>
        <p><a target="_blank" href="http://bbs.52jscn.com">bbs.52jscn.com</a></p>
        <p><a target="_blank" href="http://bbs.52jscn.com/">锦尚中国</a></p>
        <p>版本: v{$_G.version} {$_G.update_time}</p>
        <p><a href="http://help.uz-system.com" target="_blank" class="red">帮助中心</a>
         </p>
      </div></td>
    <td valign="top" width="100%" class="mask"><div class="admin_main cl">
    
    
<div class="itemtitle">
  <div class="y right_bar">
    <ul>
    
      <li><a href="{$_G.siteurl}" target="_blank" class="red">查看站点</a></li>
       <li><a href="{$URL}" >后台首页</a></li>
      <li><a href="{$URL}m=login&a=logout" onclick="return confirm('您确定退出登录?')">退出登录</a></li>
      <li>当前版本:v{$_G.version} {$_G.update_time}</li>      
    </ul>
  </div>
  
{foreach from=$menu item=nav key=key  }
{if $CURMODULE == $key}
 		<h3>{$nav.name}</h3>
        <ul class="tab1">
        
 
        
          {foreach from=$nav.nav item=v key=k}
          		{if !$v.type || $v.type<=$SYSTEM_TYPE }
                    {if $v.select =='1'}
                      <li {if $CURACTION==$v.a}class="current"{/if}> <a href="{$URL}m={$key}&a={$v.a}"><span>{$v.name}</span></a></li> 
                   {/if}
                   
               {/if}
          {/foreach}
        </ul>
  {/if}
{/foreach} 
</div>

  <!--main start-->
      
