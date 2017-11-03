<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>案例管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css" />
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="js/datepicker/WdatePicker.js"></script>

</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：案例管理<span>&gt;</span>案例内容</p></div>
  <div class="main-cont">
    <h3 class="title">
    	<a href="xycms_case.php?action=add" class="btn-general">发布案例</a>
    	案例内容
    	<!--{if $taskName != ''}-->
    		<span id="task_tip">当前计划任务的分类为：<!--{$taskName}--></span>
    	<!--{/if}-->
    </h3>
	<div class="search-area ">
	  <form method="post" id="search_form" action="xycms_case.php" >
	  <div class="item">
	    <label>案例分类：</label><!--{$cate_search}-->&nbsp;&nbsp;
		<label>标题：</label><input type="text" id="sname" name="sname" size="20" class="input input-txt" value="<!--{$sname}-->" />&nbsp;&nbsp;&nbsp;
		<input type="submit" class="button_s" value="搜 索" />
	  </div>
	  </form>
	</div>
	<form action="xycms_case.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="6%"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">所在分类</div></th>
		<th width="60"><div class="th-gap">排序</div></th>
		<th width="28%"><div class="th-gap">标题</div></th>
		<th width="6%"><div class="th-gap">浏览</div></th>
		<th width="6%"><div class="th-gap">状态</div></th>
		<th width="6%"><div class="th-gap">推荐</div></th>
		<th width="12%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $case as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="check" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.cname}--></td>
     	<td align="center">
        <input type="text" name="orders[]" value="<!--{$volist.orders}-->" class="orders" />
        </td>
		<td align="left"><a href="../case/<!--{$volist.id}-->.html" target="_blank" title="<!--{$volist.title}-->"><!--{$volist.title|truncate:38:'...'}--></a> <!--{if $volist.thumbfiles!=''}--><font color="blue">[图文]</font><!--{/if}--></td>
		<td align="center"><!--{$volist.hits}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagopen" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagclose" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center">
		<!--{if $volist.elite==0}-->
			<input type="hidden" id="attr_elite<!--{$volist.id}-->" value="eliteopen" />
			<img id="elite<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('elite','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_elite<!--{$volist.id}-->" value="eliteclose" />
			<img id="elite<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('elite','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_case.php?action=edit&id=<!--{$volist.id}-->&page=<!--{$page}-->
		&<!--{$urlitem}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<a href="xycms_case.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="8" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="8"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录<input class="button" id="order_case" name="order_case" type="button" value="更新排序" />
		</td>
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
  <div class="path"><p>当前位置：案例管理<span>&gt;</span>发布案例</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_case.php" class="btn-general">返回列表</a><span class="pro_hover">案例基本信息</span><span>案例配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_case.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="80">案例分类 <span class='f_red'>*</span></th>
		<td colspan="2"><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>案例标题 <span class="f_red">*</span></th>
		<td colspan="2"><input type="text" name="title" id="title" class="input-txt" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>案例图文 <span class="f_red"></span></th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=case'></iframe>			 
		</td>
		<td><!--{$size}--></td>
	  </tr>
	  <tr>
		<th>浏览次数 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="hits" id="hits" class="input-s" /> <span id='dhits' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>时间<span class="f_red"></span></th>
		<td colspan="2"><input type="text" onclick="WdatePicker()" name="timeline" id="timeline" class="input-s input1 Wdate" /></td>
	  </tr>
	  <tr>
		<th>TAGS&nbsp;&nbsp;</th>
		<td colspan="2"><input type="text" name="tag" id="tag" class="input-txt" /> <span id="smart_keywords">自动选择</span> <span id='dtag' class='f_red'></span> (多个请用英文,号隔开)</td>
	  </tr>
      <tr style="display:none;">
		<th><span id="t1">手动选择</span></th>
		<td class='hback f_tag' colspan="2">
           <!--{foreach $tags as $tag}-->
             <a href="javascript:void(0)"><!--{$tag}--></a>
           <!--{/foreach}-->
        </td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td colspan="2"><!--{$flag_checkbox}-->，<!--{$elite_checkbox}--></td>
	  </tr>
	  <tr>
		<th>案例内容 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="ctitle" id="ctitle" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="ckeywords" id="ckeywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="cdescription" id="cdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
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
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：案例管理<span>&gt;</span>编辑案例</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_case.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">案例基本信息</span><span>案例配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_case.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<input type="hidden" name="page" value="<!--{$page}-->" />
	<table class='table_form'>
	  <tr>
		<th width="80">案例分类 <span class='f_red'>*</span></th>
		<td colspan="2"><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>案例标题 <span class="f_red">*</span></th>
		<td colspan="2"><input type="text" name="title" id="title" class="input-txt" value="<!--{$case.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>案例图文 <span class="f_red"></span></th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" value="<!--{$case.uploadfiles}-->" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles"  value="<!--{$case.thumbfiles}-->" />
		  <!--{if $case.thumbfiles != ''}-->
		  	 <img class='upload_img' src="../<!--{$case.thumbfiles}-->" /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=case'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$case.thumbfiles}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
		<td><!--{$size}--></td>
	  </tr>
	  <tr>
		<th>浏览次数 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="hits" id="hits" class="input-s" value="<!--{$case.hits}-->" /> <span id='dhits' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>时间<span class="f_red"></span></th>
		<td colspan="2"><input type="text" onclick="WdatePicker()" name="timeline" id="timeline" class="input-s input1 Wdate" value="<!--{$case.timeline|date_format:'%Y-%m-%d'}-->" /></td>
	  </tr>
	  <tr>
		<th>TAGS&nbsp;&nbsp;</th>
		<td colspan="2"><input type="text" name="tag" id="tag" class="input-txt" value="<!--{$case.tag}-->" /> <span id="smart_keywords">自动选择</span> <span id='dtag' class='f_red'></span> (多个请用英文,号隔开)</td>
	  </tr>
      <tr style="display:none;">
		<th><span id="t1">手动选择</span></th>
		<td class='hback f_tag' colspan="2">
           <!--{foreach $tags as $tag}-->
             <!--{if $tag.mark eq "1"}-->
              <a href="javascript:void(0)" class="over"><!--{$tag.name}--></a>
             <!--{else}-->
              <a href="javascript:void(0)"><!--{$tag.name}--></a>
             <!--{/if}-->
           <!--{/foreach}-->
        </td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td colspan="2"><!--{$flag_checkbox}-->，<!--{$elite_checkbox}--></td>
	  </tr>
	  <tr>
		<th>案例内容 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"><!--{$case.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="ctitle" id="ctitle" class="input-txt" value="<!--{$case.ctitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="ckeywords" id="ckeywords" class="input-txt" value="<!--{$case.ckeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="cdescription" id="cdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$case.cdescription}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="80"></th>
		<td colspan="2"><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
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
<!--{/if}-->
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>
