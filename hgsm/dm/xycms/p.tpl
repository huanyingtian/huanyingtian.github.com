<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>产品分类</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js?a=<!--{$rand}-->'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>

<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：自定义页面<span>&gt;</span>页面列表</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_p.php?action=add" class="btn-general">添加页面</a>自定义页面</h3>
    <form action="xycms_p.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="delcates" />
	<input type="hidden" name="rootid" id="rootid" value="" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="8%"><div class="th-gap">ID</div></th>
		<th width="24%"><div class="th-gap">页面名称</div></th>
		<th width="20%"><div class="th-gap">所属模板</div></th>
		<th width="30%"><div class="th-gap">图片</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $cont_p as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><!--{$volist.cid}--></td>
		<td align="center"><a href="<!--{$volist.url}-->" target="_blank"><!--{$volist.cname}--></a></td>
		<td align="center"><!--{$volist.pstyle}--></td>
		<td align="center"><!--{if $volist.img!=''}--><img class="p_cate_img" src="../<!--{$volist.img}-->" border="0" /><!--{else}--><font color="#999999">无图标</font><!--{/if}--></td>
		<td align="center"><a href="xycms_p.php?action=edit&id=<!--{$volist.cid}-->" class="icon-set">修改</a>
        <!--{if $uc_adminname == 'master'}-->
		&nbsp;&nbsp;<a href="xycms_p.php?action=del&id=<!--{$volist.cid}-->" onClick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a>
        <!--{/if}-->
		</td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="5" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	</table>
	</form>

  </div>
</div>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：自定义页面<span>&gt;</span>添加单页</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_p.php" class="btn-general">返回列表</a><span class="pro_hover">单页基本信息</span><span>单页配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_p.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="110">名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>模板：</th>
		<td>
		<select name="types" id="selects">
		<!--{foreach $pstyle as $key => $volist}--> 
            <option value="<!--{$key}-->"><!--{$volist}--></option>
		<!--{/foreach}-->
		</select>
		</td>
	  </tr>
	  <tr>
		<th>图片：<span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=p&is_thumb=2'></iframe>		
		</td>
	  </tr>
	  <tr>
		<th>内容：</th>
		<td>
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	  
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">标题：<span class='f_red'></span></th>
		<td><input type="text" name="title" id="titles" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">关键词：<span class='f_red'></span></th>
		<td><input type="text" name="keywords" id="keywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>描述：</th>
		<td>
			<textarea name="description" id="description" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
		<td><input type="submit" name="btn_save" id="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>	
	</form>
  </div>
  <div style="clear:both;"></div>
  <script type="text/javascript">
    $("#selects option[value='demo']").attr("selected", true);
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
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：自定义页面<span>&gt;</span>编辑单页</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_p.php" class="btn-general">返回列表</a><span class="pro_hover">单页基本信息</span><span>单页配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_p.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="110">名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" value="<!--{$cate.cname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>图片： <span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles"  value="<!--{$cate.img}-->" />
		  <!--{if $cate.img != ''}-->
		  	 <img class='upload_img' src="../<!--{$cate.img}-->" />
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=p&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   $("#selects option[value='<!--{$cate.types}-->']").attr("selected", true);
		   var t = "<!--{$cate.img}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
		<th>内容：</th>
		<td>
		  <script id="container" name="content" type="text/plain"><!--{$cate.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">标题：<span class='f_red'></span></th>
		<td><input type="text" name="title" id="titles" class="input-txt" value="<!--{$cate.title}-->"  /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">关键词：<span class='f_red'></span></th>
		<td><input type="text" name="keywords" id="keywords" class="input-txt" value="<!--{$cate.keywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>描述：</th>
		<td>
			<textarea name="description" id="description" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$cate.description}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
		<td><input type="submit" name="btn_save" id="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>	
	</form>
  </div>
  <div style="clear:both;"></div>
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
</div>
<!--{/if}-->
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>
