<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>模板管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link media="all" type="text/css" rel="stylesheet" href="aceEditor/public/css/main.css">
<link media="all" type="text/css" rel="stylesheet" href="aceEditor/public/css/ui.easytree.css">

<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script src="aceEditor/public/js/jquery.easytree.js"></script>

</head>
<body class="filemanager-body">
<div id="wrap-main">
	<div class="main-top"><span>模板管理</span>
	<div class="file-info"></div>
	<div class="file-save">
		<label class="save-status"></label>
		<input type="button" value="保存" id="f-save-btn"></div>
    </div>
	<div id="conent-main" class="file-wrap">
		<div id="main-container" class="file-manager">
		<div id="file-explorer">
			<div id="file-tree"></div>
		</div>
		<div id="file-edit">
			<div class="tab-wrap-tpl">
				<ul class="tab-nav clearfix"></ul>
				<div class="tab-content"></div>
			</div>
		</div>
	</div>
		</div>
	</div>
<script>
	var getWindowSize = function() {
		return ["Height","Width"].map(function(name) {
		  return window["inner"+name] ||
			document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
		});
	}
	function TreeSize(){
		var size = getWindowSize();
		$('#file-explorer').height(size[0] - 38);
		$('.tab-content').height(size[0] - 73);
		//$('.tab-content').width(size[1] - 240);
	}
	$('#file-tree').easytree({ data: <!--{$array}--> });	
	TreeSize();
	// 模板文件编辑
	$('#file-explorer').on('click', 'a', function(e) {
		e.preventDefault();
		var url  = decodeURI(this.href);

		// 文件路径
		var path = url.split('/').pop().replace('-', '/');
		$('.file-info').html(path);

		// 判断是否已经加载
		var pane = $(".tab-content .tab-pane-tpl[data-path='"+path+"']");
		if (pane.length > 0) {
			$('.tab-nav > li').eq(pane.index()).click();
			return false;
		}

		// 判断宽度是否溢出
		var liWidth = 0;
		$('.tab-nav > li').each(function() {
			liWidth += $(this).outerWidth()+15;
		});

		if ($('#file-edit').width() < liWidth) {
			alert('您已经没有空间编辑模板了，请关闭后再编辑。');
			return false;
		}

		$('#file-edit .tab-wrap-tpl').show();

		var filename = $(this).text();

			// 右侧内容加载
		$('.tab-nav').append("<li>"+filename+"<a class='tab-remove'>x</a></li>");
		var index = $('.tab-nav > li').length;
		var content = "<div class='tab-pane-tpl' data-path='"+path+"'><iframe id='tp-content-" + index + "' src='" + url + "' width='100%' height='100%' frameborder='0' scrolling='yes'></iframe></div>";
		$('.tab-content').append(content);
		$('.tab-nav > li').eq(index-1).click();
		return false;
	});

	$('.tab-nav').on('click', '.tab-remove', function() {
		var index = $(this).parent('li').index();
		var ison  = $(this).parent('li').hasClass('on'); 

		// 如果边上还有选项卡，那么现实边上选项卡
		if (ison) {
			var NextCurrentIndex = index-1;
			if (NextCurrentIndex < 0) {
				NextCurrentIndex = 0;
			}
		}

		$(this).parent('li').remove();
		$('.tab-content .tab-pane-tpl').eq(index).remove();

		if ($('.tab-nav > li').length == 0) {
			$('#file-edit .tab-wrap-tpl').hide();
			$('.file-info').html('');
			return false;
		}

		// 设置当前选项卡
		$('.tab-nav > li').eq(NextCurrentIndex).click();
	});

	// 选项卡
	$('.tab-wrap-tpl > .tab-nav').on('click', 'li', function() {
		var index = $(this).index();
		$(this).addClass('on').siblings('li').removeClass('on');
		$(this).parent().siblings('.tab-content').children('.tab-pane-tpl').removeClass('on').eq(index).addClass('on');
		var path = $('.tab-content > .tab-pane-tpl').eq(index).data('path');
		$('.file-info').html(path);
	});		

	if(!+"\v1" && !document.querySelector) { 
		// for IE6 IE7
		document.body.onresize = TreeSize;
	} else { 
		window.onresize = TreeSize;
	}	
</script>


</body>
</html>
