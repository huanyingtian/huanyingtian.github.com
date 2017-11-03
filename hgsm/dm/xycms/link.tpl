<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>友情链接</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：优化中心<span>&gt;</span>友情链接</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_link.php?action=add" class="btn-general">添加友情链接</a>友情链接</h3>
	<form action="xycms_link.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">网站名称</div></th>
		<th width="15%"><div class="th-gap">LOGO预览</div></th>
		<th width="20%"><div class="th-gap">网站URL</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="12%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $link as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.linkid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="left"><!--{$volist.linktitle}--></td>
		<td align="center"><!--{if $volist.linktype==1}-->文字链接<!--{else}--><a href="../<!--{$volist.logoimg}-->" target="_blank"><img src="../<!--{$volist.logoimg}-->" width="88" height="31" /></a><!--{/if}--></td>
		<td align="left"><a href="<!--{$volist.linkurl}-->" target="_blank"><!--{$volist.linkurl}--></a></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.linkid}-->" value="flagopen" />
			<img id="flag<!--{$volist.linkid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.linkid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.linkid}-->" value="flagclose" />
			<img id="flag<!--{$volist.linkid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.linkid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_link.php?action=edit&id=<!--{$volist.linkid}-->&page=<!--
{$page}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<a href="xycms_link.php?action=del&id[]=<!--{$volist.linkid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="7"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" /></td>
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
  <div class="path"><p>当前位置：优化中心<span>&gt;</span>添加友情链接</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_link.php" class="btn-general">返回列表</a>添加友情链接</h3>
    <form name="myform" id="myform" method="post" action="xycms_link.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<td width="80">网站名称 <span class='f_red'>*</span></td>
		<td><input type="text" name="linktitle" id="linktitle" class="input-txt" /> <span id='dlinktitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>网站URL <span class="f_red">*</span> </td>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" /> （以 http:// 开头） <span id='dlinkurl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>链接类型 <span class="f_red">*</span></td>
		<td><select name="linktype" id="linktype"><option value="1">文字链接</option><option value="2">LOGO链接</option></select> <span id='dlinktype' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>LOGO图片 <span class="f_red"></span> </td>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=link&is_thumb=2'></iframe>	
		</td>
	  </tr>
	  <tr>
		<td>网站排序 </td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" />  <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>是否导出权重 </td>
		<td><label><input type="checkbox" value="1" name="nofollow" id="nofollow" />&nbsp;&nbsp;导出</label></td>
	  </tr>
	  <tr>
		<td>状态设置 </td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>网站描述</td>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;display:;overflow:auto;'></textarea>  <span id='dintro' class='f_red'></span></td>
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

<!--{if $action eq "config"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：优化中心<span>&gt;</span>友情链接库配置</p></div>
  <div class="main-cont">
	<h3 class="title">友情链接库配置<a href="xycms_link.php?action=del_cache" id="del_cache">删除链接库缓存</a></h3>
    <form name="myform" id="myform" method="post" action="xycms_link.php">
    <input type="hidden" name="action" value="config" />
	<table class='table_form'>
	  <!--{if $uc_adminname == 'master'}-->
	  <tr>
		<td width="80">链接库API地址 </td>
		<td><input type="text" name="api_url" class="input-txt link_api" value="<!--{$api.api_url}-->" /></td>
	  </tr>
	  <tr>
		<td>Token(令牌)</td>
		<td><input type="text" name="token" class="input-txt link_api" value="<!--{$api.token}-->" /></td>
	  </tr>
	  <!--{/if}-->
	  <tr>
		<td width="80">关闭外链推送</td>
		<td>
		<input type="checkbox" name="closeLink" value="1"<!--{if $api.closeLink == 1}--> checked="checked"<!--{/if}--> />
		</td>
	  </tr>
	  <tr>
		<td></td>
		<td><input type="submit" name="dosubmit" class="button" value="保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：优化中心<span>&gt;</span>编辑友情链接</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_link.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑友情链接</h3>
    <form name="myform" id="myform" method="post" action="xycms_link.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width="80">网站名称 <span class='f_red'>*</span></td>
		<td><input type="text" name="linktitle" id="linktitle" class="input-txt" value="<!--{$link.linktitle}-->" /> <span id='dlinktitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>网站URL <span class="f_red">*</span> </td>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" value="<!--{$link.linkurl}-->" /> （以 http:// 开头） <span id='dlinkurl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>链接类型 <span class="f_red">*</span></td>
		<td><select name="linktype" id="linktype"><option value="">==请选择==</option><option value="1"<!--{if $link.linktype==1}--> selected<!--{/if}-->>文字链接</option><option value="2"<!--{if $link.linktype==2}--> selected<!--{/if}-->>LOGO链接</option></select> <span id='dlinktype' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>LOGO图片 <span class="f_red"></span> </td>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles"  value="<!--{$link.logoimg}-->" />
		  <!--{if $link.logoimg != ''}-->
		  	 <img class='upload_img' src="../<!--{$link.logoimg}-->" />
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=link&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$link.logoimg}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
		<td>网站排序 </td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$link.orders}-->" />  <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<td>是否导出权重 </td>
		<td><label><input type="checkbox" value="1" name="nofollow" id="nofollow" <!--{if $link.nofollow==1}-->checked="checked"<!--{/if}--> />&nbsp;&nbsp;导出</label></td>
	  </tr>
	  <tr>
		<td>状态设置 </td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>网站描述</td>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;display:;overflow:auto;'><!--{$link.intro}--></textarea>  <span id='dintro' class='f_red'></span></td>
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

	t = "linktitle";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("网站名称不能为空", t);
		return false;
	}
	t = "linkurl";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("网站URL不能为空", t);
		return false;
	}
	t = "linktype";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("请选择链接类型", t);
		return false;
	}
	return true;
}
</script>
</body>
</html>