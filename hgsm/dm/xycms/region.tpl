<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>区域管理</title>
<link type="text/css" rel="stylesheet" href="<!--{$urlpath}-->dm/xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<!--{$urlpath}-->dm/xycms/css/region.css" />
<script type='text/javascript' src='<!--{$urlpath}-->dm/js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='<!--{$urlpath}-->dm/js/command.js'></script>
</head>
<body>
<!--{if $action == "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：区域管理</p></div>
<div class="main-cont">
	<h3 class="title">添加区域</h3>
    <form name="myform" id="myform" method="post" action="<!--{$urlpath}-->dm/region.php/add/saveadd/">
	<table cellpadding='3' cellspacing='3' class='tab'>
	  <tr>
		<td class='hback_1' width="60">区域 </td>
		<td class='hback'><input type="text" name="name" id="name" class="input-txt input1" /></td>
	  </tr>
	  <tr>
		<td class='hback_1'>英文</td>
		<td class='hback'><input type="text" name="en" id="en" class="input-txt input1" /></td>
	  </tr>
	  <tr>
		<td class='hback_none'></td>
		<td class='hback_none'><input type="submit" name="btn_save" class="button btn1" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
</div>
<!--{elseif $action == "edit" }-->
<div class="main-wrap">
  <div class="path"><p>当前位置：区域管理</p></div>
<div class="main-cont">
	<h3 class="title">编辑区域</h3>
    <form name="myform" id="myform" method="post" action="<!--{$urlpath}-->dm/region.php/edit/">
    <input type="hidden" name="id" value="<!--{$region.id}-->" />
	<table cellpadding='3' cellspacing='3' class='tab region_tab'>
	  <tr>
		<td class="region_title" width="10%">区域：</td>
		<td width="85%"><input type="text" name="name" id="name" class="input-txt input1" value="<!--{$region.name}-->" /></td>
	  </tr>
	  <tr>
		<td class="region_title">英文：</td>
		<td><input type="text" name="en" id="en" class="input-txt input1" value="<!--{$region.en}-->" /></td>
	  </tr>
	  <tr>
		<td></td>
		<td><input type="submit" name="btn_save" class="button btn1" value="保存编辑" /></td>
	  </tr>
	</table>
	</form>
  </div>
</div>
<!--{else}-->
<div class="main-wrap">
	<div class="path"><p>当前位置：区域管理</p></div>
	<div class="main-cont">
		<h3 class="title">
			主营区域：（可手动添加，数量不限）<span id="region_count">[ <label><!--{$count}--></label> ]</span>
			<a href="../region.php/add" data-title="添加区域" class="btn-general float-l">添加区域</a>
		</h3>
		<input type="hidden" name="delurl" id="delurl" value="<!--{$urlpath}-->dm/region.php/del/" />
		<ul class="region_list clear">
			<!--{foreach $region as $volist}-->
				<li>
				<a href="<!--{$urlpath}-->dm/region.php/edit/<!--{$volist.id}-->" class="item"><!--{$volist.name}--></a>
				<a href="javascript:void(0);" class="del" rel="<!--{$volist.id}-->">删除</a>
				</li>
			<!--{/foreach}-->
		</ul>
		<div class="ContextMenu">
			<a href="javascript:void(0);" rel="">删除</a>
		</div>
	</div>
	<div class="main-cont">
		<div class="region-title">
			<label>
				<input type="checkbox" onclick="checkAllS(this, 'select-all')" <!--{if $selectall == 1}-->checked="checked"<!--{/if}-->>
				<span>中国</span>
			</label>
		</div>
		<form name="myform" id="myform" method="post" action="<!--{$urlpath}-->dm/region.php/area/">
		<!--{foreach $city as $keys => $volist}-->
		<div class="region-area clearfix">
			<input type="hidden" name="<!--{$volist.en}-->[name]" value="<!--{$volist.name}-->">
			<div class="region-left">
				<label>
					<input type="checkbox" class="select-all" onclick="checkAllS(this, '<!--{$volist.en}-->')" name="<!--{$volist.en}-->[name]" <!--{if $volist.type==1}-->checked="checked"<!--{/if}--> value="<!--{$volist.name}-->">
					<span><!--{$volist.name}--></span>
				</label>
			</div>
			<div class="region-right">
				<!--{foreach $volist.city as $key => $val}-->
				<div class="region-list">
					<label>
						<input type="checkbox" class="<!--{$volist.en}--> select-all" name="<!--{$volist.en}-->[list][<!--{$val.en}-->]" <!--{if $val.type==1}-->checked="checked"<!--{/if}--> value="<!--{$val.name}-->">
						<span><!--{$val.name}--></span>
					</label>
					<div class="region-list-content">
						<ul class="clearfix">
							<!--{foreach $val.child as $k => $v}-->
							<li>
								<input type="checkbox" class="<!--{$volist.en}--> select-all" <!--{if $v.type==1}-->checked="checked"<!--{/if}--> name="<!--{$volist.en}-->[list][<!--{$v.en}-->]" value="<!--{$v.name}-->">
								<span><!--{$v.name}--></span>
							</li>
							<!--{/foreach}-->
						</ul>
					</div>
				</div>
				<!--{/foreach}-->
			</div>
		</div>
		<!--{/foreach}-->
		<input type="submit" id="area-btn" class="button btn1" value="保存" />
		</form>
	</div>
</div>
<!--{/if}-->
<script>
	$('.region-list').hover(function(){
		if ($(this).find('.region-list-content li').length > 0) {
			$(this).find('.region-list-content').stop().show();
		}
	},function(){
		$(this).find('.region-list-content').stop().hide();
	});
	$('.btn1').live('click',function(){
	  if($('#name').val() == ''){
		  alert('城市名称不可以空');
		  $('#name').focus();
		  return false;
	  }
  });
	$('.region_list >li a.del').live('click',function(){
 			var id = $(this).attr('rel');
 			var liObj = $(this).parent();
 			url = $('#delurl').val();
 			$.ajax({
 			   type: "GET",
 			   url: url,
 			   data: {'id':id},
 			   success: function(msg){
 				   if(msg == 1){
  					  alert('删除成功');
 					  liObj.remove();
 					  $('#region_count label').text(parseInt($('#region_count label').text())-1);

 				   }
 			   }
 			});
 	}); 
  </script>
</body>
</html>