<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="menuTitle"}-->下载分类<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/download_sort.tpl"}-->
<!--{/block}-->

<!--{block name="siteTitle"}-->
	<!--{$download.title}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/download_detail.tpl"}-->
<!--{/block}-->