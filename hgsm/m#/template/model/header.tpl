<header id="header">
	<!--{if $webimg != ''}-->
	  <img src="<!--{$path_index}--><!--{$webimg}-->">
	<!--{else}-->
      <!--{$sitename}-->
    <!--{/if}-->
</header>

<script>
  var url_index = '<!--{$url_index}-->';
  var url_rel = window.location.href;
	  
  $('.header_right').click(function(){
	     window.location.href='<!--{$url_index}-->'; 
  })
</script>