<div class="banner3">
	<script>
	   var pic = new Array(); 
	   var url = new Array();
	   var num = 0;
	   <!--{foreach from=$ads_zone1  key=k item=volist}-->
			pic[<!--{$k+1}-->] = '<!--{$volist.uploadfiles}-->';
			url[<!--{$k+1}-->] = '<!--{$volist.url}-->';	
       <!--{/foreach}-->
	   bcastr(pic,url,'<!--{$skinpath}-->','<!--{$volist.width}-->','<!--{$volist.height}-->');
	</script>
</div>
