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
  <div class="clearboth"></div>
    <style type="text/css">
      .p_detail {margin-top: 10px;}
      .p_detail ul {height: 30px;line-height: 30px;background: #eee;border:1px solid #ddd;}
      .p_detail ul li{float: left;width: 100px;line-height:30px;text-align:center;cursor: pointer;}
      .p_detail ul li:hover{background: #ddd;} 
      .p_detail ul li.on{background: #ddd;cursor: default;}
      .tab .content {display: none}
      .tab .content.on {display: block;}
    </style>
  <div class="p_detail">
    <ul class="tab-title">
      <li class="on">详细内容</li>
      <li>扩展标签1</li>
      <li>扩展标签2</li>
      <li>扩展标签3</li>
    </ul>
    <div class="tab">
      <div class="content on"><!--{$product.content}--></div>      
      <div class="content"><!--{$product.extend1}--></div>      
      <div class="content"><!--{$product.extend2}--></div>      
      <div class="content"><!--{$product.extend3}--></div>
    </div>
  </div>
  <h3 class="tag">相关标签：<!--{$tag}--> </h3>
  <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>

<script>
$(function(){
	$('#productnav').on('click', 'a', function(){
		var $index=$(this).index();
		$(this).addClass('color').siblings().removeClass('color');
		$('#productcontent > .none').eq($index).show().siblings().hide();
	})

  $('.tab-title > li').on('click', function(){
    $(this).addClass('on').siblings().removeClass('on');
    var index = $(this).index();
    $('.tab > .content').eq(index).addClass('on').siblings().removeClass('on');
  });
})
</script>