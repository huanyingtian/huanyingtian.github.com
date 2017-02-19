function setCookie(name,value,day){
    if(day){
        var date = new Date();
        date.setDate(date.getDate()+day)
        document.cookie = name + '='+value+';path/;expires='+date;
    }else{
        document.cookie = name + '='+value;
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
    return '';
}
function removeCookie(name){
    setCookie(name,',',-1)
}