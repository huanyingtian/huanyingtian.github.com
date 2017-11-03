<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title><!--{$page_title}--></title>
<!--{if $page_keyword == 2}--><!--{else}-->
<meta name="keywords" content="<!--{$page_keyword}-->" />
<meta name="description" content="<!--{$page_description}-->" />
<!--{/if}-->
<!--{if $config.pcico eq ''}--><!--{else}-->
<link rel="shortcut icon" type="image/x-icon" href="<!--{$url_index}--><!--{$config.pcico}-->" />
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/base.css" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/model.css" />
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/main.css" />
<link rel="stylesheet" type="text/css" href="<!--{$url_index}-->data/user.css?9.2" />
<script src="<!--{$skinpath}-->js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=NxgaDGbhm7aceI4MOQ3dGRlj"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/MarkerTool/1.2/src/MarkerTool_min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<script src="<!--{$skinpath}-->js/mobile.js"></script>
<script>
var url = '<!--{$url_index}-->';
var cid = '<!--{$about_cid}-->';
var pathname = location.pathname;
var urlArray = pathname.split("/");
var name = '';
if((url.match(urlArray[1]))){
	for(i=2;i<urlArray.length;i++){
		name= name+"/"+urlArray[i];
	}
	name = url+"m"+name;
}else{
	name = url+"m"+pathname;
}
if(cid == 1)
{
	name = name.replace("/about/","/about_about/");
}
uaredirect(name);
</script>
<!--{block name="insert_style"}--><!--{/block}-->
</head>
<body>
<!-- 公共头部包含 -->
<!--{include file="$tplpath/model/head.tpl"}-->
<!-- 内页banner -->
<div class="n_bannerbj">
<div class="n_banner"><img src="<!--{$ads_zone2[0].uploadfiles}-->" alt="<!--{$ads_zone2[0].adsname}-->" title="<!--{$ads_zone2[0].adsname}-->" /></div>
</div>
<!-- 主体部分 -->

<div class="fe">
<div id="container" class="clearfix">
	<div class="right" style="width:100%;">
	  <div class="sitemp clearfix">
	    <h2>门店查询</h2>
	    <div class="site">您的当前位置：
	    	<a href="<!--{$url_index}-->">首 页</a><!--{$LANVAR.arrow}-->门店查询
	    </div>
	  </div>
	  <div class="contentt">
	  	<form action="<!--{$url_index}-->map.php" method="get" id="search_form" onsubmit="return checkform();">
	  		<input type="hidden" name="action" value="edital">
	  		<span class="province">省/直辖市：</span>
			<select id="manu" onchange="getModel(this.value);" name="manu">
			    <option value="">----请选择----</option>
			    <!--{foreach $seachpro as $volist}-->
			    <option value="<!--{$volist.cname}-->" <!--{if $cname == $volist.cname}-->selected<!--{/if}-->><!--{$volist.cname}--></option>
			    <!--{/foreach}-->
			</select>
			<span class="province">城市：</span>
			<select id="model" name="model">
				<option value="">----请选择----</option>
				<!--{if $cname neq ''}-->
					<!--{foreach $select as $volist}-->
					<option value="<!--{$volist.id}-->" <!--{if $id == $volist.id}-->selected<!--{/if}--> ><!--{$volist.name}--></option>
					<!--{/foreach}-->
				<!--{/if}-->
			</select>
	  		<input type="submit" class="button_s" value="搜索" />
	  	</form>
	  	<!--{if $action eq ""}-->
	       <!--{include file="$tplpath/model/map_form.tpl"}--> 
	    <!--{/if}-->
	    <!--{if $action == "edital"}-->
	       <!--{include file="$tplpath/model/edital_form.tpl"}--> 
	    <!--{/if}-->
	  </div>
	</div>
</div>
</div>
<!--{include file="$tplpath/model/foot.tpl"}-->
<!--底部JS加载区域-->
<script type="text/javascript" src="<!--{$skinpath}-->js/common.js"></script>
<script type="text/javascript" src="<!--{$skinpath}-->js/message.js"></script>

<script>
function checkform(){
	var cname = $("#manu").val();
	if(cname == ''){
		alert("请选择省/直辖市！");
		return false;
	}
}
function getModel(str)
{
	if(str=='')
	{
		alert("请选择省/直辖市！");
		return false;
	}
	$.ajax({
		type:"GET",
		url:"./map.php",
		dataType: "json",
		data: {"manus":str},
        success: function(json) {
				  var model=$("#model");
				  $("option",model).remove();
				  model.append('<option value="">----请选择----</option>');
				  $.each(json,function(index,array){ 
				  var option = "<option value='"+array['mo_id']+"'>"+array['mo_name']+"</option>"; 
				  model.append(option); 
				  }); 

		  }
	});
}
$(".erw ").hover(function(){
    $(this).find('.weim').stop().show(500);
  },function(){
    $(this).find('.weim').stop().hide(500);
  });

</script>
</body>
</html>
