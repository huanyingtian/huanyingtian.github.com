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

<script src="<!--{$skinpath}-->js/jquery-1.8.3.min.js?9.2"></script>
<script src="<!--{$skinpath}-->js/jquery.SuperSlide.2.1.1.js?9.2"></script>

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

<div class="img_heng1"><!--{$delimit_m_heng1}--></div>

<div class="clearboth"></div>

<div class="search">
  <form method="get" name="formsearch" id="formsearch" class="clearfix" action="<!--{$url_index}-->search.php">
    <input type='text' name='wd' id="keyword" value="" placeholder="请输入搜索关键词" />
    <input type="submit" id="s_btn" value="" />
  </form>
</div>
<div class="clearboth"></div>

<div class="title2">产品中心</div>
 <div class="index_pro02 clearfix">
            <ul>
            <!--{foreach $productCate as $volist}-->
            <li><a href="<!--{$volist.url}-->"<!--{if $volist.target != 1}-->target='<!--{$volist.target}-->'<!--{/if}-->><!--{$volist.cname}--></a></li>
           <!--{/foreach}-->
            </ul>

</div>

<script>
$('.index_pro02 li:gt(3)').remove();
</script>

<div class="product">
   <ul class="clearfix">
        <!--{foreach $sp.news_industry as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
                   <img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" />
                   <h3><!--{$volist.title}--></h3>
                </a>
            </li>
        <!--{/foreach}-->
       </ul>
</div>
<a class="amore" href="product/">查看更多</a>
<script>
$('.product li:gt(3)').remove();
</script>


<div class="clearboth"></div>
<div class="a1 clearfix">
  <div class="a1a">
<h2>关于我们</h2>
<div class="a1a_co">  <!--{$delimit_abouts}--></div>
 <a href="/about/">查看更多</a>
  </div>
  <div class="a1b"><!--{$delimit_mabouttu}--></div>
</div>
<div class="clearboth"></div>
<div class="xin">
  <div class="title2">新闻中心</div>
  <div class="newss">

                <ul class="news_list2">
          <!--{foreach $news_index as $volist}-->
            <li>
               <div class="news-time">
                        <div class="time1"><!--{$volist.timeline|date_format:"%d"}--></div>
                        <div class="time2"><!--{$volist.timeline|date_format:"%Y-%m"}--></div>
                        </div>
                <div class="nw"> <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:20:'...'}--></a>
                        <p><!--{$volist.summary|truncate:58:'...'}--></p></div>
            </li>
         <!--{/foreach}-->
       </ul>
<a class="amore" href="/news/" style="margin-top:23px">查看更多</a>
      </div>
</div>
<div class="clearboth"></div>
<div class="a3">
<div class="a3a">
  <!--{$delimit_lianxi}--></div>
</div>
 <div class="distraction">

 </div>
<!--{include file="$pathtpl/template/model/footer.tpl"}-->
 <!--{include file="$pathtpl/template/model/plug.tpl"}-->

 <script>
   $('.news ul li').last().css('border-bottom','none');
   $('.product_cate ul li').last().css('border-bottom','none');
 </script>

<!--{block name="gotop"}-->
  <div id="gotop"></div>
  <script type="text/javascript" src="<!--{$m_path}-->js/gotop.js"></script>
<!--{/block}-->


</body>
</html>
