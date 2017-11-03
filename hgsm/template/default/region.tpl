<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><!--{$keyword}--></title>
<!--{if $config.pcico eq ''}--><!--{else}-->
<link rel="shortcut icon" type="image/x-icon" href="<!--{$url_index}--><!--{$config.pcico}-->" />
<!--{/if}-->
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/base.css" />
<link rel="stylesheet" type="text/css" href="<!--{$url_index}-->data/user.css?9.2" />
<style type="text/css">
.clearfix:after{content: ".";display: block;height: 0;clear: both;overflow: hidden;visibility: hidden;}
.clearfix{zoom:1}
.region{margin-top:10px;border:1px solid #e0e1dc;}
.region h3{background:#eee;line-height:30px;padding-left:10px;position:relative;}
.region .item{padding:10px;line-height:28px;display:block;}
.region .item a{padding-left:15px;padding-right:15px;float:left;}
.region .item a:hover{text-decoration:none;background:#3480ce;color:#fff;}
.more_region{position:absolute;right:10px;line-height:28px;top:0;font-weight:normal;}
#container{width:1000px;margin:0 auto;margin-top:10px;border:1px solid #f4f4f4;padding:10px;}
.hot{border-bottom:2px solid #eb2830;padding-bottom:8px;}
.hot li{float:left;margin-right:10px;margin-bottom:10px;}
.hot li a{display:block;line-height:32px;padding-left:16px;padding-right:16px;background:#f4f4f4;}
.hot li a:hover{text-decoration:none;background:#eb2830;color:#fff;}
.city_list{padding-top:10px;}
.item{padding:10px 0;line-height:24px;overflow:hidden;border-bottom:1px dashed #ddd;}
.item dt{float:left;font-family:arial;font-weight:bold;font-size:18px;width:35px;padding-left:25px;color:#444;display: table-cell;}
.item dd{margin:0 0 0 55px;padding-left:15px;border-left:1px dashed #b2b2b2;}
.item dd a{padding:1px 12px 1px 12px;white-space:nowrap;float:left;}
.item dd a:hover{text-decoration:none;background:#eb2830;color:#fff;}
#foot{width:1022px;margin:0 auto;text-align:center;margin-top:10px;line-height:24px;color:#666;border-top:2px solid #eb2830;
padding-top:10px;}
#foot a{color:#666;}
.return{position:relative;height:36px;padding:6px;width:1000px;margin:0 auto;text-align:left;font:bold 22px/42px "微软雅黑";color:#737372;}
.return a{position:absolute;right:10px;top:12px;height:36px;width:100px;text-align: center;display:block;background:#eb2830;color:#fff;line-height: 36px;font-size:12px;font-weight: bold;}
.return a:hover{text-decoration:none;background:#f39c11;color:#fff;}
</style>
</head>
<body>
<!-- 主体部分 -->
<div class="return">企业分站<a href="<!--{$url_index}-->">返回首页</a></div>
<div id="container">
	<div class="city_list">
	<!--{if !empty($region_arr)}-->
		<dl class="item clearfix" style="padding-top: 0;">
				<dt>主营区域</dt>
				<dd>
					<!--{foreach $region_arr as $key=> $list}-->
						<a href="<!--{$urlpath}--><!--{$list.en}-->.html" target="_blank"><!--{$list.name}--></a>
					<!--{/foreach}-->
				</dd>
		</dl>
	<!--{/if}-->
	<!--{foreach $region as $key=> $list}-->
	 	<!--{if !empty($list['list'])}-->
		<dl class="item clearfix">
				<dt><!--{$list.name}--></dt>
				<dd>
					<!--{foreach $list['list'] as $en => $name}-->
						<a href="<!--{$urlpath}--><!--{$en}-->.html" target="_blank"><!--{$name}--></a>
					<!--{/foreach}-->
				</dd>
		</dl>
		<!--{/if}-->
	 <!--{/foreach}-->
	</div>
</div>
<div id="foot">
<!--{$delimit_footerlink}-->
<div class="copyright">
<!--{$config.sitename}--> 
<a href="http://<!--{$urlpath}-->"><!--{$keyword1}--></a>
<a href="http://<!--{$urlpath}-->"><!--{$keyword2}--></a>
<a href="http://<!--{$urlpath}-->"><!--{$keyword3}--></a>
</div>
</div>

</body>
</html>