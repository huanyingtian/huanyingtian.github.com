/*
** @Author 		文强
** @Date 		2016-10-09
** @Copy 		@智能社
** @Licent 		MIT
** @Desc 		这是整个网站的入口
*/
var WEB = {};
//公共接口
WEB.util = {};
//公共效果
WEB.effect = {};


WEB.util = {
	/*
	** @getById 		通过id获取一个元素
	** @params
	** 					[String]
	** @return
	** 					[Element]
	*/
	getById:function(id){
		return document.getElementById(id);
	},
	/*
	** @getByTag 		通过标签名获取一组元素
	** @params
	** 					[Element]
	** 					[String]
	** @return
	** 					[Array]
	*/
	getByTag:function(oParent,tagName){
		return oParent.getElementsByTagName(tagName);
	},
	addEvent:function(obj,sEv,fn){
		if(obj.addEventListener){
			obj.addEventListener(sEv,fn,false);
		}else{
			obj.attachEvent('on'+sEv,fn);
		}
	}
};
WEB.effect = {
	click2red:function(id){
		var obj = WEB.util.getById(id);
		WEB.util.addEvent(obj,'click',function(){
			obj.style.background = 'red';
		});
	}
};












