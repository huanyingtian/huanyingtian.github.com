<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>模板管理</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link media="all" type="text/css" rel="stylesheet" href="aceEditor/public/css/main.css">
<link media="all" type="text/css" rel="stylesheet" href="aceEditor/public/css/ui.easytree.css">
</head>
<script type='text/javascript' src='aceEditor/public/js/jquery-1.11.1.min.js'></script>
<script type='text/javascript' src="aceEditor/public/js/require.js"></script>
<body class="filemanager-body">
<style type="text/css">
#ace-editor {margin:0;position:absolute;top:5px;bottom:30px;left:0;right:0;}
</style>
<div id="wrap-main">
  <div id="conent-main" class="file-wrap">
	<div id="main-container">
		<pre id="ace-editor" data-url="<!--{$ajax_url}-->"><!--{$content}--></pre>
	</div>
  </div>
</div>
<script src="aceEditor/ace.js"></script>
<script src="aceEditor/ext-modelist.js"></script>
<script src="aceEditor/ext-language_tools.js"></script>
<script>
$(function(){
    var editor = ace.edit("ace-editor");
    editor.setTheme("ace/theme/monokai");
    editor.setShowPrintMargin(false);
    editor.setFontSize(16);
    editor.getSession().setUseWrapMode(true);
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: true
    });
    
    (function (){
	        var modelist = ace.require("ace/ext/modelist");
	        var filePath = "<!--{$filepath}-->";
	        var mode = modelist.getModeForPath(filePath).mode;
	        editor.session.setMode(mode);
	}());
	editor.commands.addCommand({
		name: 'saveFile',
		bindKey: {
			win: 'Ctrl-S',
			mac: 'Command-S',
			sender: 'editor|cli'
		},
		exec: function(env, args, request) {
			$('#f-save-btn', parent.document.body).click();
		}
	});
	$('#f-save-btn', parent.document.body).on('click', function() {
		var url     = $('#ace-editor').data('url');
		var content = editor.getValue();
		var load = "<img src='aceEditor/public/img/loading-1.gif'>";
		$('.save-status', parent.document.body).html(load).show();
		$.post(url,{content:content}, function(data) {
			var data = jQuery.parseJSON(data);
			if (data.success){
				$('.save-status', parent.document.body).addClass('save-success').html('保存成功');
			}else{
			    $('.save-status', parent.document.body).addClass('save-error').html('保存失败');
			}
				$('.save-status', parent.document.body).fadeOut(1600, function() {
				$(this).empty();
			});
		});
	});		
});
</script>

</body>
</html>
