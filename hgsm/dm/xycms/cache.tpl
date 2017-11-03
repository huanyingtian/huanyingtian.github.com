<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->">
<title>缓存管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
</head>
<body>
<!--{if $action == ''}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;&gt;</span>站点缓存优化</p></div>
  <div class="main-cont">
	<h3 class="title">站点缓存优化（如果网站不常更新，建议开启缓存，以提高站点访问速度）</h3>
    <form name="myform" method="post" action="cache.php">
    <input type="hidden" name="action" value="savecache" />
	<table cellpadding='5' cellspacing='5' class='tab'>
	  <tr>
		<td class="hback_none" width="10%">是否开启缓存： </td>
		<td class="hback" ><label><input type="radio" name="cachstatus" value="1"<!--{if $config.cachstatus==1}--> checked<!--{/if}--> /> 开启</label>，<label><input type="radio" name="cachstatus" value="0"<!--{if $config.cachstatus==0}--> checked<!--{/if}--> /> 关闭</label></td>
	  </tr>
	  <tr>
		<td class='hback_none'>缓存持续时间：</td>
		<td class='hback_none'><input type="text" name="cachtime" id="cachtime" size="10" value="<!--{$config.cachtime}-->" /> 分钟</td>
	  </tr>
	  <tr>
		<td class='hback_none'></td>
		<td class='hback_none cache'><input type="submit" name="btn_save" class="button" value="更新保存" /><span><a class="cache-clear" href="cache.php?action=clearcache">清除缓存</a></span></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<!--{/if}-->
</body>
</html>