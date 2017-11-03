<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>广告管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>广告管理</p></div>
  <div class="main-cont">
    <h3 class="title"><span style="width:80px;display:block;float:left;text-align:center;">广告管理</span>
    <a href="xycms_ads.php?action=add" class="btn-general">添加图片</a>
    <a href="xycms_adszone.php?action=add" class="btn-general">添加分类</a>
    <a href="xycms_adszone.php" class="btn-general">广告分类</a>
    </h3>
	<div class="category">
     <span class="ads_title">广告种类：</span>
     <div id="ads">
      <ul id="ads_category">
      <!--{foreach $category as $volist}-->
       <li>
          <a href="xycms_ads.php?szoneid=<!--{$volist.zoneid}-->" <!--{if $volist.zoneid==$szoneid}-->class="current"<!--{/if}-->>
      		 <!--{$volist.zonename}-->
          </a>
       </li>
      <!--{/foreach}-->  
      </ul>
     </div>
     <div class="clearboth"></div>
	</div>
	<form action="xycms_ads.php" method="post" name="myform" id="myform" class="ads_form">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="30"><div class="th-gap">选择</div></th>
		<th width="15%"><div class="th-gap">广告类别</div></th>
		<th width="15%"><div class="th-gap">图片描述</div></th>
		<th width="135"><div class="th-gap">图片预览</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="20"><div class="th-gap">状态</div></th>
		<th width="18%"><div class="th-gap">URL</div></th>
		<th width="80"><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $ads as $volist}-->
	  <tr onMouseOver="overColor(this)" onMouseOut="outColor(this)">
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.adsid}-->" onclick="checkItem(this, 'chkAll')" /></td>
		<td align="center"><!--{$volist.zonename}--></td>
		<td align="left"><!--{$volist.adsname}--></td>
		<td align="center"><a href="../<!--{$volist.uploadfiles}-->" target="_blank"><img src="../<!--{$volist.uploadfiles}-->" width="135" height="68" border="0" /></a></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center">
		<!--{if $volist.flag==0}-->
			<input type="hidden" id="attr_flag<!--{$volist.adsid}-->" value="flagopen" />
			<img id="flag<!--{$volist.adsid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.adsid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_flag<!--{$volist.adsid}-->" value="flagclose" />
			<img id="flag<!--{$volist.adsid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('flag','<!--{$volist.adsid}-->');" style="cursor:pointer;" />	
		<!--{/if}-->
        </td>
		<td><!--{$volist.url}--></td>
		<td align="center"><a href="xycms_ads.php?action=edit&id=<!--{$volist.adsid}-->&szoneid=<!--{$volist.zoneid}-->" class="icon-edit">编辑</a>&nbsp;&nbsp;<a href="xycms_ads.php?action=del&id[]=<!--{$volist.adsid}-->" onclick="{if(confirm('确定要删除该信息?')){return true;} return false;}" class="icon-del">删除</a></td>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>添加广告图片</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_ads.php" class="btn-general">返回列表</a>添加广告图片</h3>
    <form name="myform" id="myform" method="post" action="xycms_ads.php" class="ads_form" onsubmit='return checkform();'>
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="70">广告标签 <span class='f_red'>*</span></th>
		<td><!--{$adszone_select}--> <span id="dzoneid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>图片描述 <span class="f_red">*</span> </th>
		<td><input type="text" name="adsname" id="adsname" class="input-txt" /> <span id='dadsname' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>上传图片 <span class="f_red">*</span> </th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" />
		  <img class='upload_img' /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=banner&is_thumb=2'></iframe>			
		</td>
	  </tr>
	  <tr>
		<th>图片排序 </th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$orders}-->" />  <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>链接地址 </th>
		<td><input type="text" name="url" id="url" class="input-txt" value="" />  <span id='durl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>备注说明</th>
		<td><textarea name="content" id="content" style='width:60%;height:65px;display:;overflow:auto;'></textarea>  <span id='dintro' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th></th>
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
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>编辑广告图片</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="xycms_ads.php?<!--{$comeurl}-->" class="btn-general">返回列表</a>编辑广告图片</h3>
    <form name="myform" id="myform" method="post" action="xycms_ads.php">
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="70">广告标签 <span class='f_red'>*</span></th>
		<td><!--{$adszone_select}--> <span id="dzoneid" class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>图片描述 <span class="f_red">*</span> </th>
		<td><input type="text" name="adsname" id="adsname" class="input-txt" value="<!--{$ads.adsname}-->" /> <span id='dadsname' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>上传图片 <span class="f_red">*</span> </th>
		<td>
		  <input type="hidden" name="uploadfiles" id="uploadfiles" value="<!--{$ads.uploadfiles}-->" />
		  <!--{if $ads.uploadfiles != ''}-->
		  	 <img class='upload_img' src="../<!--{$ads.uploadfiles}-->" /><a href="javascript:volid(0)" class="pic_remove">删除</a>
		 <!--{else}-->
		     <img class='upload_img' /> 
		  <!--{/if}-->
		  <iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=banner&is_thumb=2'></iframe>
		  <script type="text/javascript">
		   var t = "<!--{$ads.uploadfiles}-->";
		    if(t != ''){
		    	$(".upload_img").css("display","block");
		    	$(".pic_remove").css("display","block");
		    	$("#iframe_t").css("display","none");
		    }
		  </script>	
		</td>
	  </tr>
	  <tr>
		<th>图片排序 </th>
		<td><input type="text" name="orders" id="orders" class="input-s" value="<!--{$ads.orders}-->" />  <span id='dorders' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>链接地址 </th>
		<td><input type="text" name="url" id="url" class="input-txt" value="<!--{$ads.url}-->" />  <span id='durl' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th>状态设置 </th>
		<td><!--{$flag_checkbox}--></td>
	  </tr>
	  <tr>
		<th>备注说明</th>
		<td><textarea name="content" id="content" style='width:60%;height:65px;display:;overflow:auto;'><!--{$ads.content}--></textarea>  <span id='dintro' class='f_red'></span></td>
	  </tr>
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->
<script type="text/javascript">
 $('.button').click(function(){
	 if($("#uploadfiles").val() == ''){
		 alert("图片不允许为空，请上传图片！");
		 return false;
	 }
 });
</script>
</body>

</html>