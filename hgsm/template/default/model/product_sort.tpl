<ul class="sort">
  <!--{foreach $productTreeCate as $volist}-->
  	<li class="layer1">
      <a href="<!--{$volist.url}-->" class="list_item"><!--{$volist.cname}--></a>
      <div class="layer2" style="display:none;">
      	<ul>
        	<!--{foreach $volist.childcategory as $seclist}-->
         	  <li>
				<a href="<!--{$seclist.url}-->" class="list_item"><!--{$seclist.cname|truncate:20}--></a>
				<!--{if empty($seclist.childcategory)}--><!--{else}-->
				<div class="layer3" >
					<ul>
					<!--{foreach $seclist.childcategory as $thirdlist}-->
					<li>
						<a href="<!--{$thirdlist.url}-->" class="list_item"><!--{$thirdlist.cname|truncate:20}--></a>
					</li>
					<!--{/foreach}-->
					</ul>
				</div>
				<!--{/if}-->
			  </li>
            <!--{/foreach}-->
        </ul>
      </div>
    </li>
  <!--{/foreach}-->   
</ul>

<script type="text/javascript">
$(".layer1").hover
(
	function()
	{   
		if($(this).find(".layer2 li").length > 0)
		{
			$(this).find(".layer2").stop().show();

		}
		$(this).addClass("change");
	},
	function()
	{
		$(this).find(".layer2").stop().hide();
		$(this).removeClass("change");
	}
);
</script>