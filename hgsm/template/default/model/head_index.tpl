<div id="header">
  <div class="top clearfix w">
  	<div class="logo">  
  		<a href="<!--{$url_index}-->" class="logo"><img alt="<!--{$keyword1}-->" src="<!--{$urlpath}--><!--{$config.logoimg}-->" /></a>
    </div>
  	<div class="topLink">
  	  <div class="k1">
    	  <a href="<!--{$url_index}-->region/" >企业分站</a> | 
    	  <a href="<!--{$url_sitemap}-->"><!--{$lang_sitemap}--></a> | 
    	  <a href="<!--{$url_index}-->rss.xml">RSS</a> |
    	  <a href="<!--{$url_index}-->sitemap.xml">XML</a> |
    	  <a href="<!--{$url_index}-->dm/" class="feedback" target="_blank" rel="nofollow"><!--{if $count > 0}-->您有<span class="f_count"><!--{$count}--></span>条询盘信息！<!--{else}-->您暂无新询盘信息！<!--{/if}--></a>
      </div>
      <div class="k2">
  	     <!--{$delimit_top_contact}-->
      </div>

      <!-- 导航栏包含 -->
      <!--{include file="$tplpath/model/nav.tpl"}-->
      <!--{if $config.translate eq 1}-->
      <ul class="translate">
        <li>
          <a>语言版本</a>
          <div class="translate-en">
            <!--{foreach $tran_arr as $volist}-->
            <a href="<!--{$volist.url}-->" data-en="<!--{$volist.en}-->" target="_blank" rel="nofollow"><!--{$volist.cn}--></a>
            <!--{/foreach}-->
          </div>
        </li>
      </ul>
      <!--{/if}-->
  	</div>
  </div>
  <div class="search clearfix">
    <form method="get" name="formsearch" id="formsearch" action="<!--{$url_search}-->">
    	<input type='text' name='wd' id="keyword" value="请输入搜索关键词" />
 		  <input type="submit" id="s_btn" value="搜索" />
    </form>
    <h1 class="hotSearch">热门搜索：<!--{$h1}--></h1>
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