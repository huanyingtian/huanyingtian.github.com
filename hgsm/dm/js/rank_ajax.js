//Ajax排名查询
$(function(){
	
function rank_ajax(keywords,url,search_type){
	$.ajax({
		  type:"get",
		  url:"rank.php?timeStamp="+new Date().getTime(),
		  cache: false,
		  dataType:"json",
		  data:{"url":url,"keywords":keywords,"type":search_type},
		  success:function(json){
			  var target_object = null,index = 0;			  
			  switch(true) {
				case search_type == "baidu":
					 target_object = $(".rank_list:eq(0)");
					 index = 0;
					 break;
				case search_type == "360":
					 target_object = $(".rank_list:eq(1)");
				 	 index = 1;
					 break;
				case search_type == "soso":
					 target_object = $(".rank_list:eq(2)");
				     index = 2;
					 break;
				case search_type == "bing":
				 	 target_object = $(".rank_list:eq(3)");
					 index = 3;
					 break;
				default:
					break;
				}  
			  if(json && json.page != -1){			  
				switch(true) {
				case search_type == "baidu":
					 url = "http://www.baidu.com/s?wd="+encodeURI(json.keywords)+"&pn="+(parseInt(json.page)-1)*10;
					 break;
				case search_type == "360":
					 url = "http://www.so.com/s?q="+encodeURI(json.keywords)+"&pn="+parseInt(json.page);
					 break;
				case search_type == "soso":
					 url = "http://www.soso.com/q?w="+encodeURI(json.keywords)+"&pg="+parseInt(json.page);
					 break;
				case search_type == "bing":
					 url = "http://cn.bing.com/search?q="+encodeURI(json.keywords)+"&pn="+(parseInt(json.page)*10 - 9);
					 break;
				default:
					break;
				}  
			  var html = "<tr><td><span class='key'>"+json.keywords+"</span></td><td align='center'><a href='"+url+"' target='_blank'>第"+json.page+"页，第"+json.rank+"名</a></td></tr>";
			  target_object.append(html);
			 }
			 var rankAllcount 	  = parseInt($("#rankAllcount").val());
			 var rank_status 	  = target_object.find(".rank_status");
			 var rankAlreadyCount = target_object.find(".rankAlreadyCount");
			 
			 $(rank_status).text("( 正在查询...)");
			 $(rankAlreadyCount).val(parseInt(rankAlreadyCount.val()) + 1);
			 var rankProgress = Math.ceil(parseInt(rankAlreadyCount.val())*100/rankAllcount) + '%';
			 if(rankProgress){
				 target_object.find('.rankProgress').text(rankProgress);
			 }
			 if(parseInt(rankAlreadyCount.val()) == rankAllcount){
				 var has_rank = parseInt(target_object.find("tr:not(.thead)").length);
				 if(has_rank == 0){
					 $(rank_status).text("( 查询失败，请稍后再试！ )");
				 }else{
					 $(rank_status).text("( 查询完毕 )");
				 }
				 $(".rank_refresh a").eq(index).css('display',"inline");
			 }			 
		  }
	});	
}

function rank_opea(obj){
	var keywords    = $(".keyword_list").text();
	var search_type = obj.attr("rel");
	var url		    = $(".url").text();
	keywords        = keywords.split(",");
	for(var i = 0; i < keywords.length; i++){  
		key = keywords[i];
		rank_ajax(key,url,search_type);			
	}  	
	return false;
}

$('.rank_list tr:not(.thead)').live('mouseover mouseout', function(event) {
	  if (event.type == 'mouseover') {
		  $(this).addClass("rank_hover");
	  } else {
		  $(this).removeClass("rank_hover");	
	  }
});

$('.rank_btn').click(function(){
	$(this).addClass("rank_current");
	$(this).siblings().removeClass("rank_current");
	var index = $(this).index();
	left = $(this).position().left;
	$(".rank_refresh a").css('display','none');
	$(".rank_refresh a").eq(index).css('left',left);
	if($(".tab_list").eq(index).find(".rankProgress").text() == '100%'){
		$(".rank_refresh a").eq(index).css('display',"inline");
	}
	$(".rank_tab .tab_list").css('display','none');
	$(".rank_tab .tab_list:eq("+index+")").css('display','block');
	
	var has_rank 		 = $(".rank_list:eq("+index+") tr").not(".thead").length;
	var rankAlreadyCount = parseInt($(".rank_list").eq(index).find(".rankAlreadyCount").val());
	if(has_rank == 0 && rankAlreadyCount == 0){
		rank_opea($(this));
	}
});

//统计数字
$("#count label:eq(0)").text();


});