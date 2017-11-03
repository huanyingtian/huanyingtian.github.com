<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>概况分类</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>概况分类</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_pagecate.php?action=add" class="btn-general">添加分类</a>概况分类</h3>
	<form action="xycms_pagecate.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">分类名称</div></th>
		<th width="15%"><div class="th-gap">英文目录</div></th>
		<th width="10%"><div class="th-gap">单页</div></th>
		<th width="10%"><div class="th-gap">排序</div></th>
		<th width="10%"><div class="th-gap">状态</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $cate as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.cid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td><!--{$volist.cname}--></td>
		<td align="center"><!--{$volist.catdir}--></td>
		<td align="center"><!--{$volist.pagecount}--></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagopen" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagclose" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
		</td>
		<td align="center"><a href="xycms_pagecate.php?action=edit&id=<!--{$volist.cid}-->&page=<!--{$page}-->" class="icon-set">修改</a>&nbsp;&nbsp;<a href="xycms_pagecate.php?action=del&id[]=<!--{$volist.cid}-->" onClick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>添加概况分类</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_pagecate.php" class="btn-general">返回列表</a>添加概况分类</h3>
    <form name="myform" id="myform" method="post" action="xycms_pagecate.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
     <input type="hidden" name="orders" value="<!--{$orders}-->" />
	<table class='table_form'>
	  <tr>
		<th width="70">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>英文目录：<span class='f_red'></span></th>
		<td><input type="text" name="catdir" class="input-s" value="<!--{$catdir}-->" />  标签名只能由字母、数字和下划线组成</td>
	  </tr>
	  <tr>
		<th>所属状态：<span class='f_red'></span></th>
		<td>
			<input type="radio" name="state" value="1" checked="checked" /> PC&nbsp;&nbsp;&nbsp;
			<input type="radio" name="state" value="2" /> 手机
		</td>
	  </tr>
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>备注说明： </th>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>编辑概况分类</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_pagecate.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑概况分类</h3>
    <form name="myform" id="myform" method="post" action="xycms_pagecate.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="100">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" value="<!--{$cate.cname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>英文目录：<span class='f_red'></span></th>
		<td><input type="text" name="catdir" class="input-s" value="<!--{$cate.catdir}-->" /> 标签名只能由字母、数字和下划线组成</td>
	  </tr>
	  <tr>
		<th>所属状态：<span class='f_red'></span></th>
		<td>
			<input type="radio" name="state" value="1" <!--{if $cate.state==1}-->checked="checked"<!--{/if}--> /> PC&nbsp;&nbsp;&nbsp;
			<input type="radio" name="state" value="2" <!--{if $cate.state==2}-->checked="checked"<!--{/if}--> /> 手机
		</td>
	  </tr>
	  <tr>
		<th>分类排序：<span class='f_red'></span></th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$cate.orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>备注说明： </th>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$cate.intro}--></textarea></td>
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
function checkform(){
	if($("#catename").val() == ''){
		alert('分类名称不能为空！');
		return false;
	}
}
</script>
</body>
</html>
