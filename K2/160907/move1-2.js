/**
 * Created by Administrator on 2016/9/7.
 */
function getStyle(obj,name){
    return obj.currentStyle?obj.currentStyle[name]:getComputedStyle(obj,false)[name];
}
function move(obj,json,duration,complete){
    clearInterval(obj.timer);
    var start={};
    var dis={}
    for(var name in json){
        start[name] = parseFloat(getStyle(obj,name));
        dis[name] = json[name]-start[name];
    }
    //总次数
    var count = Math.floor(duration/30);
    //当前走了几次
    var n =0;
    obj.timer=setInterval(function(){
        n++;
        for(var name in json){
            if(name=='opacity'){
                obj.style.opacity=start[name]+n*dis[name]/count;
                obj.style.filter='alpha(opacity:'+(start[name]+n*dis[name]/count)*100+')';
            }else{
                obj.style[name]=start[name]+n*dis[name]/count+'px';
            }
        }
        if(n==count){
//                        alert('走完了');
            clearInterval(obj.timer);
            complete && complete();
        }
    },30);
}