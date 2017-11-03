<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>TAGS</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<style>
.item{
    background: #fafafa none repeat scroll 0 0;
    border: 1px dashed #ddd;
    margin: 0 0 15px;
    padding: 10px 15px;
}
.item input,.item label,.item span{float:left;margin-right:8px;margin-left:10px;_display:inline;}
.current_color{width:40px;float:left;height:32px;line-height:32px;display:block;border-radius: 3px;}
.itemtitle #color {height:30px;line-height:30px;width:90px;padding-left: 6px;}
.itemtitle{position:relative;}
#kk{position:absolute;left:520px;top:10px;height:32px;line-height:32px;width:80px;text-decoration: none;background:#2086ee;text-align:center;
color:#fff;border-radius: 3px;}
#kk:hover{text-decoration:none;background:#f90;}
.sequence{width:230px;position:absolute;right:30px;top:10px;height:32px;line-height: 32px;}
.sequence a{background:#2086ee;text-align:center;color:#fff;height:32px;line-height: 32px;width:60px;margin-left:9px;display:inline-block;border-radius: 3px;}
.sequence a:visited{text-decoration:none;color:#fff;background:#2086ee;}
.sequence a:hover{text-decoration:none;background:#f90;}
</style>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：其他扩展<span>&gt;</span>关键词</p></div>
  <div class="main-cont">
	<div class="itemtitle">
		<form method="post" id="color_form" action="xycms_tag.php" >
        	<input type="hidden" name="action" id="action" value="savecolor" />
	    	<div class="item">&nbsp;&nbsp;
				<label>关键词替换文本颜色：</label><input type="text" id="color" name="color" size="10" class="input" value="<!--{$color}-->" />&nbsp;&nbsp;&nbsp;
				<input type="submit" class="button_s" value="保存颜色" />
       			<label>当前颜色为：</label><i class="current_color" style="background-color:#<!--{$color}-->"></i>
	 		</div>
	  	</form>
	    <a href="xycms_tag.php?action=update" id="kk">更新关键词</a>
	    <div class="sequence">
	    	<form method="get" id="orders" action="xycms_tag.php">
	    	<input type="hidden" name="spaceid" id="spaceid" />	
	    	关键词状态：
	    	<a href="javascript:void(0);">关闭</a>
	    	<a href="javascript:void(0);">开启</a>
	    	</form>
	    </div>
	    <script type="text/javascript">
	      	$(".sequence a").click(function(){
	      		var index=$(this).index()-1;
	      		$("#spaceid").val(index);
	      		$("#orders").submit();
	      	});
	    </script>
	</div>
	<form action="xycms_tag.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
		<th width="6%"><div class="th-gap">ID</div></th>
		<th width="20%"><div class="th-gap">关键词名称</div></th>
		<th width="10%"><div class="th-gap">打开方式</div></th>
		<th width="17%"><div class="th-gap">URL</div></th>
		<th width="6%"><div class="th-gap">设为关键词</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $tag as $volist}-->
	  <tr onmouseover="overColor(this)" onmouseout="outColor(this)">
        <td align="center"><!--{$volist.tagid}--></td>
		<td align="center"><!--{$volist.tag}--></td>
		<td align="center"><!--{if $volist.target==1}--><font color="green">本页</font><!--{else}--><font color="blue">新页面</font><!--{/if}--></td>
		<td align="left"><!--{$volist.url}--></td>
		<td align="center">
 		<!--{if $volist.enabled==0}-->
			<input type="hidden" id="attr_enabled<!--{$volist.tagid}-->" value="enabledopen" />
			<img id="enabled<!--{$volist.tagid}-->" src="xycms/images/no.gif" onclick="javascript:fetch_ajax('enabled','<!--{$volist.tagid}-->');" style="cursor:pointer;" />
		<!--{else}-->
			<input type="hidden" id="attr_enabled<!--{$volist.tagid}-->" value="enabledclose" />
			<img id="enabled<!--{$volist.tagid}-->" src="xycms/images/yes.gif" onclick="javascript:fetch_ajax('enabled','<!--{$volist.tagid}-->');" style="cursor:pointer;" />
		<!--{/if}-->       
        </td>
	  <!--{foreachelse}-->
	  </tr>
      <tr>
	    <td colspan="4" align="center">暂无信息</td>
	  </tr>
	  <!--{/foreach}-->
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

<script type="text/javascript">
function checkform() {
	var t = "";
	var v = "";
	t = "tag";
	v = $("#"+t).val();
	if(v=="") {
		dmsg("关键词名称不能为空", t);
		return false;
	}
    
	return true;
}
</script>

</body>
</html>