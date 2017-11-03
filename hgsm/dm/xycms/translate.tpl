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
.item{padding-left:30px;}
.item input,.item label,.item span{float:left;margin-right:8px;margin-left:10px;_display:inline;}
.current_color{width:40px;float:left;height:28px;line-height:28px;display:block;}
.itemtitle #color {height:26px;line-height:26px;width:90px;}
.itemtitle{position:relative;}
#kk{position:absolute;left:520px;top:0;height:28px;line-height:28px;width:80px;text-decoration: none;background:#136ec2;text-align:center;
color:#fff;}
#kk:hover{text-decoration:none;background:#e33b3d;}
.sequence{width:230px;position:absolute;right:30px;top:0;height:28px;line-height: 28px;}
.sequence a{background:#136ec2;text-align:center;color:#fff;height:28px;line-height: 28px;width:60px;margin-left:9px;display:inline-block;}
.sequence a:visited{text-decoration:none;color:#fff;background:#136ec2;}
.sequence a:hover{text-decoration:none;background:#e33b3d;}
</style>
</head>
<body>
<!--{if $action eq ""}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>语言版本</p></div>
  <div class="main-cont">
    <h3 class="title">语言版本&nbsp;&nbsp;&nbsp;&nbsp;<label><input name="chkAll" type="checkbox" id="chkAll" onclick="checkAll(this, 'name[]')" value="checkbox" class="checks" />&nbsp;&nbsp;&nbsp;全选</label></h3>
	<form action="xycms_translate.php" method="post" name="myform" id="myform" style="margin:0">
	<input type="hidden" name="action" id="action" value="saveedit" />
	<ul class="translate">
		<!--{foreach $tran_arr as $volist}-->
		<li>
			<label><input type="checkbox" name="name[]" class="translate-check" value="<!--{$volist.en}-->" <!--{if $volist.check==1}-->checked="checked"<!--{/if}--> />  <!--{$volist.cn}--></label>
		</li>
		<!--{/foreach}-->
	</ul>
	<div class="translate-sub"><input type="submit" name="btn_save" class="button" value="更新保存" /></div>
	</form>
  </div>
</div>
<!--{/if}-->

</body>
</html>