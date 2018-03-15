{include file='../common_admin/left_bar.php'}
<script src="/assets/admin/js/quan_upload.js"></script>

<form enctype="multipart/form-data" method="post">
  <div class="table_main" data-key="{$_G.setting.syn_key}">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">使用说明:</td>
          <td class="vtop rowform" data-left="150" colspan="2" style="font-size: 14px;line-height: 24px">
            <p>
            1,在阿里妈妈后台下单优惠券订单信息,然后在此入进行批量导入
          <a href="http://pub.alimama.com/myunion.htm?#!/promo/self/items" target="_blank" class="red">立即下载</a>
          </p>
          <p>2,下载成功后,文件比较大(几十MB),然后打开这个下载的excel->启用编辑,然后->文件->另存为->"Unicode 文本(*.txt)"->保存</p>
          <p>3,在此处点击上传文件,将刚另存为的txt文件选择,然后点击下方的开始发布</p>
          <p>注意:浏览器必须为chrome或是360极速或猎豹,或是UC,百度等浏览器,否则不支持.</p>
          <p>发布期间,请不要关闭本窗口,但是你可以打开一个新页面继续做其它后台的工作,不会影响此处的发布</p>
          <p>发布间隔默认为5秒一次,每次发布50条商品,下载的商品共1万条,商品估计都是走高佣的(没测试)</p>
          <p>如果发布成功数为0,则可能是商品已存在,发布后需要手动修改分类,没有办法自动给商品分类.如果你懒的分类都不想弄,请不要使用此功能了</p>
            </td>
          </tr>



        <tr class="noborder" >
          <td class="td_l">txt文件:</td>
          <td class="vtop rowform "><input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2" >淘宝联盟导出的选品库,格式为xls文件,然后导出为文本文件txt</td>
        </tr>


        <tr class="noborder update_tr" >
          <td class="vtop rowform" colspan="3">

 <div class="post_count" style="font-size: 16px;">
    共读取到商品 <span>0</span> 条,正在进行第
     <span>0</span>/<span>0</span> 页
</div>
          </td>
        </tr>
        <tr class="noborder update_submit" >
          <td class="td_l">&nbsp;</td>
          <td class="vtop rowform" colspan="3">
          <!-- <input type="submit" class="btn submit_btn"  name="onsubmit"  value="立即上传"></td> -->
          <input type="button" class="btn submit_btn"   value="立即发布"></td>
        </tr>


 <tr class="noborder update_submit" >
         
          <td class="vtop rowform" colspan="4">
            <div class="log_box" style="font-size: 14px;line-height: 20px;">   </div>

          </td>
        </tr>


      </tbody>
    </table>
  </div>

  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
