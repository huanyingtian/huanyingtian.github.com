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
	<!--{$news.title}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
	<!--{include file="$tplpath/model/news_detail.tpl"}-->
	 <div class="relateproduct relate"><h4>最近浏览：<!--{$browse}--></h4>
	    <div class="content">
	     <ul id="relate_n" class="news_list clearfix">
		  <!--{foreach $newprow as $volist}-->
			<li><a href="<!--{$volist.url}-->" title="<!--{$volist.title}-->"><!--{$volist.title}--></a></li>
		  <!--{/foreach}-->
	     </ul>
	    </div>
	  </div>  
    <!--{include file="$tplpath/model/relate.tpl"}-->
<!--{/block}-->