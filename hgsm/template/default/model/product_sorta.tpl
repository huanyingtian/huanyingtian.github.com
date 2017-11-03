<ul class="sort_a">
  <!--{foreach $data_home as $volist}-->
  	<div class="layer1">
      <a href="<!--{$volist.url}-->" title="<!--{$volist.cname}-->" class="img"><img src="<!--{$volist.img}-->" alt="<!--{$volist.cname}-->" /></a>
      <div class="img_right">
          <h3><a href="<!--{$volist.url}-->" title="<!--{$volist.cname}-->"><!--{$volist.cname|truncate:25}--></a></h3>
          <span><!--{$volist.intro}--></span>
      </div>
      <div class="clearboth"></div>
      <div class="pro_more"><span>+</span><a href="<!--{$volist.url}-->">查看详情》</a></div>
    </div>
    <div class="abb_product">
      <ul class="product_list clearfix">
        <!--{foreach $volist.product as $seclist}-->
          <li>
            <a href="<!--{$seclist.url}-->" title="<!--{$seclist.title}-->" class="img"><img src="<!--{$seclist.thumbfiles}-->" alt="<!--{$seclist.title}-->" /></a>
            <h3><a href="<!--{$seclist.url}-->" title="<!--{$seclist.title}-->"><!--{$seclist.title|truncate:20}--></a></h3>
          </li>
        <!--{/foreach}-->
      </ul>
    </div>
  <!--{/foreach}-->   
</ul>
<script type="text/javascript">
  $(function(){
    $(".sort_a .abb_product").each(function(){
      var num = $(this).find(".product_list li").length;
      if(num == 0){
        $(this).hide();
      }
    });
  });
</script>