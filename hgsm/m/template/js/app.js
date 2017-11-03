//;(function($){  
//    $('#wrapper').css('height', window.innerHeight - 42);  		
//	var myScroll = new iScroll('wrapper', { 
//		ideScrollbar:true,
//	});	
//})(Zepto);

/*全站搜索*/
var input = $("#keyword");
input.focus(function(){
	if($(this).val() == '请输入搜索关键词'){
		$(this).val('');
	}
});
input.blur(function(){
	if($(this).val() == ''){
		$(this).val('请输入搜索关键词');
	}
});
$("#s_btn").click(function(){
	if(input.val() == '' || input.val() == '请输入搜索关键词'){
		alert("请输入关键词！");
		input.focus();
		return false;
	}
});


