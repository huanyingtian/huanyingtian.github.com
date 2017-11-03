<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="menuTitle"}-->公司概况<!--{/block}-->

<!--{block name="siteTitle"}-->
	在线留言
<!--{/block}-->

<!--{block name="product_sort"}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}-->在线留言
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/message_form.tpl"}-->
<!--{/block}-->
