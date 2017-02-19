/**
 * Created by Administrator on 2016/9/6.
 */
function addEvent(obj,sEv,fn){
    if(obj.addEventListener){
        obj.addEventListener(sEv,fn,false);
    }else{
        obj.attachEvent('on'+sEv,fn);
    }
}
function addwheel(obj,fn){
    function wheel(ev){
        var oEvent = ev || event;
        var bDown =true;
        //if(oEvent.wheelDelta){
        //    //if(oEvent.wheelDelta<0){
        //    //    bDown =true;
        //    //}else{
        //    //    bDown =false;
        //    //};
        //    bDown=oEvent.wheelDelta<0;
        //}else{
        //    //if(oEvent.detail>0){
        //    //    bDown =true;
        //    //}else{
        //    //    bDown =false;
        //    //};
        //    bDown=oEvent.detail>0;
        //}
        bDown=oEvent.wheelDelta?oEvent.wheelDelta<0:oEvent.detail>0;
        //处理事情
        fn&&fn(bDown);
        oEvent.preventDefault && oEvent.preventDefault();
        return false;
    }
    if(window.navigator.userAgent.toLowerCase().indexOf('firefox')!=-1){
        obj.addEventListener('DOMMouseScroll',wheel,false);
    }else{
        //obj.onmousewheel=wheel;
        addEvent(obj,'mousewheel',wheel);
    }
}