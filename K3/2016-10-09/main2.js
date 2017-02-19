/*
** @Author 		Eric
** @Date 		2016-10-09
** @Copy 		@Zhinengshe
** @Licent 		MIT
** @Desc 		This is the entrance to the site.
*/
var WEB = {};
//Common interface
WEB.util = {};
//Public effect
WEB.effect = {};


WEB.util = {
	/*
	** @getById 		Obtain an element by ID
	** @params
	** 					[String]
	** @return
	** 					[Element]
	*/
	getById:function(id){
		return document.getElementById(id);
	},
	/*
	** @getByTag 		Get a set of elements by tag name
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












