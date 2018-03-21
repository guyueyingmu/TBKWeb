{if $_G.setting.left_bar ==1}

<div class="lfet_bar wp_{$width}">

  <ul class="collection">
 <li class="collection-header center-align"><h5 class="grey-text text-lighten-1">分类导航</h5></li>
    {foreach from = $_G.channels item=v name= a}
        {if $v.hide ==0}
         <li class="collection-item {if $_G.fid == $v.fid || $channel.fup == $v.fid  }active white-text cyan lighten-3{/if}">
         <a href="{$URL}fid={$v.fid}" class="{if $_G.fid == $v.fid || $channel.fup == $v.fid }white-text{else}grey-text text-darken-3{/if}">{$v.name}
         <i class="iconfont right {$v.classname}"></i></a>
         </li>
         {/if}
    {/foreach}

    {foreach $_G.nav item=v}
        {if $v.type =="3"}
        <li class="collection-item">
        <a href="{$v.url}" class="newindexicon grey-text text-darken-3" {if $v.target=="1"} target="_blank"{/if}>{$v.name}
        <i class="iconfont right {$v.classname}"></i></a>
        </a></li>
        {/if}
    {/foreach}

  </ul>

</div>
{/if}

<footer class="page-footer cyan">
    <div class="container wp">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">友情链接：</h5>
          <p class="grey-text text-lighten-4">
<!--{foreach from= $_G.friend_link item = v name=a}-->
                    <!--{if $v.hide == 0}-->

                    <a href="{$v.url}" target="_blank" class="grey-text text-lighten-3">{$v.name}</a>
                    <!--{/if}-->
 <!--{/foreach}-->

<!--程序免费使用,请自觉保留以下友情链接-->
          </p>
        </div>
        <div class="col l4 offset-l2 s12">
          <h5 class="white-text">帮助中心</h5>
          <ul>
            <li><a class="grey-text text-lighten-3" href="{$URL}m=article&id=1">关于我们</a></li>
            <li><a class="grey-text text-lighten-3" href="{$URL}m=article&id=4">商务合作</a></li>
            <li><a class="grey-text text-lighten-3" href="{$URL}m=article&id=3">常见问题</a></li>
            <li><a class="grey-text text-lighten-3" href="{$URL}m=article&id=9">服务条款</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container wp" style="margin: 0 auto;">
        {$_G.setting.copyright}
      </div>
    </div>
  </footer>

<div id="tbox"  class="_gotop" >
      <a id="gotop"href="javascript:void(0)" style="display: block;"></a> </div>

{include file="../common/footer.php"}
