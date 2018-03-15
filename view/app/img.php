{include file="./header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/img.css" media="all">
 <script type="text/javascript" src="{$TPLDIR}/js/zepto.min.js"></script> 
<div class="top_img"><img src="{$picurl}" ></div>
 <h1 class="title">{$title}</h1>

<div class="content content_box" data-urlscche="{$urlsche}">
<div class="content_top">
<div class="dingcai"><span class="iconfont">&#xe62f;</span><i>({$like})</i>  <span class="iconfont">&#xe630;</span><i>({$hate})</i></div>

发布时间: <i>{$dateline}</i>
</div>
     {$message}
     
<div class="tag_list cl">
	<div class="cl tag_title">相关标签</div>
    {foreach from=$tags item=v}
    <a href="{$urlsche}://?a=open_img_tag&tag={$v}">{$v}</a>
    {/foreach}
</div>
 </div>

<script type="text/javascript">


	var urlsche = $('.content_box').data('urlscche');
	$(".item_kw a").each(function(){
		var tag = $(this).text();
		$(this).attr('href',urlsche+'://?a=open_img_tag&tag='+tag);
		
		//window.postMessage('aaa',"*");
		
	});
	
	/*$(".item_url").each(function(){
		var num_iid = $(this).data('num_iid');
		//window.postMessage('aaa',"*")
		$(this).attr('href',urlsche+'://?a=open_taobao&num_iid='+num_iid);
	});*/
	
	$(".content_box .con img").each(function(){
		$(this).removeAttr('width height');
	});
	
</script>
 
{include file="./footer.php"}


