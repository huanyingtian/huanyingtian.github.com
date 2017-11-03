<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="Insidebanner"}-->
    <!--{if $cate_banner != ''}-->
        <div class="n_banner"><img src="<!--{$cate_banner}-->" alt="<!--{$cate.cname}-->" /></div>
    <!--{else}-->
        <div class="n_banner"><img src="<!--{$ads_zone2[0].uploadfiles}-->" alt="<!--{$ads_zone2[0].adsname}-->" title="<!--{$ads_zone2[0].adsname}-->" /></div>
    <!--{/if}-->
<!--{/block}-->

<!--{block name="menuTitle"}-->新闻分类<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/news_sort.tpl"}-->
<!--{/block}-->

<!--{block name="siteTitle"}-->
	<!--{$navcatname}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$lang_arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/news_list.tpl"}-->
	<!--{if $showpage!=""}-->
		<div class="pageController"><!--{$showpage}--></div> 
	<!--{/if}-->
<!--{/block}-->