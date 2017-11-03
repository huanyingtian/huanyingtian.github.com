<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>管理员</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>管理员设置</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_admin.php?action=add" class="btn-general">添加帐号</a>管理员</h3>
	<form action="xycms_admin.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="10%"><div class="th-gap">帐号</div></th>
		<th width="15%"><div class="th-gap">权限组</div></th>
		<th width="10%"><div class="th-gap">状态</div></th>
		<th width="18%"><div class="th-gap">登录时间</div></th>
		<th width="15%"><div class="th-gap">登录IP</div></th>
		<th width="10%"><div class="th-gap">登录次数</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $admin as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.adminid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td><!--{$volist.adminname}--></td>
		<td align="center"><!--{if $volist.super==1}--><font color="green">系统管理员</font><!--{else}--><!--{if $volist.groupid==0}--><font color="#999999">~~</font><!--{else}--><!--{$volist.groupname}--><!--{/if}--><!--{/if}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.adminid}-->" value="flagopen" />
			<img id="flag<!--{$volist.adminid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.adminid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.adminid}-->" value="flagclose" />
			<img id="flag<!--{$volist.adminid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.adminid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
		</td>
		<td><!--{$volist.logintimeline|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
		<td><!--{$volist.loginip}--></td>
		<td align="center"><!--{$volist.logintimes}--></td>
		<td align="center"><a href="xycms_admin.php?action=edit&id=<!--{$volist.adminid}-->&page=<!--
{$page}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<a href="xycms_admin.php?action=del&id[]=<!--{$volist.adminid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">暂无信息</td>
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
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>添加管理员</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_admin.php" class="btn-general">返回列表</a>添加管理员</h3>
    <form name="myform" id="myform" method="post" action="xycms_admin.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<td width="70">登录帐号：<span class='f_red'>*</span></td>
		<td><input type="text" name="adminname" id="adminname" class="input-txt" /> <span class='f_red' id="dadminname"></span> 4-16个字符，只能由中文、字母、数字和下横线组成</td>
	  </tr>
	  <tr>
		<td>登录密码：<span class='f_red'>*</span></td>
		<td><input type="password" name="password" id="password" class="input-txt" /> <span class='f_red' id="dpassword"></span> 4-16个字符</td>
	  </tr>
	  <tr>
		<td>帐号设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}-->，<!--{$super_checkbox}--></td>
	  </tr>
	  <tr>
		<td>帐号权限：<span class='f_red'></span></td>
		<td><!--{$groupid_select}--> <span class='f_red' id="dgroupid"></span><br /><span class="f_gray">非系统管理员的权限组，系统管理员拥有所有操作权限。</span></td>
	  </tr>
	  <tr>
		<td>备注说明： </td>
		<td><textarea name='memo' id='memo' style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea></td>
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
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>编辑帐号</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_admin.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑帐号</h3>
    <form name="myform" id="myform" method="post" action="xycms_admin.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width='70'>登录帐号 </td>
		<td><!--{$admin.adminname}--></td>
	  </tr>
	  <tr>
		<td>登录密码 </td>
		<td><input type="password" name="password" id="password" class="input-txt" /> <span id="dpassword" class="f_red"></span> (不修改请留空)</td>
	  </tr>
	  <tr>
		<td>帐号设置 <span class='f_red'></span></td>
		<td><!--{$flag_checkbox}-->，<!--{$super_checkbox}--></td>
	  </tr>
	  <tr>
		<td>帐号权限 <span class='f_red'></span></td>
		<td><!--{$groupid_select}--> <span class='f_red' id="dgroupid"></span><br /><span class="f_gray">非系统管理员的权限组，系统管理员拥有所有操作权限。</span></td>
	  </tr>
	  <tr>
		<td>备注说明 </td>
		<td><textarea name="memo" id="memo" style="width:60%;height:65px;overflow:auto;color:#444444;"><!--{$admin.memo}--></textarea></td>
	  </tr>
	  <tr>
		<td>登录次数 </td>
		<td><!--{$admin.logintimes}--></td>
	  </tr>
	  <tr>
		<td>登录时间 </td>
		<td><!--{$admin.logintimeline|date_format:"%Y-%m-%d %H:%M:%S"}--></td>
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

<!--{if $action eq "changepassword"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>修改密码</p></div>
  <div class="main-cont">
	<h3 class="title">修改密码</h3>
    <form name="myform" id="myform" method="post" action="xycms_admin.php" onsubmit='return checkpassword();'>
    <input type="hidden" name="action" value="savepassword" />
	<table class='table_form'>
	  <tr>
		<td width='70'>登录帐号： </td>
		<td><!--{$uc_adminname}--></td>
	  </tr>
	  <tr>
		<td>旧 密 码： </td>
		<td><input type='password' name='oldpassword' id='oldpassword' maxlength="16" class="input-txt" /> <span id='doldpassword' class='f_red'></span> </td>
	  </tr>
	  <tr>
		<td>新 密 码： </td>
		<td><input type='password' name='newpassword' id='newpassword' maxlength="16" class="input-txt" /> <span id='dnewpassword' class='f_red'></span> 4-16个字符</td>
	  </tr>
	  <tr>
		<td>确认密码： </td>
		<td><input type='password' name='confirmpassword' id='confirmpassword' maxlength="16" class="input-txt" /> <span id='dconfirmpassword' class='f_red'></span> </td>
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

	t = "adminname";
	v = $("#"+t).val().length;
	if(v<4 || v>16) {
		dmsg("登录帐号必须为4-16个字符！", t);
		return false;
	}

	t = "password";
	v = $("#"+t).val().length;
	if(v<4 || v>16) {
		dmsg("登录密码必须为4-16个字符", t);
		return false;
	}
	return true;
}

function checkpassword() {
	var t = "";
	var v = "";

	t = "oldpassword";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("原密码不能为空", t);
		return false;
	}

	t = "newpassword";
	v = $("#"+t).val().length;
	if(v<4 || v>16) {
		dmsg("新密码必须为4-16个字符！", t);
		return false;
	}
    
	t = "confirmpassword";
	if($("#confirmpassword").val()!=$("#newpassword").val()) {
		dmsg("确认密码不正确！", t);
		return false;
	}
	return true;
}
</script>
</body>
</html>

