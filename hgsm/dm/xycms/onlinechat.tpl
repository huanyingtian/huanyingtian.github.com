<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>营销中心</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：营销中心<span>&gt;</span>在线客服</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_onlinechat.php?action=add" class="btn-general">添加客服</a>在线客服</h3>
	<form action="xycms_onlinechat.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="10%"><div class="th-gap">类型</div></th>
		<th width="15%"><div class="th-gap">帐号</div></th>
		<th width="12%"><div class="th-gap">显示名称</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="12%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $onlinechat as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.onid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center">
		<!--{if $volist.ontype==1}-->
		<font color="green">QQ</font>
		<!--{else if $volist.ontype==2}-->
		<font color="blue">淘宝旺旺</font>
		<!--{else if $volist.ontype==3}-->
		<font color="orange">MSN</font>
		<!--{else}-->
		<font color="green">Skype</font>
		<!--{/if}-->
		</td>
		<td align="left"><!--{$volist.number}--></td>
		<td align="center"><!--{$volist.title}--></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.onid}-->" value="flagopen" />
			<img id="flag<!--{$volist.onid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.onid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.onid}-->" value="flagclose" />
			<img id="flag<!--{$volist.onid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.onid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_onlinechat.php?action=edit&id=<!--{$volist.onid}-->&page=<!--{$page}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<a href="xycms_onlinechat.php?action=del&id[]=<!--{$volist.onid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="9" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="7"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录</td>
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
  <div class="path"><p>当前位置：营销中心<span>&gt;</span>在线客服</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_onlinechat.php" class="btn-general">返回列表</a>添加客服</h3>
    <form name="myform" id="myform" method="post" action="xycms_onlinechat.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<td width="70">客服类型 <span class='f_red'>*</span></td>
		<td><select name="ontype" id="ontype"><option value="1">QQ</option><option value="2">淘宝旺旺</option><option value="3">MSN</option><option value="4">Skype</option></select> <span id="dontype" class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>帐号/号码 <span class="f_red">*</span> </td>
		<td><input type="text" name="number" id="number" class="input-txt" /> <span id='dnumber' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>显示名称<span class="f_red"></span> </td>
		<td><input type="text" name="title" id="title" class="input-txt" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>状态设置 </td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>排序 <span class="f_red"></span> </td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" /> <span id='dorders' class='f_red'></span></td>
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
  <div class="path"><p>当前位置：营销中心<span>&gt;</span>在线客服</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_onlinechat.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑客服</h3>
    <form name="myform" id="myform" method="post" action="xycms_onlinechat.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width="70">客服类型 <span class='f_red'>*</span></td>
		<td>
		<select name="ontype" id="ontype">
		<option value="1"<!--{if $onlinechat.ontype==1}--> selected="selected"<!--{/if}-->>QQ</option><option value="2"<!--{if $onlinechat.ontype==2}--> selected="selected"<!--{/if}-->>淘宝旺旺</option><option value="3"<!--{if $onlinechat.ontype==3}--> selected="selected"<!--{/if}-->>MSN</option><option value="4"<!--{if $onlinechat.ontype==4}--> selected="selected"<!--{/if}-->>Skype</option></select> <span id="dontype" class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>帐号/号码 <span class="f_red">*</span> </td>
		<td><input type="text" name="number" id="number" class="input-txt" value="<!--{$onlinechat.number}-->" /> <span id='dnumber' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>显示名称 <span class="f_red"></span> </td>
		<td><input type="text" name="title" id="title" class="input-txt" value="<!--{$onlinechat.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>状态设置 </td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>排序 <span class="f_red"></span> </td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$onlinechat.orders}-->" /> <span id='dorders' class='f_red'></span></td>
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

	t = "ontype";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("请选择类型", t);
		return false;
	}
	t = "number";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("帐号/号码不能为空", t);
		return false;
	}

	return true;
}
</script>
</body>
</html>