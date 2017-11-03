<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="menuTitle"}-->招聘分类<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/job_sort.tpl"}-->
<!--{/block}-->


<!--{block name="siteTitle"}-->
	<!--{$job.title}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/job_detail.tpl"}-->
<!--{/block}-->