function myfun{
    ;(function(){
        var oClock1 = document.querySelector('.clock1');
        var oH = document.querySelector('.h');
        var oM = document.querySelector('.m');
        var oS = document.querySelector('.s');
        for(var i=0;i<60;i++){
            var oSpan = document.createElement('span');
            oSpan.style.transform='rotate('+i*6+'deg)';
            oSpan.inner='<em></em>';
            oClock1.appendChild(oSpan);
            var oEm = document.createElement('em');
            if(i%5==0){
                oSpan.style.height='20px';
                oSpan.style.background='#63FF2D';
                oEm.style.transform='rotate('+-(i*6)+'deg)';
                oEm.innerHTML=(i/5||12)
            }
            oSpan.appendChild(oEm);
        }
        function clock(){
            var oDate = new Date();
            var h = oDate.getHours();
            var m = oDate.getMinutes();
            var s = oDate.getSeconds();
            var ms = oDate.getMilliseconds();
            oH.style.transform='rotate('+(h/12*30+m/60*30)+'deg)';
            oM.style.transform='rotate('+(m*6+s/60*6)+'deg)';
            oS.style.transform='rotate('+(s*6+ms/1000*6)+'deg)';
        }
        clock();
        timer0=setInterval(clock,1);
    })();
}
window.onload=myfun;