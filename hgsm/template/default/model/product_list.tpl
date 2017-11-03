<ul class="product_list clearfix">
	<!--{foreach $product as $volist}-->
		<li>
			<a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img"><img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" /></a>
			<h3><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:20}--></a></h3>
		</li>
	<!--{/foreach}-->
</ul>