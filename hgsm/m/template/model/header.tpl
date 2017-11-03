<header id="header" class="clearfix">
<div class="logo">
	<!--{if $webimg != ''}-->
	 <a href="<!--{$url_index}-->"><img src="<!--{$path_index}--><!--{$webimg}-->"></a>
	<!--{else}-->
      <!--{$sitename}-->
    <!--{/if}-->
    </div>
    <div class="memu">
    <div class="haoma">
    <!--{$delimit_m_haoma}-->
    </div>
<div class="navbg"></div>
    </div>
</header>

<script>
  var url_index = '<!--{$url_index}-->';
  var url_rel = window.location.href;

  $('.header_right').click(function(){
	     window.location.href='<!--{$url_index}-->';
  })
</script>


