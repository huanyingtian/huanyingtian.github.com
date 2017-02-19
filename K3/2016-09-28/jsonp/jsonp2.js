'use strict'
function json2url(json){
	var arr = [];
	for(var name in json){
		arr.push(name+'='+json[name]);
	}
	return arr.join('&');
}
/*
** @jsonp 				jsonp跨域交互
** @params 		
** 						[object]
*/
function jsonp(json){
	//参数初始值
	json = json||{};
	if(!json.url)return;
	//回调名字
	json.cbName = json.cbName||'cb';
	//超时时间(ms)
	json.timeout =json.timeout||15000;
	//提交数据
	json.data = json.data||{};
	//回调函数的名字(解决了缓存问题)
	json.data[json.cbName] = 'show'+Math.random();
	//把回调函数名字中的.去掉。
	json.data[json.cbName] = json.data[json.cbName].replace('.','');
	//网络超时
	json.timer = setTimeout(function(){
		window[json.data[json.cbName]] = function(){
			oHead.removeChild(oS);
			json.error&&json.error('亲，网络不给力');
		};
	},json.timeout);
	//定义回调函数(全局的)
	window[json.data[json.cbName]] = function(result){
		//把网络超时干掉
		clearTimeout(json.timer);
		//需要把script删除
		oHead.removeChild(oS);
		//执行成功回调函数
		json.success&&json.success(result);
	};
	//获取head标签。
	var oHead = document.getElementsByTagName('head')[0];
	//动态创建script
	var oS = document.createElement('script');
	//给script加src
	oS.src = json.url+'?'+json2url(json.data);
	//把script插入到head标签中
	oHead.appendChild(oS);
}