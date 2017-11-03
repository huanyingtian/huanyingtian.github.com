<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>下载内容</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css" />
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>下载内容</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_download.php?action=add" class="btn-general">发布下载</a>下载内容</h3>
	<div class="search-area ">
	  <form method="post" id="search_form" action="xycms_download.php" >
	  <div class="item">
	    <label>下载分类：</label><!--{$cate_search}-->&nbsp;&nbsp;
		<label>下载名称：</label><input type="text" id="sname" name="sname" size="20" class="input input-text" value="<!--{$sname}-->" />&nbsp;&nbsp;&nbsp;
		<input type="submit" class="button_s" value="搜 索" />
	  </div>
	  </form>
	</div>
	<form action="xycms_download.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="10%"><div class="th-gap">所在分类</div></th>
		<th width="20%"><div class="th-gap">资源名称</div></th>
		<th width="10%"><div class="th-gap">文件大小</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="10%"><div class="th-gap">下载次数</div></th>
		<th width="18%"><div class="th-gap">发布时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $download as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.cname}--></td>
		<td align="left"><a href="../download/<!--{$volist.id}-->.html" target="_blank"><!--{$volist.title}--></a></td>
		<td align="left"><!--{$volist.filesize}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagopen" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagclose" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{$volist.downs}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_download.php?action=edit&id=<!--{$volist.id}-->&page=<!--
{$page}-->&<!--{$urlitem}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_download.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>发布下载</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_download.php" class="btn-general">返回列表</a><span class="pro_hover">下载基本信息</span><span>下载配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_download.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="80">下载分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载名称 <span class="f_red">*</span></th>
		<td><input type="text" name="title" id="title" class="input-txt" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载地址 <span class="f_red">*</span></th>
		<td>
		<input type='text' name='uploadfiles' id="uploadfilesdown" class="input-txt" />
		<a href="javascript:upload('myform','uploadfilesdown')">点击上传资源</a>
		<input type="hidden" name="realname" id="realname" />
		<span id='duploadfiles' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载次数 <span class="f_red"></span></th>
		<td><input type="text" name="downs" id="downs" class="input-s" /> <span id='ddowns' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载图文 <span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="img" id="uploadfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2'></iframe>			</td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}-->，<!--{$elite_checkbox}--></td>
	  </tr>
	  <tr>
		<th>详细介绍 <span class="f_red"></span></th>
		<td>
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="dtitle" id="dtitle" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="dkeywords" id="dkeywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="ddescription" id="ddescription" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="80"></th>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>编辑下载</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_download.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">下载基本信息</span><span>下载配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_download.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="80">下载分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载名称 <span class="f_red">*</span></th>
		<td><input type="text" name="title" id="title" class="input-txt" value="<!--{$download.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载地址 <span class="f_red">*</span></th>
		<td>
		<input type="text" name="uploadfiles" id="uploadfilesdown" class="input-txt" value="<!--{$download.uploadfiles}-->" />
		<a href="javascript:upload('myform','uploadfilesdown')">点击上传资源</a>
		<input type="hidden" name="realname" id="realname" value="<!--{$download.realname}-->" />
		<span id='duploadfiles' class='f_red'></span>
		</td>
	  </tr>
	  <tr>
		<th>下载次数 <span class="f_red"></span></th>
		<td><input type="text" name="downs" id="downs" class="input-s" value="<!--{$download.downs}-->" /> <span id='ddowns' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>下载图文 <span class="f_red"></span> </th>
		<td>
		  <input type="hidden" name="img" id="uploadfiles"  value="<!--{$download.img}-->" />
		  <!--{if $download.img != ''}-->
		  	 <img class='upload_img' src="../<!--{$download.img}-->" /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$download.img}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}-->，<!--{$elite_checkbox}--></td>
	  </tr>
	  <tr>
		<th>详细介绍 <span class="f_red"></span></th>
		<td>
		<script id="container" name="content" type="text/javascript"><!--{$download.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>  
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="dtitle" id="dtitle" class="input-txt" value="<!--{$download.dtitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="dkeywords" id="dkeywords" class="input-txt" value="<!--{$download.dkeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="ddescription" id="ddescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$download.ddescription}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="80"></th>
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
	t = "cateid";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("请选择分类", t);
		return false;
	}
	t = "title";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("下载名称不能为空", t);
		return false;
	}
	t = "uploadfilesdown";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("下载地址不能为空", t);
		return false;
	}
	return true;
}

function upload(s_formname,s_inputname){
    window.open("annexform.php?comeform="+s_formname+"&inputname="+s_inputname+"","load_annexup","status=no,scrollbars=no,top=200,left=310,width=420,height=165");
}
</script>
  <script type="text/javascript">
    $(".title span").click(function(){
    	var index = $(this).index();
    	$(this).addClass("pro_hover").siblings("span").removeClass("pro_hover");
    	if(index == 1){
    		$("#myform .table_form").eq(0).show();
    		$("#myform .table_form").eq(1).hide();
    	}else if(index == 2){
    		$("#myform .table_form").eq(1).show();
    		$("#myform .table_form").eq(0).hide();
    	}
    });
  </script>

</body>
</html>