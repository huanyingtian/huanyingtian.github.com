<!-- start -->
<link rel="stylesheet" href="<!--{$skinpath}-->style/quanju.css" type="text/css" media="all">
<script src="<!--{$skinpath}-->js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
<!-- end -->
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
<div class="allcontent clearfix">
 <div class="img clearfix" id="play">
     <ul class="img_ul">
       <li><a href="<!--{$product.uploadfiles}-->" class="jqzoom img_a" rel='gal1'  title="<!--{$product.title}-->" >
            <img src="<!--{$product.uploadfiles}-->" class="small" title="<!--{$product.title}-->" alt="<!--{$product.title}-->" />
         </a> </li>
       <!--{foreach $arrimg as $volist}-->
        <li><a href="<!--{$volist}-->" class="jqzoom img_a" rel='gal1'  title="<!--{$volist}-->" >
            <img src="<!--{$volist}-->" class="small" title="<!--{$volist}-->" alt="<!--{$volist}-->" />
         </a> 
         </li>
       <!--{/foreach}-->
       </ul>
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
  </div>
  <div class="img_hd">
   <ul class="clearfix">
      <li><a class="img_a"><img src="<!--{$product.uploadfiles}-->" onload="imgs_load(this)"></a></li>
      <!--{foreach $arrimg as $volist}-->
        <li><a class="img_a"><img src="<!--{$volist}-->" onload="imgs_load(this)"></a></li>
      <!--{/foreach}-->
   </ul>
    <a class="bottom_a prev_a" style="opacity: 0.7; "></a> <a class="bottom_a next_a" style="opacity: 0.7; "></a>
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

<script>
var abc=0; //图片标识
var img_num=$(".img_ul").children("li").length; //图片个数
$(".img_ul li").hide(); //初始化图片 
play();
$(function(){
   $(".img_hd ul").css("width",($(".img_hd ul li").width())*img_num+60); //设置ul的长度  //这里需要修改
   $(".bottom_a").css("opacity",0.7); //初始化底部a透明度
   //$("#play").css("height",$("#play .img_ul").height());
   if (!window.XMLHttpRequest) {//对ie6设置a的位置
   $(".change_a").css("height",$(".change_a").parent().height());}
   $(".change_a").focus( function() { this.blur(); } );
   $(".bottom_a").hover(function(){//底部a经过事件
     $(this).css("opacity",1);  
     },function(){
    $(this).css("opacity",0.7);  
       });
   $(".change_a").hover(function(){//箭头显示事件
     $(this).children("span").show();
     },function(){
     $(this).children("span").hide();
       });
   $(".img_hd ul li").click(function(){
     abc=$(this).index();
     play();
     });
   $(".prev_a").click(function(){
     //i+=img_num;
     abc--;
     //i=i%img_num;
     abc=(abc<0?0:abc);
     play();
     }); 
   $(".next_a").click(function(){
     abc++;
     //i=i%img_num;
     abc=(abc>(img_num-1)?(img_num-1):abc);
     play();
     }); 
  

   }); 
function play(){//动画移动  
  var img=new Image(); //图片预加载
  img.onload=function(){img_load(img,$(".img_ul").children("li").eq(abc).find("img"))};
  img.src=$(".img_ul").children("li").eq(abc).find("img").attr("src");
  //$(".img_ul").children("li").eq(i).find("img").(img_load($(".img_ul").children("li").eq(i).find("img")));
 
  $(".img_hd ul").children("li").eq(abc).addClass("on").siblings().removeClass("on");
  if(img_num>4){//大于7个的时候进行移动        //这里需要修改
    if(abc<img_num-1){ //前3个   //这里需要修改
    $(".img_hd ul").animate({"marginLeft":(-($(".img_hd ul li").outerWidth()+4)*(abc-3<0?0:(abc-3)))});
    }
    else if(abc>=img_num-1){//后3个
      $(".img_hd ul").animate({"marginLeft":(-($(".img_hd ul li").outerWidth()+4)*(img_num-4))});   //这里需要修改
      }
  }
  if (!window.XMLHttpRequest) {//对ie6设置a的位置
  $(".change_a").css("height",$(".change_a").parent().height());}

 
  }
function img_load(img_id,now_imgid){//大图片加载设置 （img_id 新建的img,now_imgid当前图片）
    if(img_id.width/img_id.height>1)
    {
    if(img_id.width >=$(".img").width()){}
    }
    else 
    {
    //if(img_id.height>=500) $(now_imgid).height(500);
    }
    
    $(".img_ul").children("li").eq(abc).show().siblings("li").hide(); //大小确定后进行显示
  }
function imgs_load(img_id){//小图片加载设置
  if(img_id.width >=$(".img_hd ul li").width())
    {img_id.width = 50};
  }
  if($('.img_hd ul li').length <=1){
    $('.img_hd').css('display','none');
  }
  </script>