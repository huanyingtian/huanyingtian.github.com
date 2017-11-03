<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="menuTitle"}-->公司概况<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/about_sort.tpl"}-->
<!--{/block}-->

<!--{block name="siteTitle"}-->
	标签：<!--{$navname}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}-->标签搜索
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/tag_list.tpl"}-->
<!--{/block}-->