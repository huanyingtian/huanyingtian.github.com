<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>广告标签</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>广告类别</p></div>
  <div class="main-cont">
    <h3 class="title">广告类别
    <a href="xycms_ads.php?action=add" class="btn-general">添加图片</a>
    <a href="xycms_adszone.php?action=add" class="btn-general">添加分类</a>
    <a href="xycms_ads.php" class="btn-general">广告图片</a>
    </h3>
	<form action="xycms_adszone.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">类别</div></th>
		<th width="15%"><div class="th-gap">调用标签</div></th>
		<th width="13%"><div class="th-gap">广告位大小</div></th>
		<th width="6%"><div class="th-gap">图片</div></th>
		<th width="6%"><div class="th-gap">状态</div></th>
		<th width="6%"><div class="th-gap">排序</div></th>
		<th width="10%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $adszone as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.zoneid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td><!--{$volist.zonename}--></td>
		<td align="center">&lt!--{$ads_zone<!--{$volist.zoneid}-->}--></td>
		<td align="center"><!--{$volist.width}-->x<!--{$volist.height}-->(像素)</td>
		<td align="center"><!--{$volist.adscount}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.zoneid}-->" value="flagopen" />
			<img id="flag<!--{$volist.zoneid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.zoneid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.zoneid}-->" value="flagclose" />
			<img id="flag<!--{$volist.zoneid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.zoneid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
		</td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_adszone.php?action=edit&id=<!--{$volist.zoneid}-->&page=<!--
{$page}-->" class="icon-set">设置</a>&nbsp;&nbsp;<a href="xycms_adszone.php?action=del&id[]=<!--{$volist.zoneid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="9" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="8"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录</td>
	  </tr>
	  <!--{/if}-->
	</table>
	</form>
	<!--{if $pagecount>1}-->
	<table width='95%' border='0' cellspacing='0' cellpadding='0' align='center' style="margin-top:10px;">
	  <tr>
		<td align='center'><!--{$showpage}--></td>
	  </tr>
	</table>
	<!--{/if}-->
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>添加广告分类</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_adszone.php" class="btn-general">返回类别列表</a>添加广告分类</h3>
    <form name="myform" id="myform" method="post" action="xycms_adszone.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<td width="80">分类名称：<span class='f_red'>*</span></td>
		<td><input type="text" name="zonename" id="zonename" class="input-txt" /> <span class='f_red' id="dzonename"></span></td>
	  </tr>
	  <tr>
		<td>分类排序：<span class='f_red'></span></td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<td>参数设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>广告位宽：<span class='f_red'>*</span></td>
		<td><input type="text" name="width" id="width" class="input-s" /> 像素(px) <span class='f_red' id="dwidth"></span></td>
	  </tr>
	  <tr>
		<td>广告位高：<span class='f_red'>*</span></td>
		<td><input type="text" name="height" id="height" class="input-s" /> 像素(px) <span class='f_red' id="dheight"></span></td>
	  </tr>
	  <tr>
		<td>其他说明： </td>
		<td><textarea name="intro" id='intro' style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea></td>
	  </tr>
	  <tr>
		<td></td>
		<td><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>编辑广告类别</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_adszone.php?<!--{$comeurl}-->" class="btn-general">返回类别</a>编辑广告类别</h3>
    <form name="myform" id="myform" method="post" action="xycms_adszone.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width="80">类别名称：<span class='f_red'>*</span></td>
		<td><input type="text" name="zonename" id="zonename" class="input-txt" value="<!--{$adszone.zonename}-->" /> <span class='f_red' id="dzonename"></span></td>
	  </tr>
	  <tr>
		<td>类别排序：<span class='f_red'></span></td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$adszone.orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<td>参数设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>广告宽度：<span class='f_red'>*</span></td>
		<td><input type="text" name="width" id="width" class="input-s" value="<!--{$adszone.width}-->" /> 像素(px) <span class='f_red' id="dwidth"></span></td>
	  </tr>
	  <tr>
		<td>广告高度：<span class='f_red'>*</span></td>
		<td><input type="text" name="height" id="height" class="input-s" value="<!--{$adszone.height}-->" /> 像素(px) <span class='f_red' id="dheight"></span></td>
	  </tr>
	  <tr>
		<td>其他说明： </td>
		<td><textarea name="intro" id="intro" style="width:60%;height:65px;overflow:auto;color:#444444;"><!--{$adszone.intro}--></textarea></td>
	  </tr>
	  <tr>
		<td></td>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->
<script type="text/javascript">
function checkform() {
	var t = "";
	var v = "";

	t = "zonename";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("标签描述不能为空！", t);
		return false;
	}

	t = "width";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("图片宽不能为空！", t);
		return false;
	}

	t = "height";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("图片高不能为空", t);
		return false;
	}

	return true;
}
</script>
</body>
</html>

