<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>站点设置</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
<script src="js/datepicker/WdatePicker.js"></script>
</head>
<body>
<!--{if $action == ''}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置</p></div>
  <div class="main-cont">
	<div class="set-area">
	  <form name="myform" method="post" action="xycms_task.php">
	  	<input type="hidden" name="lastUpdate" value="<!--{$taskConfig.lastUpdate}-->" />
		<table cellpadding='3' cellspacing='3' class='tab'>
			  <tr>
				<td class='hback_1' width="8%">名称</td>
				<td class='hback'><input name="title" class="input-txt input1" type="text" value="<!--{$taskConfig.title}-->" /></td>
			  </tr>
			  <tr>
				<td class='hback_1'>开始时间</td>
				<td><input name="start_time" onclick="WdatePicker()" class="input-txt input1 Wdate" type="text" value="<!--{$taskConfig.start_time}-->" /></td>
			  </tr>
			  <tr>
				<td class='hback_1'>结束时间</td>
				<td>
				<input name="end_time" onclick="WdatePicker()" class="input-txt input1 Wdate" type="text" value="<!--{$taskConfig.end_time}-->" />
				<label class="tip">* 为空表示结束时间不受限制</label>
				</td>
			  </tr>
			  <tr>
				<td class='hback_1'>应用的分类</td>
				<td><!--{$taskConfig.cate_select}--></td>
			  </tr>
			  <tr>
				<td class='hback_1'>最短时间间隔</td>
				<td><input name="interval_time" class="input-txt input1" type="text" value="<!--{$taskConfig.interval_time}-->" />小时</td>
			  </tr>
			  <tr>
				<td class='hback_1'>每次添加个数</td>
				<td><input name="rate_count" class="input-txt input1" type="text" value="<!--{$taskConfig.rate_count}-->" /></td>
			  </tr>  
			  <tr>
				<td class='hback_1'>状态</td>
				<td><input type="checkbox" name="flag" value="1"<!--{$taskConfig.flag}--> /></td>
			  </tr>
			  <tr>
				<td class='hback_none'></td>
				<td class='hback_none'><input type="submit" name="dosubmit" class="button" value="更新保存" /></td>
			  </tr>
		</table>
	 </form>
	</div>    
  </div>
</div>


<!--{elseif $action == 'config'}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;&gt;</span>站点设置</p></div>
  <div class="main-cont">
	<h3 class="title">站点设置</h3>
    <form name="myform" method="post" action="xycms_setting.php">
    <input type="hidden" name="action" value="saveconfig" />
	<table cellpadding='5' cellspacing='5' class='tab'> 	 	
	  <tr>
	   <td class='hback_1' width="150">3G手机绑定：</td> 
	   <td class="hback"><input name="tel" id="tel" class="input-txt" type="text" value="<!--{$config.tel}-->" /><span>请输入11位手机号码！</span></td>
	  </tr>	 	  	  	 	
	  <tr>
	   <td class='hback_1'>留言到手机：</td> 
		<td class='hback_none'>
		留言是否发布到手机：
		<input type="checkbox" name="message_tel" id="m_tle" value="1" <!--{if $config.message_tel==1}-->checked="checked"<!--{/if}--> />
		</td>
	  </tr>
	  <tr>
	   <td class='hback_1'>默认缩略图大小：</td> 
	   <td class='hback'>宽：<input type="text" name="thumbwidth" id="thumbwidth" size="5" value="<!--{$config.thumbwidth}-->" /> 像素（px） ， 高：<input type="text" name="thumbheight" id="thumbheight" size="5" value="<!--{$config.thumbheight}-->" /> 像素（px）</td>
	  </tr>	  
	  <tr>
	   <td class='hback_1'>水印设置：</td> 
		<td class="hback"><input type="radio" name="watermarkflag" value="1"<!--{if $config.watermarkflag==1}--> checked<!--{/if}--> />是，<input type="radio" name="watermarkflag" value="0"<!--{if $config.watermarkflag==0}--> checked<!--{/if}--> />否</td>
	  </tr>	  
	  <tr>
	   <td class='hback_1'>水印图片地址：</td> 
		<td class="hback"><input type="text" name="watermarkfile" id="watermarkfile" size="45" value="<!--{$config.watermarkfile}-->" /> 只支持JPG/GIF/PNG格式，推荐用透明的png图片 </td>
	  </tr>	  	  	   	  	  	  	   	  	   	  	  	  	  
	  <tr>
		<td></td>
		<td class='hback_none'><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>	  
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>

<!--{else}-->
暂无信息
<!--{/if}-->
</body>
</html>
