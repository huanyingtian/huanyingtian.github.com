<!-- 产品详细 -->
<div class="product_detail" id="pd1">
  <h1 class="title"><!--{$product.title}--></h1>
  <div class="img"><img src="<!--{$product.uploadfiles}-->" alt="<!--{$product.title}-->" /></div>
  <div class="list">
  <ul class="list_p">
  	<li><h2>所属分类：<a href="<!--{$product.caturl}-->"><strong><!--{$product.cname}--></strong></a></h2></li>
   	<li>点击次数：<span><script src="<!--{$urlpath}-->data/include/producthits.php?id=<!--{$product.id}-->"></script></span></li>
  	<li>发布日期：<span><!--{$product.timeline|date_format:"%Y/%m/%d"}--></span></li>
  	<li class="clearfix">
<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
<a class="bds_qzone"></a>
<a class="bds_tsina"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<span class="bds_more">更多</span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&uid=6513684" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
</li>
  	<li class="inquiry"><a href="<!--{$url_message}-->" >在线询价</a></li>
  </ul> 
  </div>
  <div class="clearfix"></div>
  <div class="p_detail">
    <span class="title"><strong>详细介绍</strong></span>
    <div class="content">
   		<!--{$product.content}-->
    </div>
  </div>
  <h3 class="tag">相关标签：<!--{$tag}--> </h3>
  <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>