'use strict'
function json2url(json){
	var arr = [];
	for(var name in json){
		arr.push(name+'='+encodeURIComponent(json[name]));
	}
	return arr.join('&');
}
function ajax(json){
	json = json||{};
	if(!json.url)return;
	json.type = json.type||'get';
	json.timeout = json.timeout||10000;
	json.data = json.data||{};
	
	json.data.t = Math.random();
	
	if(window.XMLHttpRequest){
		var oAjax = new XMLHttpRequest();
	}else{
		var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
	}
	switch(json.type.toLowerCase()){
		case 'get':
			oAjax.open('GET',json.url+'?'+json2url(json.data),true);
			oAjax.send();
			break;
		case 'post':
			oAjax.open('POST',json.url,true);
			oAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			oAjax.send(json2url(json.data));
			break;
	}
	
	json.loading&&json.loading();
	
	json.timer = setTimeout(function(){
		oAjax.onreadystatechange = null;
		json.error('亲，网络不给力。已超时！！！呵呵');
	},json.timeout);
	
	oAjax.onreadystatechange = function(){
		if(oAjax.readyState==4){
			clearTimeout(json.timer);
			if(oAjax.status>=200&&oAjax.status<300||oAjax.status==304){
				
				json.success&&json.success(oAjax.responseText);
			}else{
				json.error&&json.error(oAjax.status);
			}
		}
	};
}





