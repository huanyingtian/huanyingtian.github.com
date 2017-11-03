<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>门店地图</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" />
<link type="text/css" rel="stylesheet" href="xycms/css/map.css" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=NxgaDGbhm7aceI4MOQ3dGRlj"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/MarkerTool/1.2/src/MarkerTool_min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="js/jquery.cookie.js"></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：门店中心<span>&gt;</span>门店概况</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_map.php?action=add" class="btn-general">添加门店</a>门店概况</h3>
    <form action="xycms_map.php" method="post" name="myform" id="myform" style="margin:0">
    <input type="hidden" name="action" id="action" value="del" />
    <div class="tab">
  	<ul class="tab_li">
  		<!--{foreach $page_category as $volist}-->
  			<li><!--{$volist.cname}--></li>
  		<!--{/foreach}-->
  	</ul>
  	<div class="tab_content">
  		<!--{foreach $data as $cate}-->
  		  <div class="contentlist">
  			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
  				<thead class="tb-tit-bg">
				  <tr>
					<th width="9%">所属分类</th>
					<th width="9%">门店名称</th>
					<th width="10%">自定义目录</th>
					<th width="10%">排序</th>
					<th width="8%">状态</th>
					<th width="25%">地图中心点</th>
					<th width="15%">时间</th>
					<th>操作</th>
				  </tr>
			  </thead>
  	<!--{foreach $cate as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><!--{$volist.cname}--></td>
		<td align="center"><!--{$volist.name}--></td>
		<td align="center"><!--{$volist.word}--></td>	
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagopen" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagclose" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{$volist.center_text}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
		<td align="center"><a href="xycms_map.php?action=add&id=<!--{$volist.id}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_map.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">暂无信息</td>
	  </tr>
  				<!--{/foreach}-->
  			</table>
  	</div>
  		<!--{/foreach}-->
  	</div>
  	
  	
  	
	</div>

	</form>
	</div>
  </div>
<script>
;(function($){	
	var tab = parseInt($.cookie('tab'));
	if(! tab){
		$('.tab_li > li').first().addClass('on');
		$('.tab_content > .contentlist').first().addClass('on');
	}else{
		if($('.tab_content > .contentlist').length < tab + 1){
			$.cookie('tab', 0);
			tab = 0;
		}
		$('.tab_li > li').eq(tab).addClass('on').siblings('li').removeClass('on');
		$('.tab_content > .contentlist').eq(tab).addClass('on').siblings('.contentlist').removeClass('on');
	}
})($);
</script>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：门店中心<span>&gt;</span>门店概况</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_map.php" class="btn-general">返回列表</a></h3>
 
<div id="container">
	<div class="left">
	<form action="xycms_map.php" method="post" id="map-form" class="ajax-form"  onsubmit='return checkformnew();'>
		<input type="hidden" name="action" value="saveadd" />
		<input type="hidden" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" />
		<table class='table_form' style="margin-bottom:18px;">
		  <tr>
			<th width="60">门店分类 <span class='f_red'>*</span></th>
			<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
		  </tr>
		</table>
		<!--{if isset($id)}--><input type='hidden' name='id' value='<!--{$id}-->' /><!--{/if}-->
		 <input type="hidden" id="mapCenterPointX" name="center[x]" <!--{if isset($center.x)}-->value="<!--{$center.x}-->"<!--{/if}--> />
		 <input type="hidden" id="mapCenterPointY" name="center[y]" <!--{if isset($center.y)}-->value="<!--{$center.y}-->"<!--{/if}--> />
		 <input type="hidden" id="mapCenterLevel" name="center[zoom]" <!--{if isset($center.zoom)}-->value="<!--{$center.zoom}-->"<!--{/if}--> />
		  <div class="map-info">
				<h3>地图信息</h3>
				<ul class="map-content blank">
					<li>					
						<span>城市名称：</span>
						<span><input type="text" class="input input-large" name="name" <!--{if isset($map.name)}-->value="<!--{$map.name}-->"<!--{/if}--> /></span>
					</li>
					<li>					
						<span>定义目录：</span>
						<span><input type="text" class="input input-large" name="word" <!--{if isset($map.word)}-->value="<!--{$map.word}-->"<!--{/if}--> /></span>
					</li>					
				</ul>		
			</div>
			<div class="map-info my-mark">
				<h3>我的标注</h3>
				<div class="map-content map-mark blank">
					<ul class="mark-list">
						<!--{if !empty($mark) && is_array($mark)}-->
							<li>
								<div class='mark-nav'>
								<span class='mark-title'><!--{$mark.mark_title}--></span>
								<div class='mark-manager'><span class='mark-delete'>删除</span></div>
								</div>
								<div class='mark-info'>
								<div class='mark-item'>
										坐标：<span><input type='text' class='input input-large mark-coord' name='mark[mark-coord]' value='<!--{$mark['mark-coord']}-->' readonly='true'></span>
								</div>
								<div class='mark-item mark-item-list'>
								<span>名称：<input type='text' class='input input-large mark-title' name='mark[mark_title]' value='<!--{$mark.mark_title}-->'></span>
								<span>备注：<textarea row="2" cols="20" class='input input-large mark-remark' name='mark[mark_remark]' ><!--{$mark.mark_remark}--></textarea>
								</span>
								</div>
								</div>
							</li>
						<!--{/if}-->
					</ul>
				</div>
			</div>
			<div class="form-actions-map mark-btn">
				<input type="submit" class="btn btn-submit mark-submit" name="dosubmit" data-clear="1" value="提交">
			</div>
		</form>
	</div>
	<div class="right">
		<div class="top clear">
			<div class="mark-style">
				<a href="javascript:;" class="select-style"><i></i></a>
			</div>
			<div class="map-search">
				<span><input type="text" class="input input-large" id="searchMap" autocomplete="off" placeholder="输入地名、大厦快速定位"></span>
				<span><input type="button" class="btn map-btn" value="查找"></span>			
			</div>
		</div>
		<div class="map" id="map"></div>
	</div>	
</div>


  </div>
  <div style="clear:both;"></div>
</div>
<!--{if $id eq ''}-->
<script type="text/javascript"> 
var center = null;
var allMarker = null;
</script>
<!--{else}-->
<script type="text/javascript"> 
var center = <!--{$centerjosn}-->;
var allMarker = <!--{$allmarker}-->;
</script>
<!--{/if}-->



<script src="js/map.js"></script>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>公司概况</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_page.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑概况</h3>
    <form name="myform" id="myform" method="post" action="xycms_page.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="110">概况分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>概况名称 <span class="f_red">*</span> </th>
		<td><input type="text" name="title" id="title" class="input-txt" value="<!--{$volpage.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>自定义分类目录：<span class='f_red'>*</span></th>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" value="<!--{$volpage.word}-->" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>打开方式 <span class="f_red"></span> </th>
		<td><input type="radio" name="target" class="target" value="1" />本页，<input type="radio" name="target" class="target" value="2" />新页面</td>
	  </tr>
	  <tr>
		<th>链接类型 <span class="f_red"></span> </th>
		<td><input type="radio" name="linktype" class="linktype" value="1" />站内，<input type="radio" name="linktype" class="linktype" value="2" />站外</td>
	  </tr>
	  <tr>
		<th>站外URL <span class="f_red"></span> </th>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" value="<!--{$volpage.linkurl}-->" /> <span id='dlinkurl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>页面排序 <span class="f_red"></span> </th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$volpage.orders}-->" /> <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>页面内容 <span class="f_red"></span></th>
		<td>
		  <script id="container" name="content" type="text/javascript"><!--{$volpage.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<script type="text/javascript">
//链接内型和打开方式		
$(function(){
if(<!--{$volpage.linktype}--> == 1){
  $(".linktype:eq(0)").attr("checked",true);
  }else{
  $(".linktype:eq(1)").attr("checked",true);
   }
if(<!--{$volpage.target}--> == 1){
	  $(".target:eq(0)").attr("checked",true);
}else{
	  $(".target:eq(1)").attr("checked",true);
}     
 });
</script> 
<!--{/if}--> 

<script type="text/javascript" src="js/check.js"></script>
</body>
</html>