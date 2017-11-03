<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>新闻管理</title>
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
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：新闻管理<span>&gt;</span>新闻分类</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_infocate.php?action=add" class="btn-general">添加分类</a>新闻分类</h3>
	<form action="xycms_infocate.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	  	<th width="60"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">分类名称</div></th>
		<th width="10%"><div class="th-gap">图标</div></th>
		<th width="8%"><div class="th-gap">链接</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="8%"><div class="th-gap">状态</div></th>
		<th width="10%"><div class="th-gap">新闻</div></th>
		<th width="11%"><div class="th-gap">录入时间</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $cate as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="id" type="checkbox" value="<!--{$volist.cid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td><!--{if $volist.depth==0}--><b><!--{$volist.cname}--></b><!--{else}--><!--{$volist.tree_catename}--><!--{/if}--></td>
		<td align="center"><!--{if $volist.img!=''}--><img src="../<!--{$volist.img}-->" border="0" style="width:65px;" /><!--{else}--><font color="#999999">无图标</font><!--{/if}--></td>
		<td align="center"><!--{if $volist.linktype==1}--><font color="green">内部</font><!--{else}--><font color="blue">外部</font><!--{/if}--></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagopen" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagclose" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
		</td>
		<td align="center"><!--{$volist.infocount}--></td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>
		<td align="center"><a href="xycms_infocate.php?action=edit&id=<!--{$volist.cid}-->&page=<!--
{$page}-->" class="icon-set">修改</a>&nbsp;&nbsp;<a href="xycms_infocate.php?action=del&id=<!--{$volist.cid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="9" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><label><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" />&nbsp;&nbsp;全选</label></td>
		<td class="hback" colspan="8">
        <input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('delcates');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录
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
  <div class="path"><p>当前位置：新闻管理<span>&gt;</span>添加新闻分类</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_infocate.php" class="btn-general">返回列表</a><span class="pro_hover">新闻分类基本信息</span><span>新闻分类配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_infocate.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="110">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">自定义分类目录：<span class='f_red'>*</span></th>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th width="110">所属分类：<span class='f_red'>*</span></th>
		<td>
			<!--{$cate_select}--> （不选择表示作为一级分类，最多支持三级分类） <span class='f_red' id="drootid"></span>
		</td>
	  </tr>
	  <tr>
		<th>分类排序：<span class='f_red'></span></th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
	   <th>样式图标：<span class="f_red"></span></th> 
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <img class='upload_img' />
		  <a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' class="iframe_t1" frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2'></iframe>	  	
		</td>
	  </tr>
	  <tr>
	   <th>栏目banner：<span class="f_red"></span></th> 
		<td>
		  <input type="hidden" name="banner" id="uploadfiles"  />
		  <img class='upload_img' />
		  <a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2&index=2'></iframe>	  	
		</td>
	  </tr>
	  <tr>
		<th>打开方式：<span class='f_red'></span></th>
		<td><select name="target" id="target"><option value="1">本页面</option><option value="2">新页面</option></select></td>
	  </tr>
	  <tr>
		<th>链接类型：<span class='f_red'></span></th>
		<td><input type="radio" name="linktype" value="1" checked="checked" />内部链接，<input type="radio" name="linktype" value="2" />外部链接</td>
	  </tr>
	  <tr>
		<th>外部URL：<span class='f_red'></span></th>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" /> <span class='f_red' id="dlinkurl"></span></td>
	  </tr>
	  <tr>
		<th>分类描述：</th>
		<td><textarea name="intro" id="intro" style='width:60%;height:60px;overflow:auto;color:#444444;'></textarea><br />（500字符以内）</td>
	  </tr>
	  <tr>
		<th>详细介绍：</th>
		<td>
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">Title：<span class='f_red'></span></th>
		<td><input type="text" name="title" id="titles" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="keywords" id="keywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
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
  <div class="path"><p>当前位置：内容管理<span>&gt;</span>编辑新闻分类</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_infocate.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">新闻分类基本信息</span><span>新闻分类配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_infocate.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<td width="110">分类名称：<span class='f_red'>*</span></td>
		<td><input type="text" name="cname" id="catename" class="input-txt" value="<!--{$cate.cname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<td>自定义分类目录：<span class='f_red'>*</span></td>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" value="<!--{$cate.word}-->" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<td>分类排序：<span class='f_red'></span></td>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$cate.orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<td>参数设置：<span class='f_red'></span></td>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<td>样式图标： <span class="f_red"></span></td>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" class="uploadfiles"  value="<!--{$cate.img}-->" />
		  <!--{if $cate.img != ''}-->
		  	 <img class='upload_img' src="../<!--{$cate.img}-->" />
		  <!--{else}-->
		     <img class='upload_img' />
		  <!--{/if}-->
		  <a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$cate.img}-->";
		    if(t != ''){
		    	$('.uploadfiles').siblings(".upload_img").css("display","block");
		    	$('.uploadfiles').siblings(".pic_remove").css("display","block");
		    	$('.uploadfiles').siblings("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
	   <td>栏目banner：</td> 
		<td>
		  <input type="hidden" name="banner" id="uploadfiles" class="banner"  value="<!--{$cate.banner}-->" />
		  <!--{if $cate.banner != ''}-->
		  	 <img class='upload_img' src="../<!--{$cate.banner}-->" />
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=news&is_thumb=2&index=2'></iframe>	
		  <script type="text/javascript">
		   var t = "<!--{$cate.banner}-->";
		    if(t != ''){
		    	$('.banner').siblings(".upload_img").css("display","block");
		    	$('.banner').siblings(".pic_remove").css("display","block");
		    	$('.banner').siblings("#iframe_t").css("display","none");
		    }
		  </script>		  	
		</td>
	  </tr>
	  <tr>
		<td>打开方式：<span class='f_red'></span></td>
		<td><select name="target" id="target"><option value="1">本页面</option><option value="2">新页面</option></select></td>		
	  </tr>
	  <tr>
		<td>链接类型：<span class='f_red'></span></td>
		<td><input type="radio" name="linktype" class="linktype" value="1" />内部链接，<input type="radio" name="linktype" class="linktype" value="2" />外部链接</td>
	  </tr>
	  <tr>
		<td>外部URL：<span class='f_red'></span></td>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" value="<!--{$cate.linkurl}-->" /> <span class='f_red' id="dlinkurl"></span></td>
	  </tr>
	  <tr>
		<td>分类描述：</td>
		<td><textarea name="intro" id="intro" style='width:60%;height:60px;overflow:auto;color:#444444;'><!--{$cate.intro}--></textarea><br />（500字符以内）</td>
	  </tr>
	  <tr>
		<th>详细介绍：</th>
		<td>
		  <script id="container" name="content" type="text/javascript"><!--{$cate.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">Title：<span class='f_red'></span></th>
		<td><input type="text" name="title" id="titles" class="input-txt" value="<!--{$cate.title}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="keywords" id="keywords" class="input-txt" value="<!--{$cate.keywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="description" id="description" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$cate.description}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
		<td><input type="submit" name="btn_save" id="btn_save" class="button" value="更新保存" /></td>
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

<script type="text/javascript">
//链接内型和打开方式		
$(function(){
if('<!--{$cate.linktype}-->' == 1){
  $(".linktype:eq(0)").attr("checked",true);
  }else{
  $(".linktype:eq(1)").attr("checked",true);
   }
if(<!--{$cate.target}--> == 1){
	  $("#target option:eq(0)").attr("selected",true);
}else{
	  $("#target option:eq(1)").attr("selected",true);
}     
 });
</script>
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>
