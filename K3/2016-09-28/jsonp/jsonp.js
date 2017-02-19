'use strict'
function json2url(json){
	var arr = [];
	for(var name in json){
		arr.push(name+'='+json[name]);
	}
	return arr.join('&');
}
function jsonp(json){
	json = json||{};
	if(!json.url)return;
	json.cbName = json.cbName||'cb';
	json.timeout = json.timeout||15000;
	json.data = json.data||{};
	json.data[json.cbName] = 'show'+Math.random();
	json.data[json.cbName] = json.data[json.cbName].replace('.','');
	json.timer = setTimeout(function(){
		window[json.data[json.cbName]]=function(){
			oHead.removeChild(oS);
			json.error&&json.error('网络超时');
		};
	},json.timeout);
	window[json.data[json.cbName]] = function(result){
		clearTimeout(json.timer);
		oHead.removeChild(oS);
		json.error&&json.success(result);
	};
	var oHead = document.getElementsByTagName('head')[0];
	var oS = document.createElement('script');
	oS.src = json.url+'?'+json2url(json.data);
	oHead.appendChild(oS);
}