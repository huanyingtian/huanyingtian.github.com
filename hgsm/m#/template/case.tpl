<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="products">
    <div class="products_title"><!--{$title}--></div>
    <ul>
        <!--{foreach $sort_list as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->" class="img">
                   <img src="<!--{$volist.thumbfiles}-->" alt="<!--{$volist.title}-->" />
                   <h3><!--{$volist.title|truncate:20}--></h3>
                </a>
            </li>
        <!--{/foreach}-->
    </ul>
</div>
<!--{/block}-->