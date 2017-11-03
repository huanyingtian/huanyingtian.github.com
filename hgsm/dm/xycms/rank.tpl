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
</head>
<body>

<div class="main-wrap">
  <div class="path"><p>当前位置：系统管理<span>&gt;</span>排名查询</p></div>
  <div class="main-cont">
    <h3 class="title">排名查询
    <span style="font-weight:normal;padding-left:15px;" class="rank_url">[ 当前域名：<label class="url"><!--{$url}--></label> ]</span>
    <input type="hidden" id="rankAllcount" value="<!--{$count}-->" />
    </h3>
    <h3 class="title" style="margin-bottom:0;">
      <span style="display:block;margin:0 auto;text-align:left;position:relative;" class="rank_menu clearfix">
    	<a href="javascript:void(0)" class="rank_btn rank" rel="baidu">百度排名</a>
    	<span id="more_title">更多网站关键词排名，请使用客户端查询</span>
    	<a href="http://www.cn86.cn" id="more_a" target="_blank">点击下载</a>
     </span>
    </h3> 
    <div class="keyword_list"><!--{$keywords}--></div>
    <div class="rank_tab">
    <div class="tab_list rank_baidu">
  	  <table border="0" cellpadding="0" cellspacing="0" class="table rank_list">
      	<tr class="thead">
      		<td colspan="2" align="center" height="32" style="background:#ecf5fb;font-size:14px;">
      			<span class="rank_type">排名结果</span>
      			<input type="hidden" value="0" class="rankAlreadyCount" />
      			<label class="rank_status"></label>
      			<label class="rankProgress"></label>
      		</td>
     	 </tr>
	 	 <tr class="thead">
	    	<th width="40%"><div class="th-gap">关键词</div></th>
			<th width="60%"><div class="th-gap">排名</div></th>
	  	</tr>
		</table>
	 </div>	
	</div>	
	
  </div>
</div>

<script type='text/javascript' src='js/rank_ajax.js'></script>
</body>
</html>
