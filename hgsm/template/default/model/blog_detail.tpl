<!-- 新闻详细 -->
<div class="news_detail">
	<h1 class="title"><!--{$blog.title}--></h1>
<div class="info_title clearfix">	
	<h3 class="title_bar">
	  发布日期：<span><!--{$blog.timeline|date_format:"%Y-%m-%d %H:%M"}--></span>
	 来源：<span><!--{$source_url}--></span>
	 点击：<span><script src="<!--{$urlpath}-->data/include/bloghits.php?id=<!--{$blog.id}-->"></script></span> 
	</h3>
	<div class="share">
<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
<a class="bds_tsina"></a>
<a class="bds_qzone"></a>
<a class="bds_tqq"></a>
<a class="bds_hi"></a>
<a class="bds_qq"></a>
<a class="bds_tieba"></a>
<span class="bds_more">更多</span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6513684" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->	
	</div>
</div>	
	<div class="content"><!--{$blog.content}--></div>
    <h3 class="tag">相关标签：<!--{$tag}--> </h3>
   <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>