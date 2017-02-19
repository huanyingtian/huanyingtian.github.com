'use strict'
function json2url(json){
	var arr = [];
	for(var name in json){
		arr.push(name+'='+encodeURIComponent(json[name]));
	}
	return arr.join('&');
}
function ajax(url,type,data,fnSucc,fnFaild){
	if(window.XMLHttpRequest){
		var oAjax = new XMLHttpRequest();
	}else{
		var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
	}
	switch(type.toLowerCase()){
		case 'get':
			oAjax.open('GET',url+'?'+json2url(data),true);
			oAjax.send();
			break;
		case 'post':
			oAjax.open('POST',url,true);
			oAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			oAjax.send(json2url(data));
			break;
	}
	oAjax.onreadystatechange = function(){
		if(oAjax.readyState==4){
			if(oAjax.status>=200&&oAjax.status<300||oAjax.status==304){
				fnSucc(oAjax.responseText);
			}else{
				fnFaild(oAjax.status);
			}
		}
	};
}