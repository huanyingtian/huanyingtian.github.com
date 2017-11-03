<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="products">
    <div class="products_title">搜索结果:产品<!--{$p_count}-->个、新闻<!--{$n_count}-->条</div>
    <ul>
    <!--{foreach $productlist as $volist}-->
        <li>
            <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
               <img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" />
               <h3><!--{$volist.title|truncate:20}--></h3>
            </a>
        </li>
    <!--{/foreach}-->
    </ul>
 </div>

<ul class="newslist">
    <!--{foreach $infolist as $volist}-->
    <li>
       <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:26}--></a>  
       <span><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></span>
    </li>
    <!--{/foreach}-->
</ul>
<!--{/block}-->
