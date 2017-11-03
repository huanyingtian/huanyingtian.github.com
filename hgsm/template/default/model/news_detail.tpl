<!-- 新闻详细 -->
<div class="news_detail">
	<h1 class="title"><!--{$news.title}--></h1>
<div class="info_title clearfix">	
	<h3 class="title_bar">
	 发布日期：<span><!--{$news.timeline|date_format:"%Y-%m-%d"}--></span>
	 作者：<span><!--{$news.author}--></span>
	 点击：<span><script src="<!--{$urlpath}-->data/include/newshits.php?id=<!--{$news.id}-->"></script></span> 
	</h3>
	<div class="share">
<!-- Baidu Button BEGIN -->
<div class="bdsharebuttonbox">
<a href="#" class="bds_more" data-cmd="more"></a>
<a href="#" class="bds_qzone" data-cmd="qzone"></a>
<a href="#" class="bds_tsina" data-cmd="tsina"></a>
<a href="#" class="bds_tqq" data-cmd="tqq"></a>
<a href="#" class="bds_renren" data-cmd="renren"></a>
<a href="#" class="bds_weixin" data-cmd="weixin"></a>
</div>
<script>
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
<!-- Baidu Button END -->	
	</div>
</div>	
	<div class="content"><!--{$news.content}--></div>
	<h3 class="tag">本文网址：<!--{$news.url}--> </h3>
    <h3 class="tag">相关标签：<!--{$tag}--> </h3>
    <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>