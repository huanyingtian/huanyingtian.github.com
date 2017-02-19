function setCookie(name,val,iDay){
    if(iDay){
        var oDate = new Date();
        oDate.setDate(oDate.getDate()+iDay);
        oDate.setHours(0,0,0,0);
        document.cookie=name+'='+val+';path=/;expires'+oDate;
    }
}

function getCookie(name ){
    var arr = document.cookie.split('; ');
    for(var i=0;i<arr.length;i++){
        var arr2=arr[i].split('=');
        if(name==arr2(0)){
            alert(arr2[1]);
        }
    }
}
//一个功能就是一个文件
//1.加快页面的加载速度
//2.避免命名冲突
//3.便于维护

function removeCookie(name){
    setCookie(naem,'1111',-1);
}