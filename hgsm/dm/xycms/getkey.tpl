<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>关键词库</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<!--{if $action eq "show"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>自动关键词库</p></div>
  <div class="main-cont">
    <h3 class="title">自动关键词库(<!--{$total}-->)</h3>
	<ul class="keylist">
		<!--{foreach $keyarry as $volist}-->
		<li><!--{$volist}--></li>
		<!--{/foreach}-->
	</ul>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "configure"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>关键词库配置</p></div>
  <div class="main-cont">
    <h3 class="title">关键词库配置</h3>
	<form name="myform" id="myform" method="post" action="xycms_getkey.php" >
		<input type="hidden" name="action" value="saveconfig" />
		<table class='table_form'>
		  <tr>
			<th width="100">广泛匹配查询 <span class='f_red'></span></th>
			<td colspan="2">
				<label><input type="radio" name="w_automatic" id="w_automatic" value="1" <!--{if $w_automatic==1}-->checked="checked"<!--{/if}--> />&nbsp;&nbsp;开启</label><div class="w_automatic">&nbsp;&nbsp;&nbsp;&nbsp;( 区域匹配、后缀词、主词、分类词、产品词、扩展词库、配置关键词)</div>
			</td>
		  </tr>
		  <tr>
			<th>精确匹配查询 <span class='f_red'></span></th>
			<td colspan="2">
				<label><input type="radio" name="w_automatic" id="w_automatic2" value="2" <!--{if $w_automatic==2}-->checked="checked"<!--{/if}--> />&nbsp;&nbsp;开启</label><div class="w_automatic">&nbsp;&nbsp;&nbsp;&nbsp;( 主词、分类词、产品词、扩展词库、配置关键词)</div>
			</td>
		  </tr>
		  <tr>
			<th></th>
			<td colspan="2"><input type="submit" name="btn_save" id="btn_save" class="button" value="更新保存" /></td>
		  </tr>
		</table>	
	</form>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "lists"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>手动关键词库</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_getkey.php?action=add" class="btn-general">添加关键词</a>手动关键词库 [ 热推产品 ] </h3>
	<form action="xycms_getkey.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="50"><div class="th-gap">选择</div></th>
		<th><div class="th-gap">关键词</div></th>
		<th width="20%"><div class="th-gap">图标</div></th>
		<th width="200"><div class="th-gap">录入时间</div></th>
		<th width="200"><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $lists as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="id" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td ><a href="<!--{$volist.url}-->" target="_blank"><!--{$volist.wname}--></a></td>
		<td align="center"><!--{if $volist.thumbfiles!=''}--><img class="p_cate_img" src="../<!--{$volist.thumbfiles}-->" border="0" /><!--{else}--><font color="#999999">无图标</font><!--{/if}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></td>
	    <td align="center"><a href="xycms_getkey.php?action=edit&id=<!--{$volist.id}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_getkey.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="5" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="4">
        <input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录
        </td>
      </tr>
	  <!--{/if}-->
	</table>
	</form>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>添加关键词</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_getkey.php?action=lists" class="btn-general">返回列表</a><span class="pro_hover">手动关键词基本信息</span><span>手动关键词配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_getkey.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="90">关键词名称：<span class='f_red'>*</span></th>
		<td colspan="2"><input type="text" name="wname" id="catename" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">自定义目录：<span class='f_red'>*</span></th>
		<td colspan="2">
		<input type="text" name="word" id="word" class="input-txt word_url" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>样式图片：<span class="f_red"></span> </th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles" />
		  <img class='upload_img' /><a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=product'></iframe>
        </td>
        <td style=""></td>
	  </tr>
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td colspan="2"><label><input type="checkbox" name="flag" id="flag" value="1" checked="checked" />&nbsp;&nbsp;状态</label></td>
	  </tr>
	  <tr>
		<th>相关关键词：</th>
		<td colspan="2"><input type="text" name="tag" id="tag" class="input-txt" /> <span id="smart_keywordsnews">自动选择</span> <span id='dtag' class='f_red'></span> (多个请用英文,号隔开)</td>
	  </tr>
	  <tr>
		<th>详细介绍：</th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">Title：<span class='f_red'></span></th>
		<td><input type="text" name="wtitle" id="wtitle" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="wkeywords" id="wkeywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="wdescription" id="wdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
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
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>修改关键词</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_getkey.php?action=lists" class="btn-general">返回列表</a><span class="pro_hover">手动关键词基本信息</span><span>手动关键词配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_getkey.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
    <input type="hidden" name="id" value="<!--{$id}-->" />
		<table class='table_form'>
	  <tr>
		<th width="90">关键词名称：<span class='f_red'>*</span></th>
		<td colspan="2"><input type="text" name="wname" id="catename" class="input-txt" value="<!--{$keywords.wname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">自定义目录：<span class='f_red'>*</span></th>
		<td colspan="2">
		<input type="text" name="word" id="word" class="input-txt word_url" value="<!--{$keywords.word}-->" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>样式图片：<span class="f_red"></span></th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" value="<!--{$keywords.uploadfiles}-->" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles"  value="<!--{$keywords.thumbfiles}-->" />
		  <!--{if $keywords.thumbfiles != ''}-->
		  	 <img class='upload_img' src="../<!--{$keywords.thumbfiles}-->" />
		  	 <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		 <!--{else}-->
		     <img class='upload_img' /> 
		     <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=product'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$keywords.thumbfiles}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
		<td style=""></td>
	  </tr> 
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td colspan="2"><label><input type="checkbox" name="flag" id="flag" value="1" <!--{if $keywords.flag == 1}-->checked="checked"<!--{/if}--> />&nbsp;&nbsp;状态</label></td>
	  </tr>
	  <tr>
		<th>相关关键词：</th>
		<td colspan="2"><input type="text" name="tag" id="tag" class="input-txt" value="<!--{$keywords.tag}-->" /> <span id="smart_keywordsnews">自动选择</span> <span id='dtag' class='f_red'></span> (多个请用英文,号隔开)</td>
	  </tr>
	  <tr>
		<th>详细介绍：</th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"><!--{$keywords.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">Title：<span class='f_red'></span></th>
		<td><input type="text" name="wtitle" id="wtitle" class="input-txt" value="<!--{$keywords.wtitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="wkeywords" id="wkeywords" class="input-txt" value="<!--{$keywords.wkeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="wdescription" id="wdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$keywords.wdescription}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
		<td><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->
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
<script type="text/javascript">
function checkform(){
	if($("#wname").val() == ''){
		alert('关键词名称不能为空！');
		return false;
	}
}
</script>

</body>
</html>