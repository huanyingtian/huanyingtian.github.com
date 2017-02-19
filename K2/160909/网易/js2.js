/**
 * Created by Administrator on 2016/9/12.
 */
window.onload = function(){
    var oBtn  =document.getElementById('btn');
    var oH = document.documentElement.clientHeight;
    var timer = null;
    var lock = true;
    window.onscroll = function(){
        var oT = document.documentElement.scrollTop||document.body.scrollTop;
        if(oT>=oH){
            oBtn.style.display = 'block';
        }else{
            oBtn.style.display = 'none';
        }
        if(!lock){
            clearInterval(timer)
        }
        lock = false;
    };
    oBtn.onclick = function(){
        timer = setInterval(function(){
            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
            var count = Math.floor(-scrollTop/30);
            document.documentElement.scrollTop=document.body.scrollTop=scrollTop+count ;
            lock = true;
            if(scrollTop==0){
                clearInterval(timer);
            }
        },30);
    }
}
