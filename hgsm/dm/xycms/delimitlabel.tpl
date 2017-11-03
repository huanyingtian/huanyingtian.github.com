<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>内容中心</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>说明页</p></div>
  <div class="main-cont">
    <h3 class="title"><!--{if $uc_adminname == 'master'}--><a href="xycms_delimitlabel.php?action=add" class="btn-general">添加说明页</a><!--{/if}-->说明页</h3>
	<form action="xycms_delimitlabel.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="10%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">所属风格</div></th>
		<th width="20%"><div class="th-gap">标签名</div></th>
		<th width="15%"><div class="th-gap">标签描述</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="18%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $delimitlabel as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.labelid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.skinname}--></td>
		<td align="left">&lt;!--{$delimit_<!--{$volist.labelname}-->}--&gt;</td>
		<td align="left"><!--{$volist.labeltitle}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.labelid}-->" value="flagopen" />
			<img id="flag<!--{$volist.labelid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.labelid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.labelid}-->" value="flagclose" />
			<img id="flag<!--{$volist.labelid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.labelid}-->');" style="cursor:pointer;" />
		<!--{/if}-->
        </td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
		<td align="center"><a href="xycms_delimitlabel.php?action=edit&id=<!--{$volist.labelid}-->&page=<!--{$page}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<!--{if $uc_adminname == 'master'}--><a href="xycms_delimitlabel.php?action=del&id[]=<!--{$volist.labelid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a><!--{/if}--></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>添加说明页</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_delimitlabel.php" class="btn-general">返回列表</a>添加说明页</h3>
    <form name="myform" id="myform" method="post" action="xycms_delimitlabel.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="100">所属风格模板 <span class='f_red'></span></th>
		<td><!--{$skin_select}--> <span id="dskinid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>说明页名称 <span class="f_red">*</span> </th>
		<td><input type="text" name="labelname" id="labelname" class="input-txt" />  <span id='dlabelname' class='f_red'></span> (标签名只能由字母、数字和下划线组成)</td>
	  </tr>
	  <tr>
		<th>说明页描述 <span class="f_red">*</span> </th>
		<td><input type="text" name="labeltitle" id="labeltitle" class="input-txt" />  <span id='dlabeltitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>说明页内容</th>
		<td>
		<script id="container" name="labelcontent" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	  <tr>
		<th></th>
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
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>编辑标签</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_delimitlabel.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑标签</h3>
    <form name="myform" id="myform" method="post" action="xycms_delimitlabel.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="100">所属风格模板 <span class='f_red'></span></th>
		<td><!--{$skin_select}--> <span id="dskinid" class='f_red'></span></td>
	  </tr>
	  
	  <tr>
		<th>标签名称 <span class="f_red">*</span> </th>
		<td><input type="text" name="labelname" id="labelname" class="input-txt" <!--{if $uc_adminname == 'admin'}-->style="cursor:not-allowed;" readonly="readonly"<!--{/if}--> value="<!--{$delimitlabel.labelname}-->" />  <span id='dlabelname' class='f_red'></span> (标签名只能由字母、数字和下划线组成)</td>
	  </tr>
	  
	  <tr>
		<th>标签描述 <span class="f_red">*</span> </th>
		<td><input type="text" name="labeltitle" id="labeltitle" class="input-txt" value="<!--{$delimitlabel.labeltitle}-->" />  <span id='dlabeltitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>标签内容</th>
		<td>
			<script id="container" name="labelcontent" type="text/javascript"><!--{$delimitlabel.labelcontent}--></script>
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
<!--{/if}-->

<script type="text/javascript">
function checkform() {
	var t = "";
	var v = "";
    var ue = UE.getEditor('container',{
     toolbars: [["undo","redo","|","bold","italic","underline","strikethrough","|","fontsize","forecolor","backcolor","|","removeformat","|","selectall","cleardoc","source","|","unlink","link","|","insertimage"]],wordCount:false
    });
    if(ue.queryCommandState('source')==1)
    {
    	ue.execCommand('source');
    }
	t = "labelname";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("标签名称不能为空", t);
		return false;
	}
	t = "labeltitle";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("标签描述不能为空", t);
		return false;
	}
	return true;
}
</script>

</body>
</html>
