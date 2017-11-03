<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>人才招聘</title>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>招聘信息</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_job.php?action=add" class="btn-general">发布招聘</a>招聘信息</h3>
	<div class="search-area ">
	  <form method="post" id="search_form" action="xycms_job.php" >
	  <div class="item">
	    <label>招聘分类：</label><!--{$cate_search}-->&nbsp;&nbsp;
		<label>职位名：</label><input type="text" id="sname" name="sname" size="15" class="input input-text" value="<!--{$sname}-->" />&nbsp;&nbsp;&nbsp;
		<input type="submit" class="button_s" value="搜 索" />
	  </div>
	  </form>
	</div>
	<form action="xycms_job.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">所在分类</div></th>
		<th width="20%"><div class="th-gap">招聘职位</div></th>
		<th width="10%"><div class="th-gap">工作地点</div></th>
		<th width="10%"><div class="th-gap">招聘人数</div></th>
		<th width="10%"><div class="th-gap">状态</div></th>
		<th width="12%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $job as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.cname}--></td>
		<td align="left"><a href="../job/<!--{$volist.id}-->.html" target="_blank"><!--{$volist.title}--></a></td>
		<td align="center"><!--{$volist.workarea}--></td>
		<td align="center"><!--{$volist.number}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagopen" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagclose" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_job.php?action=edit&id=<!--{$volist.id}-->&page=<!--{$page}-->&<!--{$urlitem}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_job.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>发布招聘</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_job.php" class="btn-general">返回列表</a><span class="pro_hover">招聘基本信息</span><span>招聘配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_job.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="70">招聘分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>招聘职位 <span class="f_red">*</span></th>
		<td><input type="text" name="title" id="title" class="input-txt" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>招聘人数 <span class="f_red"></span></th>
		<td><input type="text" name="number" id="number" class="input-s" /> （填写数字） 人 <span id='dnumber' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>工作地点 <span class="f_red"></span></th>
		<td><input type="text" name="workarea" id="workarea" class="input-s" /> <span id='dworkarea' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>图片 <span class="f_red"></span> </th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles" />
		  <img class='upload_img' /><a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=job'></iframe>
        </td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>岗位职责 <span class="f_red">*</span></th>
		<td>
		<script id="container1" name="jobdescription" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container1');</script>
	  </tr>
	  <tr>
		<th>职位要求 <span class="f_red">*</span></th>
		<td>
		<script id="container2" name="jobrequest" type="text/javascript"></script>
		  <script type="text/javascript">var ue1 = UE.getEditor('container2');</script>
	  </tr>
	  <tr>
		<th>其他要求 <span class="f_red"></span></th>
		<td>
		<script id="container3" name="jobotherrequest" type="text/javascript"></script>
		  <script type="text/javascript">var ue2 = UE.getEditor('container3');</script>
		  
	  </tr>
	  <tr>
		<th>联系方式 </th>
		<td><input type="text" name="jobcontact" id="jobcontact" class="input-txt" />  <span id='djobcontact' class='f_red'></span></td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="70">Title：<span class='f_red'></span></th>
		<td><input type="text" name="jtitle" id="jtitles" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="70">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="jkeywords" id="jkeywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="jdescription" id="jdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="70"></th>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>编辑招聘信息</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_job.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">招聘基本信息</span><span>招聘配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_job.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="70">招聘分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>招聘职位 <span class="f_red">*</span></th>
		<td><input type="text" name="title" id="title" class="input-txt" value="<!--{$job.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>招聘人数 <span class="f_red"></span></th>
		<td><input type="text" name="number" id="number" class="input-s" value="<!--{$job.number}-->" /> （填写数字） 人 <span id='dnumber' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>工作地点 <span class="f_red"></span></th>
		<td><input type="text" name="workarea" id="workarea" class="input-s" value="<!--{$job.workarea}-->" /> <span id='dworkarea' class='f_red'></span></td>
	  </tr>
	  
	  <tr>
		<th>图片 <span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" value="<!--{$job.uploadfiles}-->" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles"  value="<!--{$job.thumbfiles}-->" />
		  <!--{if $job.thumbfiles != ''}-->
		  	 <img class='upload_img' src="../<!--{$job.thumbfiles}-->" />
		  	 <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		 <!--{else}-->
		     <img class='upload_img' /> 
		     <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=job'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$job.thumbfiles}-->";
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
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>岗位职责 <span class="f_red">*</span></th>
		<td>
			<script id="jobdescription" name="jobdescription" type="text/javascript"><!--{$job.jobdescription}--></script>
			<script type="text/javascript">var ue = UE.getEditor('jobdescription');</script>
			<span id='djobdescription' class='f_red'></span>
		</td>
	  </tr>
	  <tr>
		<th>职位要求 <span class="f_red">*</span></th>
		<td>
			<script id="jobrequest" name="jobrequest" type="text/javascript"><!--{$job.jobrequest}--></script>
			<script type="text/javascript">var ue1 = UE.getEditor('jobrequest');</script>
			<span id='djobrequest' class='f_red'></span>
	  </tr>
	  <tr>
		<th>其他要求 <span class="f_red"></span></th>
		<td>
			<script id="jobotherrequest" name="jobotherrequest" type="text/javascript"><!--{$job.jobotherrequest}--></script>
			<script type="text/javascript">var ue2 = UE.getEditor('jobotherrequest');</script>
			<span id='djobotherrequest' class='f_red'></span>
	  </tr>
	  <tr>
		<th>联系方式 </th>
		<td><input type="text" name="jobcontact" id="jobcontact" class="input-txt" value="<!--{$job.jobcontact}-->" />  <span id='djobcontact' class='f_red'></span></td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="70">Title：<span class='f_red'></span></th>
		<td><input type="text" name="jtitle" id="jtitles" class="input-txt" value="<!--{$job.jtitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="70">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="jkeywords" id="jkeywords" class="input-txt" value="<!--{$job.jkeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="jdescription" id="jdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$job.jdescription}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="70"></th>
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
	ue.sync();
	ue1.sync();
	ue2.sync();
	var t = "";
	var v = "";

	t = "cateid";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("请选择招聘分类", t);
		return false;
	}
	t = "title";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("招聘职位不能为空", t);
		return false;
	}

	t = 'jobdescription';
	v = KE.html(t).length;
	if(v=="") {
		dmsg("岗位职责不能为空", t);
		return false;
	}

	t = 'jobrequest';
	v = KE.html(t).length;
	if(v=="") {
		dmsg("职位要求不能为空", t);
		return false;
	}
	return true;
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