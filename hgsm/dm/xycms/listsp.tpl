<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>概况分类</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>碎片管理</p></div>
  <div class="main-cont">
    <h3 class="title"><a href="listsp.php?action=add" class="btn-general">添加碎片</a>碎片管理</h3>
	<form action="listsp.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="del" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table" align="center">
	  <thead class="tb-tit-bg">
	  <tr>
	    <th width="5%"><div class="th-gap">选择</div></th>
		<th width="12%"><div class="th-gap">碎片名称</div></th>
		<th width="12%"><div class="th-gap">调用标签</div></th>
		<th width="11%"><div class="th-gap">类型</div></th>
		<th width="12%"><div class="th-gap">调用分类</div></th>
		<th width="8%"><div class="th-gap">推荐</div></th>
		<th width="8%"><div class="th-gap">新品</div></th>
		<th width="8%"><div class="th-gap">排序</div></th>
		<th width="8%"><div class="th-gap">数目</div></th>
		<th><div class="th-gap">操作</div></th>
	  </tr>
	  </thead>
	  <tfoot class="tb-foot-bg"></tfoot>
	  <!--{foreach $splist as $volist}-->
	  <tr>
	    <td align="center"><input name="id[]" type="checkbox" value="<!--{$volist.id}-->" /></td>
		<td align="center"><!--{$volist.spname}--></td>
		<td align="center"><!--{$volist.splabel}--></td>
		<td align="center"><!--{$volist.np}--></td>
		<td align="center"><!--{$volist.sp_cate}--></td>
		<td align="center"><!--{$volist.recommend}--></td>
		<td align="center"><!--{$volist.isnew}--></td>
		<td align="center"><!--{$volist.orders}--></td>
		<td align="center"><!--{$volist.num}--></td>
		<td align="center"><a href="listsp.php?action=edit&id=<!--{$volist.id}-->" class="icon-set">修改</a>&nbsp;&nbsp;<!--{if $uc_adminname == 'master'}--><a href="listsp.php?action=del&id[]=<!--{$volist.id}-->" class="icon-del">删除</a><!--{/if}--></td>
	  </tr>
	  <!--{foreachelse}-->
      <tr>
	    <td colspan="10" align="center">暂无碎片</td>
	  </tr>
	  <!--{/foreach}-->
	  <!--{if $total>0}-->
	  <tr>
		<td align="center"><input name="chkAll" type="checkbox" id="chkAll" value="checkbox" /></td>
		<td class="hback" colspan="9"><input class="button" name="btn_del" type="button" value="删 除" onclick="{if(confirm('确定删除选定碎片吗!?')){$('#myform').submit();return true;}return false;}" class="button" />&nbsp;&nbsp;共[ <b><!--{$total}--></b> ]条记录</td>
	  </tr>
	  <!--{/if}-->
	</table>
	</form>
  </div>
</div>
<!--{/if}-->

<!--{if $action eq "add"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>添加碎片</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="listsp.php" class="btn-general">返回碎片列表</a>添加碎片</h3>
    <form name="myform" id="myform" method="post" action="listsp.php">
    <input type="hidden" name="action" value="saveadd" />
	<table class='table_form'>
	  <tr>
		<th width="100">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="spname" id="spname" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>调用标签：<span class='f_red'>*</span></th>
		<td><input type="text" name="splabel" id="splabel" class="input-txt" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>产品/新闻：<span class='f_red'></span></th>
		<td>
		  <input type="radio" name="np" value="1" checked="checked" class="np" />产品中心
		  <input type="radio" name="np" value="2" class="np" />新闻中心
		  <input type="radio" name="np" value="3" class="np" />案例中心
		</td>
	  </tr>
	  <tr>
		<th>产品或新闻分类：</th>
		<td><span id="np_cate"><!--{$cate_select_p}--></span></td>
	  </tr>
	  <tr>
	   <th>是否推荐：</th>
	   <td><input type='checkbox' id='recommend' name='recommend' value='1' />推荐</td>
	  </tr>
	  <tr class="disable">
	   <th>是否最新产品：</th>
	   <td><input type='checkbox' id='isnew' name='isnew' value='1' />新品</td>
	  </tr>
	  <tr>
	   <th>排序：</th>
	   <td>
	   	 <input type="radio" name="orders" value="0" checked="checked" />降序
	     <input type="radio" name="orders" value="1" />升序	    
	   </td>
	  </tr>
	  <tr>
	   <th>数目：</th>
	   <td><input type='text' id='num' name='num' /></td>
	  </tr>
	  <tr>
		<th>碎片说明： </th>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'></textarea></td>
	  </tr>
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
  <script type="text/javascript">
  $(".np").click(function()
  {
  	var val=$(this).val();
  	if(val==2 || val==3){
  		$(".disable").addClass("hide");
  	}else{
  		$(".disable").removeClass("hide");
  	}
  });
  </script>
</div>
<!--{/if}-->

<!--{if $action eq "edit"}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：内容中心<span>&gt;</span>编辑碎片</p></div>
  <div class="main-cont">
	<h3 class="title"><a href="listsp.php" class="btn-general">返回碎片列表</a>编辑碎片</h3>
    <form name="myform" id="myform" method="post" action="listsp.php">
    <input type="hidden" name="action" value="saveedit" />
	<input type="hidden" name="id" value="<!--{$id}-->" />
	<table class='table_form'>
	  <tr>
		<th width="100">分类名称：<span class='f_red'>*</span></th>
		<td><input type="text" name="spname" id="spname" class="input-txt" value="<!--{$sp_edit.spname}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>调用标签：<span class='f_red'>*</span></th>
		<td><input type="text" name="splabel" id="splabel" class="input-txt" <!--{if $uc_adminname == 'admin'}-->style="cursor:not-allowed;" readonly="readonly"<!--{/if}--> value="<!--{$sp_edit.splabel}-->" /> <span class='f_red' id="dcatename"></span></td>
	  </tr>
	  <tr>
		<th>产品/新闻：<span class='f_red'></span></th>
		<td>
		  <input type="radio" name="np" value="1" class="np" /> 产品中心
		  <input type="radio" name="np" value="2" class="np" /> 新闻中心
		  <input type="radio" name="np" value="3" class="np" /> 案例中心
		</td>
	  </tr>
	  <tr>
		<th>产品或新闻分类</th>
		<td><span id="np_cate"><!--{$cate_select}--></span></td>
	  </tr>
	  <tr>
	   <th>是否推荐：</th>
	   <td><input type='checkbox' id='recommend' name='recommend' value='1' /> 推荐</td>
	  </tr>
	  <tr class="disable">
	   <th>是否最新产品：</th>
	   <td><input type='checkbox' id='isnew' name='isnew' value='1' /> 新品</td>
	  </tr>
	  <tr>
	   <th>排序：</th>
	   <td>
	   	 <input type="radio" name="orders" value="0"<!--{if $sp_edit.orders == 0}-->checked="checked"<!--{/if}--> /> 降序
	     <input type="radio" name="orders" value="1"<!--{if $sp_edit.orders == 1}-->checked="checked"<!--{/if}--> /> 升序	    
	   </td>
	  </tr>
	  <tr>
	   <th>数目：</th>
	   <td><input type='text' id='num' name='num' value="<!--{$sp_edit.num}-->" /></td>
	  </tr>
	  <tr>
		<th>碎片说明： </th>
		<td><textarea name="intro" id="intro" style='width:60%;height:65px;overflow:auto;color:#444444;'><!--{$sp_edit.intro}--></textarea></td>
	  </tr>
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="添加保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
<script type="text/javascript">      
      //产品推荐和新闻的状态判断
	 var np = <!--{$sp_edit.np}--> - 1;
     $(".np").eq(np).attr("checked","checked");
     if(np == 2){
     	$(".disable").addClass("hide");
     }
     var recommend = <!--{$sp_edit.recommend}-->;
     var isnew     = <!--{$sp_edit.isnew}-->;
     if(recommend){
    	 $("#recommend").attr("checked","checked");
     }
     if(isnew){
    	 $("#isnew").attr("checked","checked");
     }
     var npvalue=$(".np:checked").val();
     // alert(npvalue);
     if(npvalue==2) 
     {
        $(".disable").addClass("hide");
     }
	  $(".np").click(function()
	  {
	  	var val=$(this).val();
	  	if(val==2 || val==3){
	  		$(".disable").addClass("hide");
	  	}else{
	  		$(".disable").removeClass("hide");
	  	}
	  });
</script>  
</div>
<!--{/if}-->
<script type="text/javascript">

//产品和新闻的Ajax切换      
$(".np").change(function(){
	  var np = $(this);
	  $.ajax({
		  type: "GET",
		  url: "listsp.php",
		  dataType: "html",
		  data: {"action":"add","np":np.val()},
		  success: function(data) { 
			  if(data){
				  $("#np_cate").html(data);
			  }else{
				  alert("选择类型失败！");
			  }
		  }
	  });	  
});
//推荐和新闻部可以同时选择
$("#recommend").click(function(){
	 if(this.checked){
		 $("#isnew").attr("checked",false);
	 }
});
$("#isnew").click(function(){
	 if(this.checked){
		 $("#recommend").attr("checked",false);
	 }
});  

</script>
</body>
</html>
