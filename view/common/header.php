<!doctype html>
<html class="taeapp {if $TAE==1}tae{else}web{/if} _{$CM} _{$CM}_{$CA}">
<head>
    <meta charset="utf-8">
    <title>{if $_G.title}{$_G.title}{else}{$_G.setting.title}{/if}</title>
    <link href="/favicon.ico" type="image/x-icon" rel=icon/>
    <meta name="keywords" content="{$_G.keywords}"/>
    <meta name="description" content="{$_G.description}"/>
    <meta name="tk" content="0|{$_G.setting.taodianjing_url}|{$_G.setting.tdj_type}"/>
    <meta name="get" content="{$query_text}"/>
    <meta name="set" content="{$global_str}"/>
    <link type="text/css" rel="stylesheet" href="/assets/global/css/bootstrap.min.css">
    <script type="text/javascript" src="/assets/global/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/assets/simpler/js/materialize.min.js"></script>
    <script type="text/javascript" src="/assets/global/js/global.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/global/css/global.css" media="all"/>
</head>
<body>
<div class="uz_system"></div>
