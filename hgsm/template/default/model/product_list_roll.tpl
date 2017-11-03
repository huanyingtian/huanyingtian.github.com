<!-- 滚动开始 -->
<div id="demo">
<div id="indemo">
	<div id="demo1">
		<ul class="product_list roll_product clearfix">
			<!--{foreach $sp.recommend_product as $volist}-->
				<li>
					<a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img"><img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" /></a>
					<h3><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:20}--></a></h3>
				</li>
			<!--{/foreach}-->
		</ul>
	</div>
	<div id="demo2"></div>
	</div>
</div>
<!-- 滚动结束 -->	