<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_cate">
    <div class="product_cate_title">分类导航</div>
    <ul>
       <!--{foreach $pagecate as $volist}-->
          <li><a href="<!--{$volist.url}-->"><!--{$volist.cname}--></a></li>
        <!--{/foreach}-->
    </ul>
 </div>
<!--{/block}-->
