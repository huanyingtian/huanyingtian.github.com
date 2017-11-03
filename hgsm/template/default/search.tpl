<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="menuTitle"}-->产品分类<!--{/block}-->

<!--{block name="menu"}-->
	 <!--{include file="$tplpath/model/product_sort.tpl"}-->
<!--{/block}-->

<!--{block name="product_sort"}-->
<!--{/block}-->
<!--{block name="siteTitle"}-->
	搜索关键词：<!--{$wd}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}-->全站搜索
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/search_list.tpl"}-->
<!--{/block}-->