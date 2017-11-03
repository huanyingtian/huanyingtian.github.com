<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>招聘简历</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link href="xycms/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/component.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type='text/javascript' src='js/jump.js'></script>
<script type='text/javascript' src='js/vue.js'></script>
<script type='text/javascript' src='js/move.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css" />
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="js/jquery.cookie.js"></script>
</head>
<body>

<!--{if $action eq ""}-->
<div class="main-wrap">
  <h3 class="comman-title">招聘简历</h3>
  <div class="main-cont">
	<form action="xycms_resume.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="10%"><div class="th-gap">应聘职位</div></th>
		<th width="10%"><div class="th-gap">姓名</div></th>
		<th width="5%"><div class="th-gap">性别</div></th>
		<th width="15%"><div class="th-gap">联系方式</div></th>
		<th width="10%"><div class="th-gap">学历</div></th>
		<th width="15%"><div class="th-gap">工作经历</div></th>
		<th width="10%"><div class="th-gap">简历下载</div></th>
		<th width="9%"><div class="th-gap">提交时间</div></th>
		<th style="text-align:left;">操作</th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $resume as $key => $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><span class="text-blue"><!--{$volist.title}--></span></td>
		<td align="center"><span class="text-warning"><!--{$volist.cname}--></span></td>
		<td align="center"><span class="text-blue"><!--{$volist.sex}--></span></td>
		<td align="center"><span class="text-success"><!--{$volist.tel}--></span></td>
		<td align="center"><span class="text-blue"><!--{$volist.education}--></span></td>
		<td>
			<span class="text-blue"><!--{$volist.experience|truncate:12:'...'}--></span>
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary btn-lg resume-button" data-toggle="modal" data-target="#myModal<!--{$key}-->">详情>></button>
			<!-- Modal -->
			<div class="modal fade" id="myModal<!--{$key}-->" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        	<h4 class="modal-title">工作经历</h4>
			      	</div>
			      	<div class="modal-body"><!--{$volist.experience}--></div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      	</div>
			    </div>
			  </div>
			</div>
		</td>
		<td align="center"><!--{if empty($volist.uploadfile)}--><span style="color:#999;">暂无简历</span><!--{else}--><a href="<!--{$volist.downjob}-->">下载简历</a><!--{/if}--></td>
		<td align="center"><span class="text-success"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></span></td>
		<td align="left"><a href="xycms_resume.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del"><span class="changeyellow">删除</span></a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="10" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="9"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录</td>
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
</body>
</html>