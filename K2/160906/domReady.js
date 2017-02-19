/**
 * Created by Administrator on 2016/9/6.
 */
function domReady(fn){
    if(document.addEventListener){
        document.addEventListener('DOMContentLoaded',function(){
            fn&&fn();//处理事情
        },false)
    }else{
        document.onreadystatechange=function(){
            if(document.readyState=='complete'){
                fn&&fn();//处理事情
            }
        };
    }
}