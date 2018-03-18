<?php
$app_key = '24823497';/*填写appkey */
$secret='ed5a6ec9bd9906c0ebcde9ccc4f508e3';/*填入Appsecret'*/
$timestamp=time()."000";
$message = $secret.'app_key'.$app_key.'timestamp'.$timestamp.$secret;
$mysign=strtoupper(hash_hmac("md5",$message,$secret));
setcookie("timestamp",$timestamp);
setcookie("sign",$mysign);
?>x1x
<!DOCTYPE html>
<html>

<head>
    <script src="http://l.tbcdn.cn/apps/top/x/sdk.js?appkey='http://localhost:8652/'"></script>
</head>
<body>
<div data-type="4" data-plugin="aroundbox" data-plugin-aroundbox-fixed="1"></div>
<a data-type="0" biz-itemid="44284984392" data-style="2" data-tmpl="230x312" target="_blank">
    淘点金_单品_直接展示230x312
</a>
<a data-type="6" data-tmpl="573x66" data-border="0" data-tmplid="140" data-style="2" biz-s_logo="1" biz-s_hot="1" href="#">搜索框</a>
<script type="text/javascript">
    (function(win,doc){
        var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
        if (!win.alimamatk_show) {
            s.charset = "gbk";
            s.async = true;
            s.src = "https://alimama.alicdn.com/tkapi.js";
            h.insertBefore(s, h.firstChild);
        };
        var o = {
            pid: "mm_97928704_43428463_322620247",/*推广单元ID，用于区分不同的推广渠道*/
            appkey: "",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
            unid: "",/*自定义统计字段*/
            monitor: function(msg){
                console.log(msg)
            },
        };
        win.alimamatk_onload = win.alimamatk_onload || [];
        win.alimamatk_onload.push(o);
    })(window,document);
</script>

</body>
</html>
