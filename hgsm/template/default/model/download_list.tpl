<ul class="download_list clearfix">
  <!--{foreach $download as $volist}-->
  	<li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title}--></a><span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span></li>
  <!--{/foreach}-->
</ul>