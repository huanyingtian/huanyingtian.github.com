<!-- 相关产品和相关新闻 --> 
<div class="relate_list">
 <div class="relateproduct relate"><h4>相关产品：</h4>
    <div class="content">
     <ul id="relate_p" class="product_list clearfix">
	  <!--{foreach $relatedproduct as $volist}-->
		<li>
			<a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
				<img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" width="120" height="96" />
			</a>
			<h3><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:20}--></a></h3>
		</li>
	  <!--{/foreach}-->
     </ul>
    </div>
  </div>        
  <div class="relatenew relate"><h4>相关新闻：</h4>
    <div class="content">
    <ul id="relate_n" class="news_list clearfix">
  	<!--{foreach $relatednew as $volist}-->
  		<li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title}--></a></li>
 	<!--{/foreach}-->
   </ul>
    </div>
  </div>	
</div>