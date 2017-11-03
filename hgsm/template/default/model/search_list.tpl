

<div class="tag_total">全站搜索结果：产品：<!--{$p_count}-->个,新闻：<!--{$n_count}-->个</div>

<ul class="tag_list_product clearfix">

<!--{foreach $productlist as $volist}-->
  	<li>
  	<a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img"><img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" /></a>
	<h3><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:20}--></a></h3>
  	</li>
<!--{/foreach}-->
</ul>
<hr/>
<ul class="tag_list_news clearfix">
<!--{foreach $infolist as $volist}-->
  	<li>
	<h3>
  	[<a href="<!--{$volist.caturl}-->" class="c"><!--{$volist.cname}--></a>]
  	<a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title}--></a>
	</h3>
  	<div>
	<!--{$volist.abstract}-->
	</div>
	<span>发布时间：<!--{$volist.timeline|date_format:"%Y-%m-%d"}-->&nbsp;&nbsp;&nbsp;点击次数：<!--{$volist.hits}--></span>
	</li>
	<hr/>
  	</li>
<!--{/foreach}-->

</ul>
