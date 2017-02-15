;(function(win,doc){
    var rem = 20/375*doc.documentElement.clientWidth;
    doc.documentElement.style.fontSize=rem+'px';
    win.addEventListener('resize',function(){
        rem = 20/375*doc.documentElement.clientWidth;
        doc.documentElement.style.fontSize=rem+'px';
    },false)
})(window,document);
document.addEventListener('DOMContentLoaded',function(ev){

    //列表
    ;(function(){
        var oBtn = document.querySelector('header span');
        var oIndex = document.querySelector('section.index');
        var oN = document.querySelector('section.index span');
        oBtn.addEventListener('click',function(){
            oIndex.style.display='block';
        },false);
        oN.addEventListener('click',function(){
            oIndex.style.display='none';
        },false);
        var aBtn = document.querySelectorAll('section.index ul li.to');

        aBtn[1].addEventListener('click',function(ev){
            oIndex.style.display='none';
        },false);
    })();

    //video
    (function(){
        var oV = document.querySelector('section.yuan video');
        var oP = document.querySelector('section.yuan span.play');
        var n = 0;
        oP.addEventListener('click',function(){
            oV.controls=true;
            oV.play();
            oP.style.display='none';
        },false);
        oV.addEventListener('click',function(){
            n++;
            if(n>1){
                n=0;
            }
            if(n){
                oV.controls=true;
                oV.play();
                oP.style.display='none';
            }else{
                oV.controls=false;
                oV.pause();
                oP.style.display='block';
            }
        },false);
    })();

    //touch
    (function(){
        var oUl = document.querySelector('section.svg ul');
        var aLi = document.querySelectorAll('section.svg ul li');
        var x = 0;
        var oldx = 0;
        oUl.addEventListener('touchstart',function(ev){
            var oTouch=ev.targetTouches[0];
            if(x==-oUl.offsetWidth+oTouch.pageX)return;
            var downX = oTouch.pageX;
            var dix = downX - x;
            function fnMove(ev){
                var oTouch=ev.targetTouches[0];
                x = oTouch.pageX-dix;
                if(x>10){
                    x=10;
                };
                if(x<-1000){
                    x=-1000;
                };
                oUl.style.transform='translate('+x/40+'rem)'
            };
            function fnEnd(ev){
                var oTouch = ev.changedTouches[0];
                if(x>0){
                    x=0;
                };
                if(x<-900){
                    x=-900;
                };
                document.removeEventListener('touchmove',fnMove,false);
                document.removeEventListener('touchmove',fnEnd,false);
            };
            document.addEventListener('touchmove',fnMove,false);
            document.addEventListener('touchend',fnEnd,false);
        },false);
    })();
    ev.preventDefault();
},false);