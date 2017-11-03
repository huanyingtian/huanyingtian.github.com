<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_cate">
    <div class="product_cate_title">
      <!--{$par_title}-->
    </div>
    <ul>
       <!--{foreach $pagechild as $volist}-->
          <li><a href="<!--{$volist.url}-->"><!--{$volist.title}--></a></li>
        <!--{/foreach}-->
    </ul>
 </div>
<!--{/block}-->
