<ul class="sort_a">
  	<div class="layer1">
      <a href="<!--{$cust_val.url}-->" title="<!--{$cust_val.cname}-->" class="img"><img src="<!--{$url_index}--><!--{$cust_val.img}-->" alt="<!--{$cust_val.cname}-->" /></a>
      <div class="img_right">
          <h3><a href="<!--{$cust_val.url}-->" title="<!--{$cust_val.cname}-->"><!--{$cust_val.cname|truncate:25}--></a></h3>
          <span><!--{$cust_val.intro}--></span>
      </div>
      <div class="clearboth"></div>  
      <div class="pro_more"><span>+</span><a href="<!--{$cust_val.url}-->">查看详情》</a></div>
    </div> 
    <div class="catemore"><h2>分类优势</h2><a href="javascript:;">收起</a><img style="position:absolute;right:0px;top:10px;" src="<!--{$skinpath}-->images/catem.png" /></div>
    <div class="productcates"><!--{$cust_val.content}--></div>
</ul>
<script type="text/jscript">
  $(function(){
  var path_a = "<!--{$skinpath}-->images/catem.png";
  var path_b = "<!--{$skinpath}-->images/caten.png";
  var content= $(".productcates");
  $(".catemore a").click(function(){
     content.toggle(600,function(){
       if(content.css('display') == "none"){  
       $(".catemore a").text("查看");
       $(".catemore a").siblings("img").attr("src",path_b);
     }else{
       $(".catemore a").text("收起");
       $(".catemore a").siblings("img").attr("src",path_a);
     }
     });
  });
  });
</script>