function setCookie(name,value,day){
    //设置cookie=> doucment.cookie进行赋值
    if(day){
        var date = new Date();//获取时间
        date.setDate(date.getDate()+day);//设置时间
        document.cookie=name+'='+value+';path=/;expires='+date;//获取过期时间
    }else{
        document.cookie=name+'='+value+';path/';
    }
}
function　getCookie(name){
    var arr = document.cookie.split('; ');
    for (var i=0;i<arr.length;i++){
        var arr2 = arr[i].split('=');
        if(arr2[0]==name){
            return arr2[1];
        }
    }
    return '';
}
function removeCookie(name){
    setCookie(name,','-1);
}