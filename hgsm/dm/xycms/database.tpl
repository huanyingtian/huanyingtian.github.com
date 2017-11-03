<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>数据库管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>数据库管理</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_database.php?action=restore" class="btn-general">数据恢复</a>数据备份</h3>
	<div class="search-area ">
	  <div class="item">
		您可以根据自己的需要选择需要备份的数据库表，导出的数据文件可用“数据恢复”功能；<br />
		为了数据安全，备份文件采用时间戳命名保存，如果备份数据超过设定的大小程序会自动采用分卷备份功能，请耐心等待直到程序提示全部备份完成；<br />
		附件的备份只需手工转移附件目录和文件即可，风格备份也相同；<br />
		<font color="green"><b>温馨提示：如果您的数据比较多，大于备份分卷的5，6倍，请将admin,authgroup和config三个表单独备份，<br />否则数据恢复分卷一时，可能会因这3张表没有数据导致系统出错！</b></font>
	  </div>
	</div>
	<form action="xycms_database.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="backup" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="12%"><div class="th-gap">选择</div></th>
		<th width="12%"><div class="th-gap">ID</div></th>
		<th width="20%"><div class="th-gap">表名称</div></th>
		<th width="10%"><div class="th-gap">表类型</div></th>
		<th width="10%"><div class="th-gap">记录总数</div></th>
		<th width="10%"><div class="th-gap">表大小</div></th>
		<th width="10%"><div class="th-gap">表状态</div></th>
		<th><div class="th-gap">表编码</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $tabledb as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="tabledb[]" type="checkbox" value="<!--{$volist.table}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.i}--></td>
		<td align="left"><!--{$volist.table}--></td>
		<td align="left"><!--{$volist.type}--></td>
		<td align="center"><!--{$volist.dbnum}--></td>
		<td align="center"><!--{$volist.dbsize}--></td>
		<td align="center"><!--{$volist.status}--></td>
		<td><!--{$volist.charset}--></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">对不起，没有匹配的数据表！</td>
	  </tr>
	  <!--{/foreach}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'tabledb[]')" value="checkbox" />全选</td>
		<td class="hback" colspan="7">共<b><!--{$dbnum}--></b>张表，数据库大小为：<!--{$dbsize}--></td>
	  </tr>
	  <tr>
	    <td align="center"><b>分卷备份-&gt;&gt;</b></td>
		<td class="hback" colspan="7">每个分卷文件大小为：<input type="text" name="sizelimit" value="<!--{$maxfilesize}-->" class="input-s" />KB (分卷最小值为200K)&nbsp;&nbsp;
		<font color="#999999">(您的分卷最大值不能超过 <!--{$maxfilesize}--> KB)</font>
		
		<br /><input class="button" name="btn_del" type="button" value="提交备份" onclick="{if(confirm('确定要提交选择的数据表吗？')){$('#action').val('backup');$('#myform').submit();return true;}return false;}" class="button" /></td>
	  </tr>
	</table>
	</form>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "backup"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>数据库管理</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_database.php?action=restore" class="btn-general">数据恢复</a>数据备份</h3>
	<div class="search-area ">
	  <div class="item">
	  <!--{$backup_info}-->
	  </div>
	</div>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->

<!--{if $action eq "restore"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>数据库管理</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_database.php" class="btn-general">数据备份</a>数据恢复</h3>
	<div class="search-area ">
	  <div class="item">
		本功能在恢复备份数据的同时，将覆盖原有数据，请确定是否需要恢复，以免造成数据损失；<br />
		数据恢复功能只能恢复由当前版本导出的数据文件，其他软件导出格式可能无法识别；<br />
		如果备份文件太大需要一些时间导入，请耐心等待直到程序提示全部导入完成；<br />
		<font color="green"><b>如果一个备份文件有多个分卷，您只需任选一个备份文件导入，程序会自动导入其他分卷。</b></font>
	  </div>
	</div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
		<th width="10%"><div class="th-gap">ID</div></th>
		<th><div class="th-gap">备份文件</div></th>
		<th width="8%"><div class="th-gap">卷号</div></th>
		<th width="18%"><div class="th-gap">备份时间</div></th>
		<th width="10%"><div class="th-gap">文件大小</div></th>
		<th width="12%"><div class="th-gap">文件类型</div></th>
		<th width="15%"><div class="th-gap">操作</div></th>

	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{assign var=i value="1"}-->
	  <!--{foreach $filedb as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
		<td align="center"><!--{$i}--></td>
		<td align="left"><a href="../data/sqlbackup/<!--{$volist.filename}-->" target="_blank"><!--{$volist.filename}--></a></td>
		<td align="center"><!--{$volist.num}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y-%m-%d %H:%M:%S"}--></td>
		<td align="center"><!--{$volist.size}--></td>
		<td align="center"><!--{$volist.type}--></td>
		<td align="center"><a href="xycms_database.php?action=import&sqlfile=<!--{$volist.pre}-->"  onclick="{if(confirm('恢复功能将覆盖原来的数据，您确认要导入选中的备份数据吗？')){return true;} return false;}" class="icon-edit">恢复</a>&nbsp;&nbsp;<a href="xycms_database.php?action=del&sqlfile=<!--{$volist.filename}-->" onClick="{if(confirm('此功能不可恢复,您确认要删除选中的备份文件！')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{$i = $i+1}-->
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="7" align="center">对不起，暂无SQL备份文件！</td>
	  </tr>
	  <!--{/foreach}-->
	</table>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "import"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;&gt;</span>数据库管理</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_database.php?action=backup" class="btn-general"><span>数据备份</span></a>数据恢复</h3>
	<div class="search-area ">
	  <div class="item">
	  <!--{$import_info}-->
	  </div>
	</div>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->

</body>
</html>