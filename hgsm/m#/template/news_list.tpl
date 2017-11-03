<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="news">
    <div class="news_title"><!--{$title}--></div>
    <ul>
        <!--{foreach $news_list as $volist}-->
            <li>
                <a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"> <!--{$volist.title|truncate:25}--></a>
            </li>
        <!--{/foreach}-->
    </ul>
</div>

<script>
     $('.news ul li').last().css('border-bottom','none');
     $('.product_cate ul li').last().css('border-bottom','none');
</script>
<!--{/block}-->