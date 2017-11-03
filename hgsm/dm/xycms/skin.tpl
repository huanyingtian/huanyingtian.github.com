<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>风格</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：模版风格<span>&gt;&gt;</span>风格设置</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_skin.php?action=add" class="btn-general"><span>添加风格</span></a>风格设置</h3>
	<form action="xycms_skin.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="10%"><div class="th-gap">编号</div></th>
		<th width="15%"><div class="th-gap">预览图</div></th>
		<th width="12%"><div class="th-gap">风格名称</div></th>
		<th width="13%"><div class="th-gap">模板目录</div></th>
		<th width="10%"><div class="th-gap">模板后缀名</div></th>
		<th width="15%"><div class="th-gap">使用状态</div></th>
		<th width="12%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $skin as $volist}-->
	  <tr onMouseOver="overColor(this)" onMouseOut="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.skinid}-->" onClick="checkItem(this, 'chkAll')" /><!--{$volist.skinid}--></td>
		<td align="center">
        <!--{if $skin_img != ''}-->
		<img src="<!--{$skin_img}-->" width="80" height="80" />
		<!--{else}-->
		<font color="#999999">无预览图</font>
		<!--{/if}-->
		</td>
		<td align="left"><!--{$volist.skinname}--></td>
		<td align="center">tpl/<!--{$volist.skindir}-->/</td>
		<td align="center">.<!--{$volist.skinext}--></td>
		<td align="center">
		<!--{if $volist.flag==1}-->
		<font color="green">当前风格</font>
		<!--{else}-->
		<a href="xycms_skin.php?action=update&id=<!--{$volist.skinid}-->">设为当前风格</a>
		<!--{/if}-->
        </td>
		<td><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_skin.php?action=edit&id=<!--{$volist.skinid}-->&page=<!--{$page}-->" class="icon-set">设置</a>
	   <!-- &nbsp;&nbsp;<a href="xycms_skin.php?action=del&id[]=<!--{$volist.skinid}-->" onClick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a> -->
        </td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
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
  <div class="path"><p>当前位置：模版风格<span>&gt;&gt;</span>添加风格</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_skin.php" class="btn-general"><span>返回列表</span></a>添加风格</h3>
    <form name="myform" id="myform" method="post" action="xycms_skin.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table cellpadding='3' cellspacing='3' class='tab'>
	  <tr>
		<td class='hback_1' width="15%">风格名称 <span class='f_red'>*</span></td>
		<td class='hback' width="85%"><input type="text" name="skinname" id="skinname" class="input-txt" /> <span id="dskinname" class='f_red'></span></td>
	  </tr>
	  <tr>
		<td class='hback_1'>模版目录 <span class="f_red">*</span> </td>
		<td class='hback'>tpl/<input type="text" name="skindir" id="skindir" class="input-txt" />  <span id='dskindir' class='f_red'></span> (模版文件必须上传到tpl目录下，否则无法使用。)</td>
	  </tr>
	  <tr>
		<td class='hback_1'>文件后缀名 <span class="f_red">*</span> </td>
		<td class='hback'><input type="text" name="skinext" id="skinext" class="input-txt" />  <span id='dskinext' class='f_red'></span> (如：tpl,html,htm)</td>
	  </tr>
	  <tr>
		<td class='hback_1'>风格设置 </td>
		<td class='hback'><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td class='hback_1'>备注说明</td>
		<td class='hback'><textarea name="remark" id="remark" style='width:60%;height:60px;display:;overflow:auto;'></textarea>  <span id='dremark' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td class='hback_none'></td>
		<td class='hback_none'><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：模版风格<span>&gt;&gt;</span>编辑风格</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_skin.php?<!--{$comeurl}-->" class="btn-general"><span>返回列表</span></a>编辑风格</h3>
    <form name="myform" id="myform" method="post" action="xycms_skin.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table cellpadding='3' cellspacing='3' class='tab'>
	  <tr>
		<td class='hback_1' width="15%">风格名称 <span class='f_red'>*</span></td>
		<td class='hback' width="85%"><input type="text" name="skinname" id="skinname" class="input-txt" value="<!--{$skin.skinname}-->" /> <span id="dskinname" class='f_red'></span></td>
	  </tr>
	  <tr>
		<td class='hback_1'>模版目录 <span class="f_red">*</span> </td>
		<td class='hback'>tpl/<input type="text" name="skindir" id="skindir" class="input-txt" value="<!--{$skin.skindir}-->" />  <span id='dskindir' class='f_red'></span> (模版文件必须上传到tpl目录下，否则无法使用。)</td>
	  </tr>
	  <tr>
		<td class='hback_1'>文件后缀名 <span class="f_red">*</span> </td>
		<td class='hback'><input type="text" name="skinext" id="skinext" class="input-txt" value="<!--{$skin.skinext}-->" />  <span id='dskinext' class='f_red'></span> (如：tpl,html,htm)</td>
	  </tr>
	  <tr>
		<td class='hback_1'>风格设置 </td>
		<td class='hback'><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td class='hback_1'>备注说明</td>
		<td class='hback'><textarea name="remark" id="remark" style='width:60%;height:60px;display:;overflow:auto;'><!--{$skin.remark}--></textarea>  <span id='dremark' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td class='hback_none'></td>
		<td class='hback_none'><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
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

	t = "skinname";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("风格名称不能为空！", t);
		return false;
	}
	t = "skindir";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("模板目录不能为空", t);
		return false;
	}
	t = "skinext";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("文件后缀名不能为空", t);
		return false;
	}
	return true;
}
</script>

</body>
</html>
