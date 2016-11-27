function d2a(n){
    return n*Math.PI/180;
}
window.onload=function(){

    ;(function(){
        var oSpan = document.querySelector('.slide span');
        var oC = document.querySelector('canvas');
        var aDiv = document.querySelectorAll('.slide div');
        oC.width = oSpan.offsetWidth;
        oC.height = oSpan.offsetHeight;
        var timer = null;
        var gd = oC.getContext('2d');
        var cx = oC.width/ 2,
            cy = oC.height/2;
        var n = 360;
        var lg = gd.createLinearGradient(100,350,600,350);
        lg.addColorStop(0,'orange');
        lg.addColorStop(0.2,'purple');
        lg.addColorStop(0.4,'blue');
        lg.addColorStop(0.6,'pink');
        lg.addColorStop(0.8,'red');
        lg.addColorStop(1,'aqua');
        gd.beginPath();
        gd.arc(cx,cy,200,d2a(0-90),d2a(n-90),false);
        gd.lineWidth=60;
        gd.strokeStyle='#ccc';
        gd.stroke();

        var loaded = 100;
        for(var i=0;i<aDiv.length;i++){
            var arr = [90,80,92,90,96,60,60,65,70,75,76];
            aDiv[i].index = i;
            gd.beginPath();
            gd.arc(cx,cy,200,d2a(0-90),d2a(arr[0]/100*360-90),false);
            gd.lineWidth=60;
            gd.strokeStyle=lg;
            gd.stroke();
            var str = '掌握程度'+(90).toFixed(2)+'%';
            gd.font = '30px 微软雅黑';
            gd.textAlign = 'center';
            gd.textBaseline = 'middle';
            gd.fillStyle = lg;
            gd.fillText(str,cx,cy);
            aDiv[i].onclick=function(){
                for(var i=0;i<aDiv.length;i++){
                    aDiv[i].className='';
                };
                this.className='active';
                var loading = 0;
                clearInterval(timer);
                var _this = this;
                timer=setInterval(function(){
                    gd.clearRect(0,0,oC.width,oC.height);
                    gd.beginPath();
                    gd.arc(cx,cy,200,d2a(0-90),d2a(360-90),false);
                    gd.lineWidth=60;
                    gd.strokeStyle='#ccc';
                    gd.stroke();
                    loading+=1;
                    n = loading/loaded*360;
                    gd.beginPath();
                    gd.arc(cx,cy,200,d2a(0-90),d2a(n-90),false);
                    gd.lineWidth=60;
                    gd.strokeStyle=lg;
                    gd.stroke();
                    var scale = loading/loaded;
                    var str = '掌握程度'+(scale*100).toFixed(2)+'%';
                    gd.font = '30px 微软雅黑';
                    gd.textAlign = 'center';
                    gd.textBaseline = 'middle';
                    gd.fillStyle = lg;
                    gd.fillText(str,cx,cy);

                    if(loading==arr[_this.index]){
                        clearInterval(timer);
                    };
                },30)
            };
        };
    })();
    (function(){
        var oV = document.querySelector('audio');
        var aLi = document.querySelectorAll('.music li');
        var oMovie = document.querySelector('.slide video');
        var aLi1 = document.querySelectorAll('.slide .movie li');
        var arr = ['https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/f9e34dc6-4d52-4029-aa0a-4a8b67a163e3.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/c0bb8f4a-e90c-4e73-84a7-6b1647fcecad.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/a84ec663-bb5e-43d8-954d-f967cd14822e.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/89d803c6-8273-43c6-8d4b-6801a8472623.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/c407ace2-6990-48a7-9d99-df244118d6f5.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/21ff8e6b-a4e4-4230-8f86-fc1f03dda8f2.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/7d1c78a5-8fdb-40e4-833a-225204a6d800.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/425355f6-49f0-47bf-bd93-97b40785c7d8.mp4','https://ss0.bdstatic.com/-0U0bnSm1A5BphGlnYG/cae-legoup-video-target/c5b0f13c-cfc1-4b80-9fcb-2632bb978d3f.mp4'];
        var oStop = document.querySelector('.stop');
        oStop.onclick=function(){
            oV.pause();
            oStop.style.background='url(../image/play.jpg) no-repeat';
            oStop.style.backgroundSize= '100% 100%'
        };
        oStop.ondblclick=function(){
            oV.play();
            oStop.style.background='url(../image/stop.jpg) no-repeat';
            oStop.style.backgroundSize= '100% 100%'
        };
        for(var i=0;i<aLi.length;i++){
            aLi[i].index = i;
            aLi[i].onclick=function(){
                oMovie.pause();
                //alert(this.innerHTML);
                oV.src = '../mp3/'+this.innerHTML+'.mp3';
                for(var i=0;i<aLi.length;i++){
                    aLi[i].className=''
                }
                this.className='active';
            }
        }
        for(var i=0;i<aLi1.length;i++){
            aLi1[i].index=i
            aLi1[i].onclick=function(){
                oV.pause();
                oMovie.src=arr[this.index];
                oMovie.play();
                oStop.style.background='url(../image/play.jpg) no-repeat';
                oStop.style.backgroundSize= '100% 100%'
            }
        };
        oMovie.onclick=function(){
            oV.pause();
            oMovie.play();
            oStop.style.background='url(../image/play.jpg) no-repeat';
            oStop.style.backgroundSize= '100% 100%'
        };
        oMovie.ondblclick=function(){
            oMovie.pause();
        };
    })();
};
var fss;
$(function() {
    fss = new ddfullscreenslider({
        sliderid: 'dowebok'
    });
});