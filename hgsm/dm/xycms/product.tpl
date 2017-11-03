<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>产品内容</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link rel="stylesheet" href="../data/editor/themes/default/default.css" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<link rel="stylesheet" href="../data/ueditor/themes/default/css/ueditor.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../data/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="../data/maxpic/jquery.uploadify-3.1.min.js?version=<!--{$rand}-->"></script>
<link rel="stylesheet" type="text/css" href="../data/maxpic/uploadify.css"/>
<link rel="stylesheet" href="../data/maxpic/jquery-ui.css">
<script src="../data/maxpic/jquery-ui.js"></script>

<script type="text/javascript">
var img_id_upload=new Array();//初始化数组，存储已经上传的图片名
var i=0;//初始化数组下标
$(function() {
    $('#file_upload').uploadify({
    	'auto'     : true,//关闭自动上传
    	'removeTimeout' : 0.05,//文件队列上传完成1秒后删除
        'swf'      : '../data/maxpic/uploadify.swf',
        'uploader' : '../data/maxpic/uploadify.php',
        'method'   : 'post',//方法，服务端可以用$_POST数组获取数据
        "formData" : {'list' : 'product'},//图片保存目录
        'buttonText' : '选择图片',//设置按钮文本
        'multi'    : true,//允许同时上传多张图片
        'uploadLimit' : 100,//一次最多只允许上传10张图片
        'fileTypeDesc' : 'Image Files',//只允许上传图像
        'fileTypeExts' : '*.gif; *.jpg; *.png',//限制允许上传的图片后缀
        'fileSizeLimit' : '2000KB',//限制上传的图片不得超过200KB 
        'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
               img_id_upload[i]=data;
               i++;
        },
        'onQueueComplete' : function(queueData) {//上传队列全部完成后执行的回调函数
            var str='';
       
            //console.log(img_id_upload);
			if(img_id_upload.length>0)
			{
				for (x in img_id_upload)
				{

				  str+=("<li class='ui-state-default' data-img='"+img_id_upload[x]+"'><img src='../data/images/product/"+img_id_upload[x]+"'/>"+"<h4 class='delete'>[ 删除 ]</h4></li>");
				}
			}
			 $('#sortable').append(str);
			 $('#abc').css('border','1px solid #e1e1e1');
			 aa();
			 img_id_upload=new Array();
        }  
     
    });
});
 $(function(){
	$( "#sortable" ).sortable({
	    stop: function(event){
	     aa();   
	    }
	});
	$( "#sortable" ).disableSelection();
  });
</script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>产品展示</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="xycms_product.php?action=add" class="btn-general">发布产品</a>产品展示</h3>
	<div class="search-area ">
	  <form method="post" id="search_form" action="xycms_product.php">
	  <div class="item">
	    <label>产品分类：</label><!--{$cate_search}-->&nbsp;&nbsp;
		<label>标题：</label><input type="text" id="sname" name="sname" size="20" class="input input-text" value="<!--{$sname}-->" />&nbsp;&nbsp;&nbsp;
		<input type="submit" class="button_s" value="搜 索" />
	  </div>
	  </form>
	</div>
	<form action="xycms_product.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <input type="hidden" name="cate" id="cate" value="" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="40"><div class="th-gap">选择</div></th>
		<th width="20%"><div class="th-gap">所在分类</div></th>
		<th width="60"><div class="th-gap">排序</div></th>
		<th width="40"><div class="th-gap">预览图</div></th>
		<!--{if $uc_adminname == 'master'}-->
		<th width="32%"><div class="th-gap">产品名称</div></th>
		<!--{else}-->
		<th width="50%"><div class="th-gap">产品名称</div></th>
		<!--{/if}-->
		<th width="30"><div class="th-gap">浏览</div></th>
		<th width="30"><div class="th-gap">状态</div></th>
		<th width="30"><div class="th-gap">推荐</div></th>		
		<th width="30"><div class="th-gap">新品</div></th>
		<th width="125"><div class="th-gap">录入时间</div></th>
		<th width="135"><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $product as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
	    <td align="center"><input name="id[]" class="id" type="checkbox" value="<!--{$volist.id}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.cname}--></td>
     	<td align="center">
        <input type="text" name="orders[]" value="<!--{$volist.orders}-->" class="orders" />
        </td>
		<td align="center">
		<!--{if $volist.thumbfiles!=''}-->
		<a href="../<!--{$volist.uploadfiles}-->" target="_blank"><img src="../<!--{$volist.thumbfiles}-->" width="40" height="25" border="0" /></a>
		<!--{else}-->
		<img src="../template/static/images/s_nopic.jpg" width="40" height="25" border="0" />
		<!--{/if}-->
        </td>
		<td align="left"><a href="../product/<!--{$volist.id}-->.html" target="_blank"><!--{$volist.title|truncate:40}--></a></td>
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
        <td align="center">
 		<!--{if $volist.isnew==0}-->
			<input type="hidden" id="attr_isnew<!--{$volist.id}-->" value="isnewopen" />
			<img id="isnew<!--{$volist.id}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('isnew','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_isnew<!--{$volist.id}-->" value="isnewclose" />
			<img id="isnew<!--{$volist.id}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('isnew','<!--{$volist.id}-->');" style="cursor:pointer;" />
		<!--{/if}-->       
        </td>
		<td align="center"><!--{$volist.timeline|date_format:"%Y/%m/%d"}--></td>

	<td align="center"><a href="xycms_product.php?action=edit&id=<!--{$volist.id}-->&page=<!--{$page}-->&<!--{$urlitem}-->" class="icon-edit">修改</a>&nbsp;&nbsp;<a href="xycms_product.php?action=del&id[]=<!--{$volist.id}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="13" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'id[]')" value="checkbox" /></td>
		<td class="hback" colspan="10">
        <input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定信息吗!?')){$('#action').val('del');$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录
        <input class="button" id="order_btn" name="order_btn" type="button" value="更新排序" class="button" />
        <span id="p_move">移动到:</span>
        <span id="move_select"><!--{$cate_select}--></span>
        <span id="p_copy" style="padding-left:10px;">复制到:</span>
        <span id="copy_select"><!--{$copy_select}--></span>
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

<!--{if $action == "recommend"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>推荐产品</p></div>
   <div class="main-cont">
   	<h3 class="title"><a href="xycms_product.php" class="btn-general">全部产品</a>
   	<a href="javascript:;" class="update_orders">更新排序</a>推荐产品</h3>
   	<div class="list">
   	  <ul class="clearfix recommend">
   	    <!--{foreach $recommend as $volist}-->
   	     <li>
   	     <a class="pic" href="../product/<!--{$volist.id}-->.html" target="_blank"><img src="../<!--{$volist.thumbfiles}-->" /></a>
   	     <a href="#" class="name"><!--{$volist.title|truncate:18}--></a>
   	     <div class="opera"><a href="javascript:;" class="remove" type="elite" rel="<!--{$volist.id}-->">移除</a><a href="xycms_product.php?action=edit&id=<!--{$volist.id}-->" class="edit">修改</a><span>排序:</span><input type="text" name="orders" value="<!--{$volist.elite_orders}-->" id="<!--{$volist.id}-->" class="orders" /></div>
   	     </li>
   	    <!--{/foreach}-->
   	  </ul>
   	</div>
   </div>
</div>
<!--{/if}-->

<!--{if $action == "isnew"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：产品管理<span>&gt;</span>最新产品</p></div>
   <div class="main-cont">
   	<h3 class="title"><a href="xycms_product.php" class="btn-general">全部产品</a>
   	<a href="javascript:;" class="update_orders">更新排序</a>最新产品</h3>
   	<div class="list">
   	  <ul class="clearfix recommend">
   	    <!--{foreach $isnew as $volist}-->
   	     <li>
   	     <a class="pic"><img src="../<!--{$volist.thumbfiles}-->" /></a>
   	     <a href="#" class="name"><!--{$volist.title|truncate:18}--></a>
   	     <div class="opera"><a href="javascript:;" class="remove" type="isnew" rel="<!--{$volist.id}-->">移除</a><a href="xycms_product.php?action=edit&id=<!--{$volist.id}-->" class="edit">修改</a><span>排序:</span><input type="text" name="orders" value="<!--{$volist.isnew_orders}-->" id="<!--{$volist.id}-->" class="orders" /></div>
   	     </li>
   	    <!--{/foreach}-->
   	  </ul>
   	</div>
   </div>
</div>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容管理<span>&gt;</span>发布产品</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_product.php" class="btn-general">返回列表</a><span class="pro_hover">产品基本信息</span><span>高级信息</span><span>产品配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_product.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
    <input type="hidden" name="add_cid" id="add_cid" value="<!--{$cid}-->" />
	<table class='table_form table_forms'>
	  <tr>
		<th width="80">产品分类 <span class='f_red'></span></th>
		<td colspan="2"><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>产品名称 <span class="f_red">*</span> </th>
		<td colspan="2"><input type="text" name="title" id="title" class="input-txt" /> <span id='dproductname' class='f_red'></span>
        <input type="radio" name="taggu" class="post1" value="1"  />&nbsp;&nbsp;关键词开启&nbsp;&nbsp;<input type="radio" name="taggu" class="post1" value="0" checked="checked" />&nbsp;&nbsp;关闭
		</td>
	  </tr>	
	  <tr>
		<th>产品图片 <span class="f_red"></span> </th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles" />
		  <img class='upload_img' /><a href="javascript:void(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=product'></iframe>
        </td>
        <td style=""><!--{$size}--></td>
	  </tr>
	  <tr>
		<th>长尾词</th>
		<td colspan="2">
		<input type="text" name="nagao" id="nagao" style="cursor:not-allowed;" readonly="readonly" class="input-txt" value="<!--{$tailword}-->" />
        <label><input type="radio" name="post" class="post" value="1" onclick="javascript:addword1()" />&nbsp;&nbsp;前缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="2" checked="checked" onclick="javascript:addword2()" />&nbsp;&nbsp;后缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="3" onclick="javascript:addword3()" />&nbsp;&nbsp;关闭</label>
		</td>
	  </tr>
	  <tr>
		<th>相关关键词</th>
		<td colspan="2">
		<input type="text" name="tag" id="tag" class="input-txt" />
		<span id="smart_keywords">自动选择</span>
		<span id='dtag' class='f_red'></span> (多个请用英文,号隔开)
		</td>
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
		<td colspan="2"><!--{$flag_checkbox}-->，<!--{$elite_checkbox}-->，<!--{$isnew_checkbox}--></td>
	  </tr>
	  <tr>
		<th>详细介绍 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr>
	</table>
	<table class='table_form table_forms' style="display:none;">
	  <tr>
		<th width="90" style="vertical-align: top;padding-top:20px;">产品多图 <span class="f_red"></span> </th>
		<td>
		 <div class="ee clearfix">
			<input type="hidden" class="img_src" readonly="readonly" name="img_input">
			 <input type="file" name="file_upload" id="file_upload" />
			
			 <span style="padding-left:10px;padding-top:7px;display:inline-block;"><!--{$size}--></span>
		  </div>
			<div id="abc">
			   <ul id="sortable" class="thum_img clearfix" style="min-height:50px;">
			 </ul>
           </div>
        </td>
	  </tr>
	  <tr>
		<th>产品编号 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="productnum" id="productnum" class="input-txt" /> <span id='dproductnum' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>产品价格 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="price" id="price" class="input-s" /> （填写数字，单位为人民币￥） <span id='dprice' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>浏览次数 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="hits" id="hits" class="input-s" /> <span id='dhits' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段1 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext1" id="wrext1" class="input-txt" /> <span id='dwrext1' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段2 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext2" id="wrext2" class="input-txt" /> <span id='dwrext2' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段3 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext3" id="wrext3" class="input-txt" /> <span id='dwrext3' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展标签1 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container1" name="extend1" type="text/javascript"></script>
		  <script type="text/javascript">var ue1 = UE.getEditor('container1');</script>
		  <span id='dcontent' class='f_red'></span>
		</td>
	  </tr> 
	  <tr>
		<th>扩展标签2 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container2" name="extend2" type="text/javascript"></script>
		  <script type="text/javascript">var ue2 = UE.getEditor('container2');</script>
		  <span id='dcontent' class='f_red'></span>
		  </td>
	  </tr> 
	  <tr>
		<th>扩展标签3 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container3" name="extend3" type="text/javascript"></script>
		  <script type="text/javascript">var ue3 = UE.getEditor('container3');</script>
		  <span id='dcontent' class='f_red'></span>
		  </td>
	  </tr> 
	</table>
	<table class='table_form table_forms' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="ptitle" id="ptitle" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
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
		<th width="80"></th>
		<td ><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>	
	</form>
	<div style='height:30px'>
	</div>
  </div>
  <div style="clear:both;"></div>
</div>
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
<script type="text/javascript">
    $(".title span").click(function(){
    	var index = $(this).index() -1;
    	$(this).addClass("pro_hover").siblings("span").removeClass("pro_hover");
    	$(".table_forms").eq(index).show().siblings('.table_forms').hide();
    });
</script>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容管理<span>&gt;</span>编辑产品</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><a href="xycms_product.php?<!--{$comeurl}-->" class="btn-general">返回列表</a><span class="pro_hover">产品基本信息</span><span>高级信息</span><span>产品配置信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_product.php" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<input type="hidden" name="page" value="<!--{$page}-->" />
	<table class='table_form table_forms'>
	  <tr>
		<th width="80">产品分类 <span class='f_red'></span></th>
		<td colspan="2"><!--{$cate_select}--> <span id="dcateid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>产品名称 <span class="f_red">*</span> </th>
		<td colspan="2"><input type="text" name="title" id="title" class="input-txt" value="<!--{$product.title}-->" /> <span id='dproductname' class='f_red'></span>
        <input type="radio" name="taggu" class="post1" <!--{if $taggu==1}-->checked="checked"<!--{/if}--> value="1"  />&nbsp;&nbsp;关键词开启&nbsp;&nbsp;<input type="radio" name="taggu" class="post1" <!--{if $taggu==0}-->checked="checked"<!--{/if}--> value="0" />&nbsp;&nbsp;关闭
		</td>
	  </tr>  
	  <tr>
		<th>产品图片 <span class="f_red"></span></th>
		<td style="width:305px;">
		  <input type="hidden" name="uploadfiles" id="uploadfiles" value="<!--{$product.uploadfiles}-->" />
		  <input type="hidden" name="thumbfiles" id="thumbfiles"  value="<!--{$product.thumbfiles}-->" />
		  <!--{if $product.thumbfiles != ''}-->
		  	 <img class='upload_img' src="../<!--{$product.thumbfiles}-->" />
		  	 <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		 <!--{else}-->
		     <img class='upload_img' /> 
		     <a href="javascript:void(0)" class="pic_remove">[删除]</a>
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='305' height='25' src='upload_input.php?filepath=product'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$product.thumbfiles}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
		<td style=""><!--{$size}--></td>
	  </tr> 
	  <tr>
		<th>长尾词</th>
		<td colspan="2">
		<input type="text" name="nagao" id="nagao" style="cursor:not-allowed;" readonly="readonly" class="input-txt" value="<!--{$product.nagao}-->" />
        <label><input type="radio" name="post" class="post" value="1" onclick="javascript:addword3()" />&nbsp;&nbsp;前缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="2" onclick="javascript:addword4()" />&nbsp;&nbsp;后缀&nbsp;&nbsp;</label><label><input type="radio" name="post" class="post" value="3" onclick="javascript:addword5()" />&nbsp;&nbsp;关闭</label>
		</td>
	  </tr>
	  <tr>
		<th>相关关键词</th>
		<td colspan="2"><input type="text" name="tag" id="tag" class="input-txt" value="<!--{$product.tag}-->" /> <span id="smart_keywords">自动选择</span> <span id='dtag' class='f_red'></span> (多个请用英文,号隔开)</td>
	  </tr> 
      <tr  style="display:none;">
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
		<td colspan="2"><!--{$flag_checkbox}-->，<!--{$elite_checkbox}-->，<!--{$isnew_checkbox}--></td>
	  </tr>
	  <tr>
		<th>详细内容 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container" name="content" type="text/javascript"><!--{$product.content}--></script>
		  <script type="text/javascript">var ue = UE.getEditor('container');</script>
		</td>
	  </tr>
	</table>
	<table class='table_form table_forms' style="display:none;">
	  <tr>
		<th width="90" style="vertical-align: top;padding-top:20px;">产品多图 <span class="f_red"></span></th>
		<td>
		   <div class="ee clearfix">
			<input type="hidden" class="img_src" readonly="readonly" name="img_input" value="<!--{$product.img_input}-->">
			 <input type="file" name="file_upload" id="file_upload" />
		
			 <span style="padding-left:10px;padding-top:7px;display:inline-block;"><!--{$size}--></span>
		  </div>
			<div id="abc">
			   <ul id="sortable" class="thum_img clearfix" style="min-height:50px;">
			       <!--{foreach $arr as $volist}-->
			          <li class='ui-state-default' data-img='<!--{$volist.name}-->'><img src='<!--{$volist.img}-->' /><h4 class='delete'>[ 删除 ]</h4></li>
			       <!--{/foreach}-->
			   </ul>
           </div>
		</td>
	  </tr> 
	  <tr>
		<th>产品编号 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="productnum" id="productnum" class="input-txt" value="<!--{$product.productnum}-->" /> <span id='dproductnum' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>产品价格 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="price" id="price" class="input-s" value="<!--{$product.price}-->" /> （填写数字，单位为人民币￥） <span id='dprice' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>浏览次数 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="hits" id="hits" class="input-s" value="<!--{$product.hits}-->" /> <span id='dhits' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段1 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext1" id="wrext1" class="input-txt" value="<!--{$product.wrext1}-->" /> <span id='dwrext1' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段2 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext2" id="wrext2" class="input-txt" value="<!--{$product.wrext2}-->" /> <span id='dwrext2' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展字段3 <span class="f_red"></span></th>
		<td colspan="2"><input type="text" name="wrext3" id="wrext3" class="input-txt" value="<!--{$product.wrext3}-->" /> <span id='dwrext3' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>扩展标签1 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container1" name="extend1" type="text/javascript"><!--{$product.extend1}--></script>
		  <script type="text/javascript">var ue1 = UE.getEditor('container1');</script>
		  <span id='dcontent' class='f_red'></span>
		  </td>
	  </tr>
	  <tr>
		<th>扩展标签2 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container2" name="extend2" type="text/javascript"><!--{$product.extend2}--></script>
		  <script type="text/javascript">var ue2 = UE.getEditor('container2');</script>
		  <span id='dcontent' class='f_red'></span>
		  </td>
	  </tr> 
	  <tr>
		<th>扩展标签3 <span class="f_red">*</span></th>
		<td colspan="2">
		  <script id="container3" name="extend3" type="text/javascript"><!--{$product.extend3}--></script>
		  <script type="text/javascript">var ue3 = UE.getEditor('container3');</script>
		  <span id='dcontent' class='f_red'></span>
		  </td>
	  </tr>
	</table>
	<table class='table_form table_forms' style="display:none;">
	  <tr>
		<th width="80">Title：<span class='f_red'></span></th>
		<td><input type="text" name="ptitle" id="ptitle" class="input-txt" value="<!--{$product.ptitle}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th width="80">Keywords：<span class='f_red'></span></th>
		<td><input type="text" name="pkeywords" id="pkeywords" class="input-txt" value="<!--{$product.pkeywords}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>Description：</th>
		<td>
			<textarea name="pdescription" id="pdescription" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$product.pdescription}--></textarea><br />（200字符以内）
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
    	var index = $(this).index() -1;
    	$(this).addClass("pro_hover").siblings("span").removeClass("pro_hover");
    	$(".table_forms").eq(index).show().siblings('.table_forms').hide();
    });
</script>
<!--{/if}-->
<script>
	 $('#abc').on('mouseover','ul.thum_img li',function(){
	    $(this).find('h4').stop().animate({'bottom':'0'},'fast');
	  }) 
	  $('#abc').on('mouseout','ul.thum_img li',function(){
	    $(this).find('h4').stop().animate({'bottom':'-30px'},'fast');
	  }) 
	  $('#abc').on('click','ul.thum_img li h4',function(){
		       $(this).parents('li').remove();
			   aa(); 
	   })
	 function aa(){
		  var str='';
		  $('.img_src').attr('value','');
		  $.each($('ul.thum_img li'),function(n){
				   str+=$(this).data('img')+'#';
		  })
		  $('.img_src').attr('value',str.substring(0,str.length-1));	
	  }
</script>
<script type="text/javascript" src="js/check.js"></script>
</body>
</html>