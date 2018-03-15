{include file="./header.php"}
<link rel="stylesheet" type="text/css" href="{$IMGDIR}/sign.css">

<div class="wrapper">
    <a class="part user" href="show://user">
        <div class="inline u-avatar" {if $_G.member.picurl}style="background: url({$_G.member.picurl}) ;background-size: 3.4rem;"{/if}></div>
        <div class="inline u-name">{$_G.username}</div>
        <div class="inline u-score">{$_G.member.jf}<span> 积分</span></div>
    </a>
    <div class="part calendar">
        <div class="date-box">
            <div class="icon-cal"></div>
            <div class="month _dgmdate" data-time="{$_G.today}" data-type="Y/m/d"></div>
            <div class="sign-info">今天已有<span>{$today_count}</span>人签到</div>
        </div>

        <div class="calendar-main" data-data_list = "{$data}" data-url="{$sign_url}"></div>

    </div>
    <div class="part sign-p">
        <div id="sign-tip">连续签到第{$qd_count}天</div>
        <a class="btn-sign {if $today_is_qd >0}signed{else}sign{/if}" href="{$urlsche}://?a=sign"  data-url="{$sign_url}"></a>
    </div>
    <div class="part option">
        <a class="invite" id="btnInvite" href="{$urlsche}://?a=share&type=yaoqing">
            <i class="inline icon-diamond"></i>
            <p class="inline tixmsg">邀请好友玩{$_G.setting.title}</p>
            <i class="inline icon-arrow"></i>
        </a>
        <div class="remind" style="display: none;">
            <i class="inline icon-clock"></i>
            <p class="inline ">每天提醒我来签到</p>
            <label class="switch remind-switch">
                <input id="checkbox_private" type="checkbox">
                <i></i>
            </label>
        </div>
    </div>
</div>
<div class="pop">
    <div class="pop-body">
        <div class="pop-title">签到成功</div>
        <div class="pop-bg"></div>
        <div class="pop-info"></div>
        <a class="pop-btn-confirm">确定</a>
    </div>
</div>

<script type="text/javascript" src="{$_G.siteurl}{$TPLDIR}/js/zepto.min.js"></script>
<script type="text/javascript" src="{$IMGDIR}/calendar.js"></script>
<script type="text/javascript" src="{$IMGDIR}/sign.js"></script>
</body></html>
