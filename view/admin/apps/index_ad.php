{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  <div class="table_top">app启动广告图</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
     <input type="hidden" name="size" value="{$size}" class="add_size">
     
<tbody class="hdp_m">




    <tr class="noborder">
          <td class="td_l">是否开启广告:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[status]" value="1" {if $ad.status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[status]" value="0" {if $ad.status=='0'}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启APP启动时展示的第一屏广告</td>
        </tr>


 <tr class="noborder ">
          <td class="td_l">图片地址:</td>
          <td class="vtop rowform _hover_img">

<div class="z ">
<input name="postdb[picurl]" value="{$ad.picurl}" type="text" style="width: 305px;" >
<input type="file" name="file" class="file" style="width:300px;"/>
<a href="{$ad.picurl}" target="_blank"><img src="{$ad.picurl}" alt=""></a>
</div>

          </td>
          <td class="vtop tips2">广告图片地址</td>
 </tr>

 <tr class="noborder">
          <td class="td_l">链接地址:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$ad.url}"  class="txt"  ></td>
          <td class="vtop tips2">点击图片跳打开的页面.或跳转的地址,留空则不跳转,直接进入首页</td>
 </tr>
  <tr class="noborder">
          <td class="td_l">显示标题:</td>
          <td class="vtop rowform"><input  name="postdb[title]" value="{$ad.title}"  class="txt"  ></td>
          <td class="vtop tips2">有链接地址就必填打开页面的展示标题,没有链接地址可留空</td>
 </tr>


    <tr class="noborder">
          <td class="td_l">广告展示时间:</td>
          <td class="vtop rowform"><input class="txt w90" type="text" name="postdb[time]" value="{$ad.time}" /> 秒 </td>
          <td class="vtop tips2">多少秒后自动跳过广告</td>
        </tr>
  
   <tr class="noborder">
          <td class="td_l">显示跳过按钮:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[btn]" value="1" {if $ad.btn==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[btn]" value="0" {if $ad.btn==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否显示跳过按钮,选否则不出现跳过按钮</td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 