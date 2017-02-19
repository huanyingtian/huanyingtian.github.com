//setCookie

function setCookie(name,val,iDay){
	
	var oDate=new Date();
	oDate.setDate(oDate.getDate()+iDay);
	oDate.setHours(0,0,0,0);
	
	document.cookie=name+'='+val+';path=/;expires='+oDate;
}

//getCookie
function getCookie(name){
	
	var arr=document.cookie.split('; ');
	
	for(var i=0; i<arr.length;i++){
		// [name=val,name=val,name=val]
		var arr2=arr[i].split('='); 
		//arr2=[name,val]
		if(name==arr2[0]){
			return arr2[1]	
		}
	}
}

//removeCookie
function removeCookie(name){
	setCookie(name,'111',-1);
}













