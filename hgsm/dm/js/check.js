//表单验证
function checkform(){	
	var cate  = $("#cid");
	var title = $("#title");
	var word  = $("#word");
	var catename = $("#catename");
	// var editor = new UE.Editor();
    var ue = UE.getEditor('container',{
     toolbars: [["undo","redo","|","bold","italic","underline","strikethrough","|","fontsize","forecolor","backcolor","|","removeformat","|","selectall","cleardoc","source","|","unlink","link","|","insertimage"]],wordCount:false
    });
    if(ue.queryCommandState('source')==1)
    {
    	ue.execCommand('source');
    }
	switch(''){
		case cate.val():
			alert('请选择分类');
			cate.focus();
			return false;
			break;
		case title.val():
			alert('请填写名称！');
			title.focus();
			return false;
			break;
		case catename.val():
			alert('分类名称不能为空！');
			catename.focus();
			return false;
			break;
		case word.val():
			alert('自定义目录不能为空！');
			word.focus();
			return false;
			break;
		default:
			break;
	}	
	return true;
}