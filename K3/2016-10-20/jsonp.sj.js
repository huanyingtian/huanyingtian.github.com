function json2url(json){
	var arr = [];
	for(var name in json){
		arr.push(name+'='+encodeURIComponent(json[name]));
	}
	return arr.join('&');
}
function jsonp(json){
	json = json||{};
	if(!json.url)return;
	json.cbName = json.cbName||'cb';
	json.data = json.data||{};
	json.data[json.cbName] = 'show'+Math.random();
	json.data[json.cbName] = json.data[json.cbName].replace('.','');
	window[json.data[json.cbName]] = function(res){
		oH.removeChild(oS);
		json.success&&json.success(res);
	};
	
	var oH = document.getElementsByTagName('head')[0];
	var oS = document.createElement('script');
	oS.src = json.url+'?'+json2url(json.data);
	oH.appendChild(oS);
}












