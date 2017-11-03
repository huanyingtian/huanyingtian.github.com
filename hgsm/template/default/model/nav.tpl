<div id="menu fr" >  
  <ul class="nav clearfix">
      <li><a href="<!--{$url_index}-->"><!--{$lang_index}--></a></li>      
      <li><a href="<!--{$url_about}-->"><!--{$lang_about}--></a>
        <div class="sec">
               <!--{foreach $page_list.about as $volist}-->
                  <a href="<!--{$volist.url}-->"<!--{if $volist.target != 1}-->target='<!--{$volist.target}-->'<!--{/if}-->><!--{$volist.title}--></a>
                <!--{/foreach}-->
        </div>
      </li>
      <li><a href="<!--{$url_news}-->"><!--{$lang_news}--></a>
        <div class="sec">
               <!--{foreach $news_sort as $volist}-->
                  <a href="<!--{$volist.url}-->"><!--{$volist.cname}--></a>
                <!--{/foreach}-->
        </div>
      </li> 
      <li><a href="<!--{$url_product}-->"><!--{$lang_product}--></a>
        <div class="sec">
           <!--{foreach $productCate as $volist}-->
            <a href="<!--{$volist.url}-->"<!--{if $volist.target != 1}-->target='<!--{$volist.target}-->'<!--{/if}-->><!--{$volist.cname}--></a>
           <!--{/foreach}-->
        </div>
      </li>
      <li><a href="<!--{$url_job}-->" rel="nofollow"><!--{$lang_job}--></a></li>    
      <li class="lxff"><a href="<!--{$url_about}-->contact.html"><!--{$lang_about}--></a></li>
  </ul>
</div> 

<script type="text/javascript">

$(function(){
	$('.nav > li').hover(function(){
		var sec_count  = $(this).find('.sec a').length;
		var a_height   = $(this).find('.sec a').eq(0).height(); 
		var sec_height =  sec_count * a_height;
		$(this).find('.sec').stop().animate({height:sec_height},300);
	},function(){
		$(this).find('.sec').stop().animate({height:0},300);
	});
});


</script>
