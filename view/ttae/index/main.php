{include file="../header.php"}
 <link type="text/css" rel="stylesheet" href="{$CSSDIR}/index.css">



<!--slider-script   1000X350-->
<script src="/assets/global/js/responsiveslides.min.js"></script>
<script>
    $(function () {
        $("#slider1").responsiveSlides({
            auto: true,
            speed: 500,
            namespace: "callbacks",
            pager: true,
        });
    });
</script>

<!--//slider-script-->
<div class="banner-mat">
    <div class="container">
        <div class="banner">
            <div class="slider">
                <ul class="rslides" id="slider1">

                    {foreach from=$_G.pics.k33 item=v}
                    <li>
                        <a {if $v.url} href="{$v.url}" target="_blank"{/if}><img src="{$v.picurl}" /></a>
                    </li>
                    {/foreach}
                </ul>
            </div>

            <div class="banner-bottom">
                <div class="banner-matter">
                    <p>惠多多欢迎您</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!--
{if $_G.ad.k2}
<div class="ad cl">
    {$_G.ad.k2.show_html}
</div>
{/if}
-->

<!--
<div class="kt_box cl ">
    	<ul>
        {foreach from=$img item=v key=k}
        {if $k==0}
    		<li class="kt_big on"><a href="{$v.url}" target="_blank"><img src="{$v.picurl}_400x400.jpg" alt="{$v.title}"/></a>
         {else}
            <li class="on"><a href="{$v.url}" target="_blank"><img src="{$v.picurl}_230x230.jpg" alt="{$v.title}" width="230" height="200" /></a>
          {/if}

          <div class="tit_desc">
            <div class="tit"><a href="{$v.url}" target="_blank">{$v.title}</a></div>
            <div class="desc"><a href="{$v.url}" target="_blank">{$v.description}...</a></div>
         </div>
            </li>
        {/foreach}
    	</ul>

</div>

-->


<div class="index2_contend cl">

{include file="../goods_list.php"}
    {if !empty($showpage)}
        <div class="redpage cl" >{$showpage}</div>
    {/if}
</div>


<!--
<div class="howcomed">
    <a href="{$URL}a=desktop"></a>
</div>
-->

<!--
<div class="foot">
    <div class="links cl"> <span>友情链接：</span>
      <div class="links_list_box">
        <ul class="links_list" style="margin-top: 0px;">
          <li>
                {foreach from= $_G.friend_link item = v name=a}
                 	{if $v.hide == 0}

                    <a href="{$v.url}" target="_blank">{$v.name}</a>
                    {/if}
                    {/foreach}

                <a href="http://www.ddapei.com/" target="_blank" title="搭配网">搭配网</a>

         </li>
        </ul>
      </div>

       {if $_G.setting.friend_post == 1}
       <span style="float:right">
       <a href="{$URL}a=friend_link_post">友链申请>></a></span>
       {/if}
</div>
</div>
-->
{include file="../footer.php"}


