<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>产品分类</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>产品分类</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_productcate.php?action=add" class="btn-general">添加分类</a>产品分类</h3>
    <form action="xycms_productcate.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="delcates" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	  	<th width="50"><div class="th-gap">选择</div></th>
	    <th width="6%"><div class="th-gap">ID</div></th>
		<th width="18%"><div class="th-gap">分类名称</div></th>
		<th width="7%"><div class="th-gap">排序</div></th>
		<th width="10%"><div class="th-gap">图标</div></th>
		<th width="8%"><div class="th-gap">链接</div></th>
		<th width="10%"><div class="th-gap">产品数</div></th>
		<th width="5%"><div class="th-gap">状态</div></th>
		<th width="10%"><div class="th-gap">录入时间</div></th>
		<!--{if $uc_adminname == 'master'}-->
		<th width="55"><div class="th-gap">前置</div></th>
		<!--{/if}-->
		<th width="120"><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $cate as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	  	<td align="center"><input name="id[]" class="id" type="checkbox" value="<!--{$volist.cid}-->" onclick="checkItem(this, 'chkAll')" /></td>
	    <td align="center"><!--{$volist.cid}--></td>
	    <td align="left"><!--{if $volist.depth==0}--><b><!--{$volist.cname}--></b><!--{else}--><!--{$volist.tree_catename}--><!--{/if}--></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center"><!--{if $volist.img!=''}--><img class="p_cate_img" src="../<!--{$volist.img}-->" border="0" /><!--{else}--><font color="#999999">无图标</font><!--{/if}--></td>
		<td align="center"><!--{if $volist.linktype==1}--><font color="green">内部</font><!--{else}--><font color="blue">外部</font><!--{/if}--></td>
		<td align="center"><!--{$volist.content_count}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagopen" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.cid}-->" value="flagclose" />
			<img id="flag<!--{$volist.cid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{/if}-->
		</td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y-%m-%d"}--></td>
		<!--{if $uc_adminname == 'master'}-->
		<td align="center">
		<!--{if $volist.front==0}-->
			<input type="hidden" id="attr_front<!--{$volist.cid}-->" value="frontopen" />
			<img id="front<!--{$volist.cid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('front','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_front<!--{$volist.cid}-->" value="frontclose" />
			<img id="front<!--{$volist.cid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('front','<!--{$volist.cid}-->');" style="cursor:pointer;" />
		<!--{/if}-->
        </td>
		<!--{/if}-->
		<td align="center"><a href="xycms_productcate.php?action=edit&id=<!--{$volist.cid}-->&page=<!--{$page}-->" class="icon-set">修改</a>&nbsp;&nbsp;<a href="xycms_productcate.php?action=del&id=<!--{$volist.cid}-->" onClick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="10" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><label><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" />&nbsp;&nbsp;全选</label></td>
		<td class="hback" colspan="10">
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
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>添加产品分类</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_productcate.php" class="btn-general">返回列表</a><span class="pro_hover">产品分类基本信息</span><span>产品分类配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_productcate.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="110">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
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
		<th>所属分类：<span class='f_red'></span></th>
		<td><!--{$cate_select}--> （不选择表示作为一级分类，最多支持三级分类） <span class='f_red' id="drootid"></span></td>
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
		  <iframe id='iframe_t' class="iframe_t1" frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=product&is_thumb=2'></iframe>	  	
		</td>
	  </tr>
	  <tr>
	   <th>栏目banner：<span class="f_red"></span></th> 
		<td>
		  <input type="hidden" name="banner" id="uploadfiles"  />
		  <img class='upload_img' />
		  <a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=product&is_thumb=2&index=2'></iframe>	  	
		</td>
	  </tr>
	  <tr>
		<th>长尾词：</th>
		<td colspan="2">
		<input type="text" name="nagao" id="nagao" style="cursor:not-allowed;" readonly="readonly" class="input-txt" value="<!--{$tailword}-->" />
        <label><input type="radio" name="post" class="post" value="1" onclick="javascript:addword1()" />&nbsp;&nbsp;前缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="2" checked="checked" onclick="javascript:addword2()" />&nbsp;&nbsp;后缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="3" onclick="javascript:addword3()" />&nbsp;&nbsp;关闭</label>
		</td>
	  </tr>
	  <tr>
		<th>是否开启过渡页：<span class='f_red'></span></th>
		<td>
				<input type="hidden" id="attr_custom" name="custom" value="0" />
				<img id="custom" src="xycms/images/no.gif" style="cursor:pointer;" />
		</td>
		<script type="text/javascript">
		   var value  = $("#attr_custom").val();
		   var imgno  = "xycms/images/no.gif";
		   var imgyes = "xycms/images/yes.gif";
		   $("#custom").toggle(
		   	  function(){
		   	  	$(this).attr("src",imgyes);
		   	  	$(this).siblings("#attr_custom").val(1);
		   	  },
		   	  function(){
		   	  	$(this).attr("src",imgno);
		   	  	$(this).siblings("#attr_custom").val(0);
		   	  }
		   );
		</script>
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
		<td>
			<textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea><br />（500字符以内）
		</td>
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
		function addword1(){
		  var word="<!--{$cityword}-->";
		  $("#nagao").val(word); 
		}
		function addword2(){
		  var word="<!--{$tailword}-->";
		  $("#nagao").val(word);

		}
		function addword3(){
		  var word="";
		  $("#nagao").val(word);

		}
  </script>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>编辑产品分类</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_productcate.php" class="btn-general">返回列表</a><span class="pro_hover">产品分类基本信息</span><span>产品分类配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_productcate.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="110">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="cname" id="catename" class="input-txt" value="<!--{$cate.cname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>自定义分类目录：<span class='f_red'>*</span></th>
		<td>
		<input type="text" name="word" id="word" class="input-txt word_url" value="<!--{$cate.word}-->" /> 
		<span id="word_btn">自动获取</span>
		<span class='f_red' id="wordname"></span>( 必须是是英文字符串组成 )	
		</td>
	  </tr>
	  <tr>
		<th>分类排序：<span class='f_red'></span></th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$cate.orders}-->" /> <span class='f_red' id="dorders"></span></td>
	  </tr>
	  <tr>
		<th>参数设置：<span class='f_red'></span></th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>样式图标： <span class="f_red"></span></th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" class="uploadfiles"  value="<!--{$cate.img}-->" />
		  <!--{if $cate.img != ''}-->
		  	 <img class='upload_img' src="../<!--{$cate.img}-->" />
		  <!--{else}-->
		     <img class='upload_img' />
		  <!--{/if}-->
		  <a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=product&is_thumb=2'></iframe>
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
	   <th>栏目banner：</th> 
		<td>
		  <input type="hidden" name="banner" id="uploadfiles" class="banner"  value="<!--{$cate.banner}-->" />
		  <!--{if $cate.banner != ''}-->
		  	 <img class='upload_img' src="../<!--{$cate.banner}-->" />
		  <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=product&is_thumb=2&index=2'></iframe>	
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
		<th>长尾词：</th>
		<td colspan="2">
		<input type="text" name="nagao" id="nagao" style="cursor:not-allowed;" readonly="readonly" class="input-txt" value="<!--{$cate.nagao}-->" />
        <label><input type="radio" name="post" class="post" value="1" onclick="javascript:addword3()" />&nbsp;&nbsp;前缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="2" onclick="javascript:addword4()" />&nbsp;&nbsp;后缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="3" onclick="javascript:addword5()" />&nbsp;&nbsp;关闭</label>
		</td>
	  </tr>
	  <tr>
		<th>是否开启过渡页：<span class='f_red'></span></th>
		<td>
		<!--{if $cate.custom==0}-->
			<input type="hidden" id="attr_custom<!--{$cate.cid}-->" value="customopen" />
			<img id="custom<!--{$cate.cid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('custom','<!--{$cate.cid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_custom<!--{$cate.cid}-->" value="customclose" />
			<img id="custom<!--{$cate.cid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('custom','<!--{$cate.cid}-->');" style="cursor:pointer;" />
		<!--{/if}-->
		</td>
	  </tr>
	  <tr>
		<th>打开方式：<span class='f_red'></span></th>
		<td><select name="target" id="target"><option value="1">本页面</option><option value="2">新页面</option></select></td>
	  </tr>
	  <tr>
		<th>链接类型：<span class='f_red'></span></th>
		<td><input type="radio" name="linktype" class="linktype" value="1" />内部链接，<input type="radio" name="linktype" class="linktype" value="2" />外部链接</td>	
	  </tr>	  	  
	  <tr>
		<th>外部URL：<span class='f_red'></span></th>
		<td><input type="text" name="linkurl" id="linkurl" class="input-txt" value="<!--{$cate.linkurl}-->" /> <span class='f_red' id="dlinkurl"></span></td>
	  </tr>
	  <tr>
		<th>分类描述：</th>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$cate.intro}--></textarea><br />（500字符以内）</td>
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
		<td><input type="text" name="title" id="titles" class="input-txt" value="<!--{$cate.title}-->"  /> <span class='f_red' id="dcatename"></span></td>
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
		<td><input type="submit" name="btn_save" id="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>	
	</form>
  </div>
  <div style="clear:both;"></div>
	<script  type="text/javascript">
	//链接内型和打开方式		
	$(function(){
	if(<!--{$post}--> == 1){
	  $(".post:eq(0)").attr("checked",true);
	  }else if(<!--{$post}--> == 2){
	  $(".post:eq(1)").attr("checked",true);
	   }else if(<!--{$post}--> == 3){
	  $(".post:eq(2)").attr("checked",true);
	   } 

	 });
	function addword3(){
	  var word="<!--{$cityword}-->";
	  $("#nagao").val(word); 
	}
	function addword4(){
	  var word="<!--{$tailword}-->";
	  $("#nagao").val(word);

	}
	function addword5(){
	  var word="";
	  $("#nagao").val(word);

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
  <script  type="text/javascript">
//链接内型和打开方式		
$(function(){
if(<!--{$cate.linktype}--> == 1){
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
</div>
<!--{/if}-->
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>
