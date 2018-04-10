<ul class="cl">
    <form method="post">
        <li class="uc_zlli2"><span>请完善以下信息获得认证，否则可能会影响订单返利。</span></li>
        <li class="uc_zlli">
            <label>身份证号码：</label>
            <input class="uinfo text"  name="postdb[id]" type="text">
        <li class="uc_zlli">
            <label>有效订单号：</label>
            <input class="uinfo text"  name="postdb[order_num]" type="text">
        </li>
        <li class="uc_zlli">
            <label></label>
            <input type="submit" class="seting_onsubmit u_submit"   name="onsubmit"value="认证" />
        </li>
        <input type="hidden" name="m" value="{$CURMODULE}" />
        <input type="hidden" name="a" value="setting" />
    </form>
</ul>