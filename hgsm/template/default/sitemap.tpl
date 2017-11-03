<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title><!--{$page_title}--></title>
<meta name="keywords" content="<!--{$page_keyword}-->" />
<meta name="description" content="<!--{$page_description}-->" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/base.css" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/model.css" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/main.css" />
<link rel="stylesheet" type="text/css" href="<!--{$url_index}-->data/user.css?9.2" />
<script src="<!--{$skinpath}-->js/jquery-1.8.3.min.js"></script>
<!--{block name="insert_style"}--><!--{/block}-->
</head>
<body>


<div id="container" class="clearfix">
	  <div class="sitemp clearfix" style="margin-bottom:20px;background:none;border-bottom:2px solid #458fce;">
	    <h2 style="border:none">网站地图
	    </h2>
	    <div class="site">您的当前位置：
	    <!--{block name="site"}-->
	    	<a href="<!--{$url_index}-->">首 页</a>>> 网站地图
	    <!--{/block}-->
	    </div>
	  </div>
	<h3 class="map_title">关于我们</h3>
	<div class="map_list">
	  <!--{foreach $page_sort_all as $volist}-->
        <a href="<!--{$volist.url}-->"><!--{$volist.title}--></a>
      <!--{/foreach}-->
	</div>
	<div class="map_list">
	  <!--{foreach $page_sort_all as $volist}-->
        <a href="<!--{$volist.url}-->"><!--{$volist.title}--><!--{$cagoy_title}--></a>
      <!--{/foreach}-->
	</div>
	<h3 class="map_title">产品中心</h3>
	<div class="map_list">
   	  <!--{foreach $productCate as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.cname}--></a>
   	   <!--{/foreach}-->	
	</div>
	<div class="map_list">
   	  <!--{foreach $resultpro as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.title}--></a>
   	   <!--{/foreach}-->	
	</div>
	<div class="map_list">
   	  <!--{foreach $productCate as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.cname}--><!--{$cagoy_title}--></a>
   	   <!--{/foreach}-->	
	</div>
	<h3 class="map_title">新闻资讯</h3>
	<div class="map_list">
   	  <!--{foreach $news_sort as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.cname}--></a>
   	   <!--{/foreach}-->	
	</div>
	<div class="map_list">
   	  <!--{foreach $news_sort as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.cname}--><!--{$cagoy_title}--></a>
   	   <!--{/foreach}-->	
	</div>
	<h3 class="map_title">网站标签</h3>
	<div class="map_list">
   	  <!--{foreach $tag as $volist}-->
    	  <a href="<!--{$volist.url}-->"><!--{$volist.tag}--></a>
   	   <!--{/foreach}-->	
	</div>	
</div>
<!--{include file="$tplpath/model/foot.tpl"}-->
<!--底部JS加载区域-->
<script type="text/javascript" src="<!--{$skinpath}-->js/common.js"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/message.js"></script>
</body>
</html>