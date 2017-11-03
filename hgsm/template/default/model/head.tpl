<div id="header">
  <div class="top clearfix">
  	<div class="logo">  
  		<a href="<!--{$url_index}-->" class="logo"><img alt="<!--{$keyword1}-->" src="<!--{$urlpath}--><!--{$config.logoimg}-->" /></a>
    </div>
  	<div class="topLink"> 
  	<div class="k1">
	  <a href="<!--{$url_index}-->region/" >企业分站</a> | 
	  <a href="<!--{$url_sitemap}-->"><!--{$lang_sitemap}--></a> |
	  <a href="<!--{$url_index}-->rss.xml">RSS</a> |
	  <a href="<!--{$url_index}-->sitemap.xml">XML</a>
    </div>
    <div class="k2">
	   <!--{$delimit_top_contact}-->
    </div> 
    <!--{if $config.translate eq 1}-->
    <ul class="translate tran-in">
      <li>
        <a>语言版本</a>
        <div class="translate-en">
          <!--{foreach $tran_arr as $volist}-->
          <a href="<!--{$volist.url}-->" data-en="<!--{$volist.en}-->" target="_blank"><!--{$volist.cn}--></a>
          <!--{/foreach}-->
        </div>
      </li>
    </ul>
    <!--{/if}-->
  	</div>
  </div>
  <!-- 导航栏包含 -->
  <!--{include file="$tplpath/model/nav.tpl"}-->
  <div class="search clearfix">
    <form method="get" name="formsearch" id="formsearch" action="<!--{$url_search}-->">
    	<input type='text' name='wd' id="keyword" value="<!--{if $wd != ''}--><!--{$wd}--><!--{else}-->请输入搜索关键词<!--{/if}-->" />
 		<input type="submit" id="s_btn" value="搜索" />
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
  $('.translate-en a').last().css('border','none');
  $('.translate li').hover(function(){
    $(this).find('.translate-en').stop().slideDown();
  },function(){
    $(this).find('.translate-en').stop().slideUp();
  }
  );
});
</script>