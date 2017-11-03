<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>权限组</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>管理组设置</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_authgroup.php?action=add" class="btn-general">添加管理组</a>管理组</h3>
	<form action="xycms_authgroup.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="10%"><div class="th-gap">编号</div></th>
		<th width="15%"><div class="th-gap">组名</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="18%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">备注说明</div></th>
		<th width="15%"><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $authgroup as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.groupid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td><!--{$volist.groupname}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.groupid}-->" value="flagopen" />
			<img id="flag<!--{$volist.groupid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.groupid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.groupid}-->" value="flagclose" />
			<img id="flag<!--{$volist.groupid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.groupid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
		</td>
		<td align="center"><!--{$volist.orders}--></td>
		<td><!--{$volist.timeline|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
		<td align="left"><!--{$volist.intro}--></td>
		<td align="center"><a href="xycms_authgroup.php?action=edit&id=<!--{$volist.groupid}-->&page=<!--
{$page}-->" class="icon-set">设置</a>&nbsp;&nbsp;<a href="xycms_authgroup.php?action=del&id[]=<!--{$volist.groupid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="7" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="6"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录</td>
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
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>添加管理组</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_authgroup.php" class="btn-general">返回列表</a>添加管理组</h3>
    <form name="myform" id="myform" method="post" action="xycms_authgroup.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<td width="70">组名：<span class='f_red'>*</span></td>
		<td><input type="text" name="groupname" id="groupname" class="input-txt" /> <span class='f_red' id="dgroupname"></span></td>
	  </tr>
	  <tr>
		<td>排序：<span class='f_red'></span></td>
		<td><input type="text" name="orders" id="orders" class="input-txt" value="<!--{$orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<td>设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>备注说明： </td>
		<td><textarea name="intro" id='intro' style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea></td>
	  </tr>
	  <tr>
		<td>操作权限：<span class='f_red'></span></td>
		<td><!--{$auth_checkbox}--></td>
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
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>编辑管理组</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_authgroup.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑管理组</h3>
    <form name="myform" id="myform" method="post" action="xycms_authgroup.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width="70">组名：<span class='f_red'>*</span></td>
		<td><input type="text" name="groupname" id="groupname" class="input-txt" value="<!--{$authgroup.groupname}-->" /> <span class='f_red' id="dgroupname"></span></td>
	  </tr>
	  <tr>
		<td>排序：<span class='f_red'></span></td>
		<td><input type="text" name="orders" id="orders" class="input-txt" value="<!--{$authgroup.orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<td>设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>备注说明： </td>
		<td><textarea name="intro" id='intro' style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$authgroup.intro}--></textarea></td>
	  </tr>
	  <tr>
		<td>操作权限：<span class='f_red'></span></td>
		<td><!--{$auth_checkbox}--></td>
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

	t = "groupname";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("管理组名不能为空！", t);
		return false;
	}
	return true;
}
</script>
</body>
</html>
