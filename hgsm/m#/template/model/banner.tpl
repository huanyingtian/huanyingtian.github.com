<div class="scroll">
   <div class="slide_01" id="slide_01">
      <!--{foreach $ads_zone4 as $volist}-->
	     <li class="mod_01"><a href="<!--{$volist.url}-->"><img src="<!--{$volist.uploadfiles}-->"></a></li>
      <!--{/foreach}-->
    </div>
	<div class="dotModule_new">
		<div id="slide_01_dot"></div>
	</div>
</div>
<script type="text/javascript">

    	// var m_width=$(window).width();
    	var m_width=$(document.body).width();
	    $('.scroll').css('width',m_width);
	    $('.mod_01').css('width',m_width);
	    $('.mod_01 img').css('width',m_width);
    	if(document.getElementById("slide_01")){
			var slide_01 = new ScrollPic();
			slide_01.scrollContId   = "slide_01"; //内容容器ID
			slide_01.dotListId      = "slide_01_dot";//点列表ID
			slide_01.dotOnClassName = "selected";
			slide_01.arrLeftId      = "sl_left"; //左箭头ID
			slide_01.arrRightId     = "sl_right";//右箭头ID
			slide_01.frameWidth     = m_width;
			slide_01.pageWidth      = m_width;
			slide_01.upright        = false;
			slide_01.speed          = 5;
			slide_01.space          = 30;
			slide_01.initialize(); //初始化
	    }
	    $(window).resize(function(){
	    	m_width=$(document.body).width();
		    $('.scroll').css('width',m_width);
		    $('.mod_01').css('width',m_width);
		    $('.mod_01 img').css('width',m_width);
		    slide_01.frameWidth     = m_width;
			slide_01.pageWidth      = m_width;
	    });



</script>

<script type="text/javascript">
var evt = "onorientationchange" in window ? "orientationchange" : "resize";

window.addEventListener(evt, function() {
     window.location.reload();
}, false);
</script>
