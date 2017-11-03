<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_cate">
    <div class="product_cate_title">新闻分类</div>
    <ul>
       <!--{foreach $news_sort as $volist}-->
          <li><a href="<!--{$volist.word}-->"><!--{$volist.cname}--></a></li>
        <!--{/foreach}-->
    </ul>
</div>
<!--{/block}-->