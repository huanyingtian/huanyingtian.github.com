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
  <div class="path"><p>当前位置：营销中心<span>&gt;</span>询盘管理</p></div>
  <div class="main-cont">
    <h3 class="title">询盘管理</h3>
	<form action="xycms_guestbook.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="60"><div class="th-gap">选择</div></th>
		<th width="8%"><div class="th-gap">留言人</div></th>
		<th width="10%"><div class="th-gap">联系方式</div></th>
		<th width="10%"><div class="th-gap">邮箱</div></th>
		<th width="12%"><div class="th-gap">地址</div></th>
		<th width="16%"><div class="th-gap">内容</div></th>
		<th width="11%"><div class="th-gap">留言时间</div></th>
		<th width="8%"><div class="th-gap">IP</div></th>
		<th width="8%"><div class="th-gap">已读/未读</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $book as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.name}--></td>
        <td align="center"><!--{$volist.contact}--></td>
        <td align="center"><!--{$volist.email}--></td>
        <td align="center"><!--{$volist.address}--></td>
		<td align="left"><!--{$volist.content}--></td>
		<td align="center" style="color:#999;font-size:12px;"><!--{$volist.timeline|date_format:"%Y/%m/%d %H:%M:%S"}--></td>
		<td align="center"><!--{$volist.ip}--></td>
		<td align="center"><!--{if $volist.isread == 1}--><a href="javascript:void(0)" onclick="messageRead(<!--{$volist.id}-->);" class="read already" id="r<!--{$volist.id}-->">设为未读</a><!--{else}--><a href="javascript:void(0)" onclick="messageRead(<!--{$volist.id}-->);" class="read" id="r<!--{$volist.id}-->">设为已读</a><!--{/if}--></td>
		<td align="center"><a href="xycms_guestbook.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
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

<script type="text/javascript">
	function messageRead(id){
	  var dom = $("#r"+id);
	  var num = 2;
	  if(dom.hasClass("already")){
		  num = 1;
	  }
	  $.ajax({
		  type: "GET",
		  url: "xycms_guestbook.php",
		  dataType: "text",
		  data: {"action":'isread',"read":num,"id":id},
		  success: function(data) {		  
			if(data == 2 || data == 3){
				alert("id参数错误，操作失败！");
			}else if(data == 1){
				if(num == 1){
					str = '设为已读';
					dom.removeClass("already");
				}else if(num == 2){
					str = '设为未读';
					dom.addClass("already");
				}
				dom.text(str);
			}
			
		  }
		  
	  });		
		
	}
</script>
</body>
</html>

