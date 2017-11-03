<ul class="blog_list clearfix">
  <!--{foreach $blog as $volist}-->  
  	<li>
  	<h2><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title}--></a></h2>
  	<div class="summary"><!--{$volist.summary}--></div>
    <div class="under">	
  		<span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span>
  		<span>点击：<!--{$volist.hits}--></span> 
  		<span>相关标签：<!--{$volist.tag}--></span>
  	</div>
  	</li>
  <!--{/foreach}-->
</ul>