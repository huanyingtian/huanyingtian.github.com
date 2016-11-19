function d2a(n){
    return n*Math.PI/180;
}
window.onload=function(){
    ;(function(){
        var aBtn = document.querySelectorAll('.project input');
        var aLi = document.querySelectorAll('.project ul li');
        for(var i=0;i<aBtn.length;i++){
            aBtn[i].index = i;
            aBtn[i].onmouseover=function(){
                for(var i=0;i<aBtn.length;i++){
                    aLi[i].className='';
                    aBtn[i].className='';
                }
                aLi[this.index].className='active';
                this.className='active'
            }
        }
    })();
    ;(function(){
        var oSpan = document.querySelector('.personSkills span');
        var oC = document.querySelector('canvas');
        var aDiv = document.querySelectorAll('.personSkills div');
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
            var arr = [90,80,92,90,90,60,60,65,70,75,76];
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
            aDiv[i].onmouseover=function(){
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

                    console.log(loading);
                    if(loading==arr[_this.index]){
                        clearInterval(timer);
                    };
                },10)
            };
        };
    })();
};
var fss;
$(function() {
    fss = new ddfullscreenslider({
        sliderid: 'dowebok'
    });
});