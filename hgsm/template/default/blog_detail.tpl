<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="insert_style"}-->
<style type="text/css">
#container .left{float:right;}
#container .right{float:left;}
</style>
<!--{/block}-->

<!--{block name="menuTitle"}-->网站栏目<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/about_sort.tpl"}-->
<!--{/block}-->

<!--{block name="siteTitle"}-->
	<!--{$blog.title}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/blog_detail.tpl"}-->
    <!--{include file="$tplpath/model/relate.tpl"}-->
<!--{/block}-->