function addEvent(obj,sEv,fn){
    if(obj.addEventListener){
        obj.addEventListener(sEv,fn,true);
    }else{
        obj.attachEvent('on'+sEv,fn);
    }
}