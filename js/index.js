;(function(win,doc){
    var rem = 20/375*doc.documentElement.clientWidth;
    doc.documentElement.style.fontSize=rem+'px';
    win.addEventListener('resize',function(){
        rem = 20/375*doc.documentElement.clientWidth;
        doc.documentElement.style.fontSize=rem+'px';
    },false);
})(window,document);
document.addEventListener('DOMContentLoaded',function(ev){
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
            };
            if(n){
                oV.controls=true;
                oV.play();
                oP.style.display='none';
            }else{
                oV.controls=false;
                oV.pause();
                oP.style.display='block';
            };
        },false);
    })();
    //touch
    (function(){
        var oUl = document.querySelector('section.svg ul');
        var aLi = document.querySelectorAll('section.svg ul li');
        var x = 0;
        oUl.addEventListener('touchstart',function(ev){
            var oTouch=ev.targetTouches[0];
            var dix = oTouch.pageX - x;
            function fnMove(ev){
                var oTouch=ev.targetTouches[0];
                x = oTouch.pageX-dix;
                /*if(x>0){
                 x=0;
                 };
                 if(x<-1000){
                 x=-1000;
                 };*/
                oUl.style.transform='translate('+x/40+'rem)'
            };
            function fnEnd(){
                document.removeEventListener('touchmove',fnMove,false);
                document.removeEventListener('touchmove',fnEnd,false);
            };
            document.addEventListener('touchmove',fnMove,false);
            document.addEventListener('touchend',fnEnd,false);
            ev.preventDefault();
        },false);
    })();
    ev.preventDefault();
},false)