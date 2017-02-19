'use strict'
function removeClass(obj,sClass){
	//判断有没有class，如果有才需要操作。
	if(obj.className){
		//定义个正则
		var re = new RegExp('\\b'+sClass+'\\b','g');
		obj.className = obj.className.replace(re,'').replace(/\s+/g,' ').replace(/^\s+|\s+$/g,'');
		if(obj.className==''){
			obj.removeAttribute('class');
		}
	}
}

function addClass(obj,sClass){
	if(obj.className){
		var re = new RegExp('\\b'+sClass+'\\b','g');
		if(obj.className.search(re)==-1){
			obj.className += ' '+sClass;
		}
	}else{
		obj.className = sClass;
	}
}

function getByClass(obj,sClass){
	if(obj.getElementsByClassName){
		return obj.getElementsByClassName(sClass);
	}else{
		var aResult = [];
		var aEle = obj.getElementsByTagName('*');
		var re = new RegExp('\\b'+sClass+'\\b','g');
		for(var i=0;i<aEle.length;i++){
			if(aEle[i].className.search(re)!=-1){
				aResult.push(aEle[i]);
			}
		}
		return aResult;
	}
}

















