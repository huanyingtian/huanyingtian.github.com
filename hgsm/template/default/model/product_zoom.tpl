<!-- 产品详细 -->
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/jquery.jqzoom.css" />
<script type="text/javascript" src="<!--{$skinpath}-->js/jquery.jqzoom-core.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            zoomWidth: 320,  
            zoomHeight: 250
        });
});

</script>

<div class="product_detail" id="pd1">
  <h1 class="title"><!--{$product.title}--></h1>
  <div class="img clearfix">
   <a href="<!--{$product.uploadfiles}-->" class="jqzoom" rel='gal1'  title="<!--{$product.title}-->" >
 	 <img src="<!--{$product.uploadfiles}-->" class="small" title="<!--{$product.title}-->" alt="<!--{$product.title}-->" />
   </a> 
  </div>
  <div class="list">
  <ul class="list_p">
  	<li><h2>所属分类：<a href="<!--{$product.caturl}-->"><strong><!--{$product.cname}--></strong></a></h2></li>
   	<li>点击次数：<span><script src="<!--{$urlpath}-->data/include/producthits.php?id=<!--{$product.id}-->"></script></span></li>
  	<li>发布日期：<span><!--{$product.timeline|date_format:"%Y/%m/%d"}--></span></li>
  	<li class="clearfix">
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
</li>
  	<li class="inquiry"><a href="<!--{$url_message}-->" >在线询价</a></li>
  </ul> 
  </div>
  <div class="clearboth"></div>
  <div class="p_detail">
    <span class="title"><strong>详细介绍</strong></span>
    <div class="content">
   		<!--{$product.content}-->
    </div>
  </div>
  <h3 class="tag">相关标签：<!--{$tag}--> </h3>
  <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>