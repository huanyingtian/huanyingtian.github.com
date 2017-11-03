<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
</script>
</head>
<body>

<!-- 公共头部包含 -->
<!--{include file="$tplpath/model/head_index.tpl"}-->
<!-- 首页banner -->
<!--{include file="$tplpath/model/index_banner.tpl"}-->
<div id="container">
	<!-- 产品分类 -->
	<div class="menu_cate">
	    <div class="cate_title">产品分类</div>
 		<!--{include file="$tplpath/model/product_sort.tpl"}-->
	</div>
	<div class="about">
	  <div class="about_title">关于我们</div>
	  <div class="content"><!--{$delimit_about}--></div>
	</div>
	<div class="news_company">
	  <div class="news1_title">公司新闻</div>
	  <div class="content">
	   <ul class="news_list new1">
	   	   <!--{foreach $sp.news_company as $volist}-->
	       <li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:25:'...'}--></a><span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span></li>
	     <!--{/foreach}-->
	   </ul>
	  </div>
	</div>
	<div class="clearboth"></div>
	<div class="contact">
	  <div class="contact_title">联系我们</div>
	  <div class="content"><!--{$delimit_contact}--></div>
	</div>	
	<div class="case">
	  <div class="case_title">技术优势</div>
	  <div class="content"><!--{$delimit_advantage}--></div>
	</div>
	<div class="news_company news2_company">
	  <div class="news1_title">行业新闻</div>
	  <div class="content">
	   <ul class="news_list new2">
	     <!--{foreach $sp.news_industry as $volist}-->
	       <li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:25:'...'}--></a><span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span></li>
	     <!--{/foreach}-->
	   </ul>
	  </div>
	</div>
	<div class="clearboth"></div>
	<!-- 推荐产品（滚动） -->
	<div class="recommend_product" >
		<div class="title">推荐产品</div>
		<div class="content">
			<!--{include file="$tplpath/model/product_list_roll.tpl"}-->
		</div>
	</div>
	<div class="news_company" style="margin-top:10px;">
	  <div class="news1_title">人才招聘</div>
	  <div class="content">
	   <ul class="news_list new1">
	       <!-- $commons->job(0,6,0) 参数1为分类cid，参数二为显示数量，参数为排序0或1 --> 
	   	   <!--{foreach $commons->job(0,6,0) as $volist}-->
	       <li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:25:'...'}--></a><span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span></li>
	     <!--{/foreach}-->
	   </ul>
	  </div>
	</div>
	<div class="clearboth"></div>
	<div class="index-title">客户留言</div>
	<table class="index-table">
      <tbody>
        <!-- $commons->message(0) 参数1显示数量 --> 
        <!--{foreach $commons->message(6) as $volist}-->
        <tr class="firstRow">
            <td width="100" valign="top"><!--{$volist.name}--></td>
            <td width="200" valign="top"><!--{$volist.telcontact}--></td>
            <td width="600" valign="top"><!--{$volist.content}--></td>
            <td width="100" valign="top" align="center"><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></td>
        </tr>
        <!--{/foreach}-->
      </tbody>
   </table>

</div>
<div class="f_link">友情链接：
    <!--{foreach $volist_fontlink as $volist}-->
	   <a href='<!--{$volist.linkurl}-->' target='_blank' <!--{if $volist.nofollow==0}-->rel="nofollow"<!--{/if}--> ><!--{$volist.linktitle}--></a>
	<!--{/foreach}-->
</div>
<!--{include file="$tplpath/model/foot.tpl"}-->
<!--底部JS加载区域-->
<script type="text/javascript" src="<!--{$skinpath}-->js/common.js?9.2"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/message.js?9.2"></script>
<script>
	bb1();	  //首页banner切换
	scroll(); //产品滚动
</script>
</body>
</html>