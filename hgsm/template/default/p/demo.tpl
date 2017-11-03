<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><!--{$page_title}--></title>
<meta name="keywords" content="<!--{$page_keyword}-->" />
<meta name="description" content="<!--{$page_description}-->" />
<!--{if $config.pcico eq ''}--><!--{else}-->
<link rel="shortcut icon" type="image/x-icon" href="<!--{$url_index}--><!--{$config.pcico}-->" />
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/base.css?9.2" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/model.css?9.2" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/main.css?9.2" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/lightbox.css?9.2" />
<script src="<!--{$skinpath}-->js/jquery-1.8.3.min.js?9.2"></script>
<script src="<!--{$skinpath}-->js/mobile.js?9.2"></script>
<script>
var url = '<!--{$url_index}-->';
var cid = '<!--{$about_cid}-->';
var pathname = location.pathname;
var urlArray = pathname.split("/");
var name = '';
if((url.match(urlArray[1]))){
	for(i=2;i<urlArray.length;i++){
		name= name+"/"+urlArray[i];
	}
	name = url+"m"+name;
}else{
	name = url+"m"+pathname;
}
if(cid == 1)
{
	name = name.replace("/about/","/about_about/");
}
uaredirect(name);
</script>
<!--{block name="insert_style"}--><!--{/block}-->
</head>
<body>
<!-- 公共头部包含 -->
<!--{include file="$tplpath/model/head.tpl"}-->
<!-- 内页banner -->
<div class="n_banner"><img src="<!--{$ads_zone2[0].uploadfiles}-->" alt="<!--{$ads_zone2[0].adsname}-->" title="<!--{$ads_zone2[0].adsname}-->" /></div>
<!-- 主体部分 -->
<div id="container" class="clearfix">
   <div style="text-align:center">手动创建文件</div>
</div>
<!--{include file="$tplpath/model/foot.tpl"}-->
<!--底部JS加载区域-->
<script type="text/javascript" src="<!--{$skinpath}-->js/common.js?9.2"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/message.js?9.2"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/lightbox.js"></script>
</body>
</html>