<!--{extends file="$tplpath/template.tpl"}-->

<!--{block name="Insidebanner"}-->
    <!--{if $cate_banner != ''}-->
        <div class="n_banner"><img src="<!--{$cate_banner}-->" alt="<!--{$cate.cname}-->" /></div>
    <!--{else}-->
        <div class="n_banner"><img src="<!--{$ads_zone2[0].uploadfiles}-->" alt="<!--{$ads_zone2[0].adsname}-->" title="<!--{$ads_zone2[0].adsname}-->" /></div>
    <!--{/if}-->
<!--{/block}-->

<!--{block name="menuTitle"}-->产品分类<!--{/block}-->

<!--{block name="menu"}-->
	<!--{include file="$tplpath/model/product_sort.tpl"}-->
<!--{/block}-->

<!--{block name="product_sort"}-->
<!--{/block}-->

<!--{block name="siteTitle"}-->
	<!--{$navcatname}-->
<!--{/block}-->

<!--{block name="site"}-->
	 <a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}--><!--{$navigation}-->
<!--{/block}-->

<!--{block name="content"}-->
    <div class="prodescription"><!--{$prodescription}--></div>
      <!--{if $custom_depth==1}-->
            <!--{include file="$tplpath/model/product_sorta.tpl"}-->
      <!--{else if $custom_depth==2}-->
            <!--{include file="$tplpath/model/product_sortb.tpl"}-->
      <!--{else}-->
           <!--{include file="$tplpath/model/product_list.tpl"}-->
            <!--{if $showpage!=""}-->
            <div class="pageController clearfix"><!--{$showpage}--></div> 
            <!--{/if}-->
      <!--{/if}-->
<!--{/block}-->