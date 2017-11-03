<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>自定义单页</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>公司概况</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_page.php?action=add" class="btn-general">添加概况</a>公司概况</h3>
    <form action="xycms_page.php" method="post" name="myform" id="myform" style="margin:0">
    <input type="hidden" name="action" id="action" value="del" />
    <div class="tab">
  	<ul class="tab_li">
  		<!--{foreach $page_category as $volist}-->
  			<li <!--{if $volist.state == 2}-->class="icon_web"<!--{/if}--> ><!--{$volist.cname}--></li>
  		<!--{/foreach}-->
  	</ul>
  	<div class="tab_content">
  		<!--{foreach $data as $cate}-->
  		  <div class="contentlist">
  			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
  				<thead class="tb-tit-bg">
				  <tr>
				  	<th width="60"><div class="th-gap">选择</div></th>
					<th width="10%">所属分类</th>
					<th width="15%">概况名称</th>
					<th width="10%">自定义目录</th>
					<th width="6%">排序</th>
					<th width="5%">状态</th>
					<th width="8%">打开方式</th>
					<th width="8%">链接类型</th>
					<th width="14%">URL</th>
					<th>操作</th>
				  </tr>
			  </thead>
  		<!--{foreach $cate as $volist}-->
	    <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="id<!--{$cate.0.id}-->" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItems(this, 'chkAll<!--{$cate.0.id}-->')" /></td>
	    <td align="center"><!--{$volist.cname}--></td>
		<td align="left">
		<!--{if $volist.catdir == 'about'}-->
			<a href="../about/<!--{$volist.word}-->.html" target="_blank"><!--{$volist.title}--></a>
		<!--{else}-->
			<a href="../about_<!--{$volist.catdir}-->/<!--{$volist.word}-->.html" target="_blank"><!--{$volist.title}--></a>
		<!--{/if}-->
		</td>
		<td align="center"><!--{$volist.word}--></td>	
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagopen" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.id}-->" value="flagclose" />
			<img id="flag<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{if $volist.target==1}--><font color="green">本页</font><!--{else}--><font color="blue">新页面</font><!--{/if}--></td>
		<td align="center"><!--{if $volist.linktype==1}--><font color="green">站内</font><!--{else}--><font color="blue">站外</font><!--{/if}--></td>
		<td align="left"><!--{$volist.linkurl}--></td>
		<td align="center"><a href="xycms_page.php?action=edit&id=<!--{$volist.id}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_page.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{if empty($volist.chil_cate)}--><!--{else}-->
	  <!--{foreach $volist.chil_cate as $thirdlist}-->
	    <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="id<!--{$cate.0.id}-->" type="checkbox" value="<!--{$thirdlist.cid}-->" onclick="checkItems(this, 'chkAll<!--{$cate.0.id}-->')" /></td>
	    <td align="center"><!--{$thirdlist.cname}--></td>
		<td align="left">
		<!--{if $thirdlist.catdir == 'about'}-->
			<a href="../about/<!--{$thirdlist.word}-->.html" target="_blank">├&nbsp;<!--{$thirdlist.title}--></a>
		<!--{else}-->
			<a href="../about_<!--{$thirdlist.catdir}-->/<!--{$thirdlist.word}-->.html" target="_blank">├&nbsp;<!--{$thirdlist.title}--></a>
		<!--{/if}-->
		</td>
		<td align="center"><!--{$thirdlist.word}--></td>	
		<td align="center"><!--{$thirdlist.orders}--></td>
		<td align="center">
		<!--{if $thirdlist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$thirdlist.id}-->" value="flagopen" />
			<img id="flag<!--{$thirdlist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$thirdlist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$thirdlist.id}-->" value="flagclose" />
			<img id="flag<!--{$thirdlist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$thirdlist.id}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td align="center"><!--{if $thirdlist.target==1}--><font color="green">本页</font><!--{else}--><font color="blue">新页面</font><!--{/if}--></td>
		<td align="center"><!--{if $thirdlist.linktype==1}--><font color="green">站内</font><!--{else}--><font color="blue">站外</font><!--{/if}--></td>
		<td align="left"><!--{$thirdlist.linkurl}--></td>
		<td align="center"><a href="xycms_page.php?action=edit&id=<!--{$thirdlist.id}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_page.php?action=del&id[]=<!--{$thirdlist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{/if}-->
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="10" align="center">暂无信息</td>
	  </tr>
  	  <!--{/foreach}-->
	  <!--{if $cate.0.total>0}-->
	  <tr>
		<td align="center"><label><input name="chkAll" type="checkbox" class="chkAll<!--{$cate.0.id}-->" onclick="checkAllS(this, 'id<!--{$cate.0.id}-->')" value="checkbox" />&nbsp;&nbsp;全选</label></td>
		<td class="hback" colspan="9">
        <input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('delcates');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$cate.0.total}--></b> ]条记录
        </td>
      </tr>
	  <!--{/if}-->
  	</table>
  	</div>
  		<!--{/foreach}-->
  	</div>
	</div>

	</form>
	</div>
  </div>
<script>
(function($){	
	var tab = parseInt($.cookie('tab'));
	// alert($('.tab_content > .contentlist').length + "--" +tab);
	if(!tab){
		$('.tab_li > li').first().addClass('on');
		$('.tab_content > .contentlist').first().addClass('on');
	}else{
		if($('.tab_content > .contentlist').length < tab + 1){
			$.cookie('tab', 0);
			tab = 0;
		}
		$('.tab_li > li').eq(tab).addClass('on').siblings('li').removeClass('on');
		$('.tab_content > .contentlist').eq(tab).addClass('on').siblings('.contentlist').removeClass('on');
	}
})($);
</script>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>公司概况</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_page.php" class="btn-general">返回列表</a><span class="pro_hover">概况基本信息</span><span>概况配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_page.php" onsubmit='return checkform(1);' >
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="110">概况分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>概况名称 <span class="f_red">*</span> </th>
		<td><input type="text" name="title" id="title" class="input-txt" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>自定义分类目录：<span class='f_red'>*</span></th>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>图片：<span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=about&is_thumb=2'></iframe>			</td>
	  </tr>
	  <tr>
		<th>打开方式 <span class="f_red"></span> </th>
		<td><input type="radio" name="target" id="target" value="1" checked="checked" />本页，<input type="radio" name="target" id="target" value="2" />新页面</td>
	  </tr>
	  <tr>
		<th>链接类型 <span class="f_red"></span> </th>
		<td><input type="radio" name="linktype" id="linktype" value="1" checked="checked" />站内，<input type="radio" name="linktype" id="linktype" value="2" />站外</td>
	  </tr>
	  <tr>
		<th>站外URL <span class="f_red"></span> </th>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" /> <span id='dlinkurl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>页面排序 <span class="f_red"></span> </th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" /> <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>页面内容 <span class="f_red"></span></th>
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
		<td><input type="text" name="ptitle" id="ptitle" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="pkeywords" id="pkeywords" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="pdescription" id="pdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（200字符以内）
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>公司概况</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_page.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">概况基本信息</span><span>概况配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_page.php" onsubmit='return checkform();' >
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="110">概况分类 <span class='f_red'>*</span></th>
		<td><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>概况名称 <span class="f_red">*</span> </th>
		<td><input type="text" name="title" id="title" class="input-txt" value="<!--{$volpage.title}-->" /> <span id='dtitle' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>自定义分类目录：<span class='f_red'>*</span></th>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" value="<!--{$volpage.word}-->" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>图片：<span class="f_red"></span> </th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles"  value="<!--{$volpage.img}-->" />
		  <!--{if $volpage.img != ''}-->
		  	 <img class='upload_img' src="../<!--{$volpage.img}-->" /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <!--{else}-->
		     <img class='upload_img' /> 
		     <a href="javascript:void(0)" class="pic_remove">[删除]</a> 
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=about&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$volpage.img}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
		<th>打开方式 <span class="f_red"></span> </th>
		<td><input type="radio" name="target" class="target" value="1" />本页，<input type="radio" name="target" class="target" value="2" />新页面</td>
	  </tr>
	  <tr>
		<th>链接类型 <span class="f_red"></span> </th>
		<td><input type="radio" name="linktype" class="linktype" value="1" />站内，<input type="radio" name="linktype" class="linktype" value="2" />站外</td>
	  </tr>
	  <tr>
		<th>站外URL <span class="f_red"></span> </th>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" value="<!--{$volpage.linkurl}-->" /> <span id='dlinkurl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>页面排序 <span class="f_red"></span> </th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$volpage.orders}-->" /> <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>页面内容 <span class="f_red"></span></th>
		<td>
		  <script id="container" name="content" type="text/javascript"><!--{$volpage.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form' style="display:none;">
	  <tr>
		<th width="110">Title：<span class='f_red'></span></th>
		<td><input type="text" name="ptitle" id="ptitle" class="input-txt" value="<!--{$volpage.ptitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="110">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="pkeywords" id="pkeywords" class="input-txt" value="<!--{$volpage.pkeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="pdescription" id="pdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$volpage.pdescription}--></textarea><br />（200字符以内）
		</td>
	  </tr>
	</table>
	<table class='table_form'>
	  <tr>
		<th width="110"></th>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<script type="text/javascript">
//链接内型和打开方式		
$(function(){
if(<!--{$volpage.linktype}--> == 1){
  $(".linktype:eq(0)").attr("checked",true);
  }else{
  $(".linktype:eq(1)").attr("checked",true);
   }
if(<!--{$volpage.target}--> == 1){
	  $(".target:eq(0)").attr("checked",true);
}else{
	  $(".target:eq(1)").attr("checked",true);
}     
 });
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
<!--{/if}--> 

<script type="text/javascript" src="js/check.js"></script>
</body>
</html>