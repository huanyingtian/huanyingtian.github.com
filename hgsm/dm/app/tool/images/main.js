// JavaScript Document
$(function(){
	//左侧导航脚本
	$(".nav_list li").click(function(){	
	 $("#iframe").remove();
	  var which = $(this).index()+1;
	  var rel   = $(this).children().attr("rel")+"_hover";
	  var move  = $(this).siblings().find("a");
	  move.removeClass("vedio_hover"); 
	  move.removeClass("tool_hover"); 
	  move.removeClass("game_hover"); 
	  $(this).find("a").addClass(rel); 
	  var list  = $(".list"+which);
	  $(".ico_img").css("display","none");
	  list.show(800);
	});
	
	//右侧链接点击
	 $(".ico_img li a").click(function(){
	   var url        = $(this).parent().attr("rel");
	   var height     = $(this).parent().attr("h");  
	   var right_html = '<iframe frameborder="0" id="iframe" width="100%" scrolling="no" allowtransparency="true" style="height:'+height+'" name="zs" src="'+url+'">'+'</iframe>';
	   $("#right").prepend(right_html);
	   $(".ico_img").css("display","none");
	   return false;
	 });
	
	
});