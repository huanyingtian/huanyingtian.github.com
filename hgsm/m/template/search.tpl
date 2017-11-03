<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<link rel="apple-touch-icon-precomposed" href="<!--{$murl_index}-->icon.png"/>
<title><!--{$config.mtitle}-->_<!--{$config.sitetitle}--></title>
<meta name="keywords" content="<!--{$metakeyword}-->" />
<meta name="description" content="<!--{$metadescription}-->" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/reset.css" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/ui.css" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/app.css" /> 
<script type="text/javascript" src="<!--{$m_path}-->js/zepto.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/iscroll.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
  var HOME_URL = '<!--{$murl_index}-->';
  var ajax_url = '<!--{$murl_index}-->library/ajax_load.php';
  var title = '<!--{$config.mtitle}-->';
</script>
</head>
<body>
   <!--{include file="$pathtpl/template/model/header.tpl"}-->
   <!--{include file="$pathtpl/template/model/nav.tpl"}-->
 <div class="products">
       <div class="products_title">
       搜索结果:产品<!--{$p_count}-->个、新闻<!--{$n_count}-->条
       </div>
       <ul>
        <!--{foreach $productlist as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
                   <img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" />
                   <h3><!--{$volist.title|truncate:20}--></h3>
                </a>
                
            </li>
        <!--{/foreach}-->
        </ul>
 </div>
 <ul class="newslist">
 <!--{foreach $infolist as $volist}-->
    <li>
       <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:26}--></a>  
       <span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span>
    </li>
  <!--{/foreach}-->
</ul>
<div class="distraction">
</div>
<!--{include file="$pathtpl/template/model/footer.tpl"}-->
<!--{include file="$pathtpl/template/model/plug.tpl"}-->
</body>
</html>