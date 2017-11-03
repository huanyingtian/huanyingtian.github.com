<ul class="news_list clearfix">
  <!--{foreach $news as $volist}-->
  	<li>
	<h3><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:100:'...'}--></a></h3>
	<div>
	<!--{$volist.abstract}-->
	</div>
	<span>发布时间：<!--{$volist.timeline|date_format:"%Y-%m-%d"}-->&nbsp;&nbsp;&nbsp;点击次数：<!--{$volist.hits}--></span>
	</li>
	<hr/>
  <!--{/foreach}-->
  <div class="clearboth"></div>
</ul>