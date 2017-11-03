<ul class="sort">
   <!--{foreach $about_sort as $volist}-->
      <li class="about_a">
      	<a href="<!--{$volist.url}-->"<!--{if $volist.target != 1}-->target='<!--{$volist.target}-->'<!--{/if}-->><!--{$volist.title}--></a>
      	<!--{if empty($volist.chil_cate)}--><!--{else}-->
      	<div class="about_b" style="display:none;">
      		<ul>
      		<!--{foreach $volist.chil_cate as $cate}-->
      		  <li>
      		  	<a href="<!--{$cate.url}-->"<!--{if $cate.target != 1}-->target='<!--{$cate.target}-->'<!--{/if}-->><!--{$cate.title}--></a>
      		  </li>
      		<!--{/foreach}-->
      	    </ul>
      	</div>
      	<!--{/if}-->
      </li>
    <!--{/foreach}-->
</ul>
<script type="text/javascript">
$(".about_a").hover
(
	function()
	{   
		if($(this).find(".about_b li").length > 0)
		{
			$(this).find(".about_b").stop().show();

		}
		$(this).addClass("change");
	},
	function()
	{
		$(this).find(".about_b").stop().hide();
		$(this).removeClass("change");
	}
);
</script>