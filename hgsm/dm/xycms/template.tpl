<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>模板管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：模版风格<span>&gt;</span>模板管理</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_template.php" class="btn-general">返回模板根目录</a>模板管理</h3>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="10%"><div class="th-gap">编号</div></th>
		<th width="10%"><div class="th-gap">类型</div></th>
		<th width="30%"><div class="th-gap">文件名</div></th>
		<th width="15%"><div class="th-gap">大小</div></th>
		<th width="18%"><div class="th-gap">最后修改时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $template as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><!--{$volist.i}--></td>
		<td align="center"><!--{if $volist.type==1}--><font color="green"><b>目录</b></font><!--{else}--><font color="blue"><b>文件</b></font><!--{/if}--></td>
		<td align="left"><!--{$volist.filename}--></td>
		<td align="center"><!--{$volist.size}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y-%m-%d %H:%H:%S"}--></td>
		<td align="center">
		<!--{if $volist.type==1}-->
		<a href="xycms_template.php?dir=<!--{$volist.filepath}-->" class="icon-show">打开目录</a>
		<!--{else}-->
		<a href="xycms_template.php?action=edit&file=<!--{$volist.filepath}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_template.php?action=del&file=<!--{$volist.filepath}-->" onClick="{if(confirm('确定要删除该文件吗？一旦删除无法恢复！')){return true;} return false;}" class="icon-del">删除</a>
		<!--{/if}-->
		</td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="6" align="center">对不起，该目录没有文件！</td>
	  </tr>
	  <!--{/foreach}-->
	</table>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：模版风格<span>&gt;</span>编辑模板文件</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_template.php" class="btn-general">返回模板根目录</a>编辑模板文件</h3>
    <form name="myform" id="myform" method="post" action="xycms_template.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="file" value="<!--{$urlstrs}-->" />
	<table cellpadding='3' cellspacing='3' class='tab'>
	  <tr>
		<td class='hback_1' width="10%">文件名 </td>
		<td class='hback' width="80%"><b><font color="blue">../<!--{$urlstrs}--></font></b></td>
	  </tr>
	  <tr>
		<td class='hback_1'>文件内容 <span class='f_red'>*</span></td>
		<td class='hback'><textarea name="content" id="content" style="width:98%;height:300px;display:;overflow:auto;"><!--{$content}--></textarea>  <br /><span id='dcontent' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td class='hback_none'></td>
		<td class='hback_none'><input type="submit" name="btn_save" class="button" value="编辑保存" /></td>
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

	t = "content";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("模板文件内容不能为空", t);
		return false;
	}
	return true;
}
</script>

</body>
</html>
