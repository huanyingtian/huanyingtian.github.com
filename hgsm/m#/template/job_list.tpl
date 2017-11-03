<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_cate">
    <div class="product_cate_title">招聘分类</div>
    <ul>
        <!--{foreach $job_cate as $volist}-->
            <li><a href="<!--{$volist.url}-->"><!--{$volist.cname}--></a></li>
        <!--{/foreach}-->
    </ul>
 </div>
<!--{/block}-->