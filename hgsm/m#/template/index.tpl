<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<link rel="apple-touch-icon-precomposed" href="<!--{$murl_index}-->icon.png"/>
<title><!--{$config.sitetitle}--></title>
<meta name="keywords" content="<!--{$metakeyword}-->" />
<meta name="description" content="<!--{$metadescription}-->" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/reset.css" />
<link rel="stylesheet" type="text/css" href="<!--{$m_path}-->style/<!--{$csspath}-->/ui.css" />

<script type="text/javascript" src="<!--{$m_path}-->js/zepto.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/iscroll.js"></script>
<script type="text/javascript" src="<!--{$m_path}-->js/scroll.js"></script>

<script type="text/javascript">
	var HOME_URL = '<!--{$murl_index}-->';
	var ajax_url = '<!--{$murl_index}-->library/ajax_load.php';
	var title    = '<!--{$config.mtitle}-->';
</script>

</head>
<body>
<!--{include file="$pathtpl/template/model/header.tpl"}-->
<!--{include file="$pathtpl/template/model/nav.tpl"}--> 
<!--{include file="$pathtpl/template/model/banner.tpl"}-->
<div class="search">
  <form method="get" name="formsearch" id="formsearch" class="clearfix" action="<!--{$url_index}-->search.php">
    <input type='text' name='wd' id="keyword" value="" placeholder="请输入搜索关键词" />
    <input type="submit" id="s_btn" value="搜索" />
  </form>
</div>
 <div class="products">
       <div class="products_title">
          公司简介
       </div>
       <div class="contentss">
          <!--{$delimit_about}-->
       </div>
 </div>
 
 <div class="products">
       <div class="products_title">
          产品中心
       </div>
       <ul>
        <!--{foreach $product as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
                   <img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" />
                   <h3><!--{$volist.title|truncate:20}--></h3>
                </a>   
            </li>
        <!--{/foreach}-->
       </ul>
 </div>
 
 
 <div class="news">
       <div class="news_title">
          最新资讯
       </div>
       <ul>
          <!--{foreach $news_index as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"> 
                   <!--{$volist.title|truncate:36}--> 
                </a>
                
            </li>
         <!--{/foreach}-->
       </ul>
 </div>
 
 
   <div class="products">
       <div class="products_title">
          联系我们
       </div>
       <div class="contentss ee">
          <!--{$delimit_contact}-->
       </div>
 </div> 
 
 <div class="distraction">
 </div>
<!--{include file="$pathtpl/template/model/footer.tpl"}-->
 <!--{include file="$pathtpl/template/model/plug.tpl"}-->
 <script>
   $('.news ul li').last().css('border-bottom','none');
	 $('.product_cate ul li').last().css('border-bottom','none');
 </script>
</body>
</html>