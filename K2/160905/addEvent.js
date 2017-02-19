/**
 * Created by Administrator on 2016/9/5.
 */
function addEvent(obj,sEv,fn){
    if(obj.addEventListener){
        obj.addEventListener(sEv,fn,true);
    }else{
        obj.attachEvent('on'+sEv,fn);
    }
}