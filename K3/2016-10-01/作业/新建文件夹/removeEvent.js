function removeEvent(obj,sEv,fn){
    if(obj.removeEventListener){
        obj.removeEventListener(sEv,fn,false);
    }else{
        obj.detachEvent('on'+sEv,fn);
    }
}