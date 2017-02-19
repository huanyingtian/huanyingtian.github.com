function setCookie(name,value,iDay){
	if(iDay){
		var oDate = new Date();
		oDate.setDate(oDate.getDate()+iDay);
		oDate.setHours(0,0,0,0);
		document.cookie = name+'='+value+'; PATH=/; EXPIRES='+oDate.toGMTString();//IE低版本下的时间与高版本的时间不一样，toGMTString()是为了改变日期格式，使日期格式与高版本一样
	}else{
		document.cookie = name+'='+value+'; PATH=/';
	}
}
function getCookie(name){
	var arr = document.cookie.split('; ');
	for(var i=0;i<arr.length;i++){
		var arr2 = arr[i].split('=');
		if(arr2[0]==name){
			return arr2[1];
		}
	}
}
function removeCookie(name){
	setCookie(name,1,-5);
}
























