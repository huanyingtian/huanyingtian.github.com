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
<link rel="stylesheet" type="text/css" href="<!--{$url_index}-->data/user.css?9.2" />
<script src="<!--{$skinpath}-->js/jquery-1.8.3.min.js?9.2"></script>
<script>
	var url = '<!--{$url_index}-->';
	var M_URL = '<!--{$m_path_url}-->';
	var about_cid = '<!--{$about_cid}-->';
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
	<div class="left">
		<div class="box sort_menu">
		  <h3>关于我们</h3>
		  	<ul class="sort">
			  	<li class="layer1">
			      <!--{foreach $page_list.about as $volist}-->
			        <a href="<!--{$volist.url}-->"<!--{if $volist.target != 1}-->target='<!--{$volist.target}-->'<!--{/if}-->><!--{$volist.title}--></a>
			      <!--{/foreach}-->
			    </li>
	        </ul>
		</div>
		<div class="box sort_product">
		  <h3>产品分类</h3>
		  <!--{include file="$tplpath/model/product_sort.tpl"}-->
		</div>
		<div class="box n_news">
			<h3>最新新闻</h3>
			<div class="content">
			   <ul class="news_list new1">
			   	   <!--{foreach $sp.news_laster as $volist}-->
			       <li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:25:'...'}--></a></li>
			     <!--{/foreach}-->
			   </ul>
			</div>
		</div>
		<div class="box n_news">
			<h3>热门关键词</h3>
			<div class="content">
			   <ul class="news_list words">
			   	 <!--{foreach $results as $volist}-->
			       <li><a href="<!--{$volist.url}-->" title="<!--{$volist.tag}-->"><!--{$volist.tag}--></a></li>
			     <!--{/foreach}-->
			   </ul>
			</div>
			<script type="text/javascript">
			  $(function(){
			  	$(".words li:odd").addClass("right_word");
			  });
			</script>
		</div>
		<div class="box n_contact">
		  <h3>联系我们</h3>
		  <p class="content"><!--{$delimit_contact_left}--></p>
		</div>
	</div>
	<div class="right">
	  <div class="sitemp clearfix">
	    <h2><!--{$p.cname}--></h2>
	    <div class="site">您的当前位置：
	    	<a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><span class="cc"><!--{$p.cname}--></span>
	    </div>
	  </div>
	  <div class="content">
	    <!--{$p.content}-->
	  </div>
	</div>
</div>
<!--{include file="$tplpath/model/foot.tpl"}-->
<!--底部JS加载区域-->
<script type="text/javascript" src="<!--{$skinpath}-->js/common.js?9.2"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/message.js?9.2"></script>
</body>
</html>