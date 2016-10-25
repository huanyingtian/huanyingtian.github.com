window.onload=function(){
    var oPage1 = document.querySelector('.page1');
    var oBox = oPage1.querySelector('.box');
    oBox.style.width=document.documentElement.clientWidth*0.9+'px';
    oBox.style.height=document.documentElement.clientHeight*0.9+'px';

    var oDiv = oBox.querySelector('div');
    function clock(){
        var oDate = new Date();
        var H = oDate.getHours();
        var m = oDate.getMinutes();
        var h= H+m/60;
        if(h>=6&&h<=18){//白天
            oPage1.style.backgroundImage='url(../image/lantianbaiyun.jpg)'';
            oPage1.style.backgroundSize='100%';
            oDiv.style.background='#ff0';
            oDiv.style.shadowColor='#ff0';
            if(h<=12) {//上午
                oDiv.style.bottom = ((h-6) / 6) * 100 + '%';
            }else{//下午
                oDiv.style.bottom = ((18 - h) / 6) * 100 + '%';
            }
            oDiv.style.left = ((h-6)/12)*100+'%';
        }else{//夜晚
            if((h>18&&h<19)||m<5){
                oDiv.style.left=0;
                oDiv.style.bottom=0;
            }
            oDiv.style.background='#fff';
            oDiv.style.shadowColor='#fff';
            oPage1.style.backgroundImage="url('../image/fanxingdiandian.jpg')";
            oPage1.style.backgroundSize='100%';

            if(h>18&&h<24){//上半夜
                //h-18
                oDiv.style.left=(h-18)/12+'px';
                oDiv.style.bottom=(h-18)/6+'px';
            }else{//下半夜
                oDiv.style.left=(h+6)/12+'px';
                oDiv.style.top=(6-h)/6+'px';
            }
        };
    }
    clock();
    setInterval(clock,360000);
}
window.onload=function(){
    function toDou(n){
        return n<10?'0'+n:''+n;
    }
    function clock(){
        var arr = ['seven','one','two','three','four','five','six']
        var oDate = new Date();
        var Y = oDate.getFullYear();
        var M = oDate.getMonth()+1;
        var D = oDate.getDate();
        var w = oDate.getDay();
        var h = oDate.getHours();
        var m = oDate.getMinutes();
        var s = oDate.getSeconds();
        var str =''+Y+'y'+toDou(M)+'m'+toDou(D)+'d'+toDou(h)+'p'+toDou(m)+'p'+toDou(s)+'';
        for(var i=0;i<aImg.length;i++){
            aImg[i].src='image/'+str.charAt(i)+'.png';
            aImg[aImg.length-1].src='image/'+arr[w]+'.png';
            aImg[aImg.length-2].src='image/week.png';
        };
    };
    var oPage2 = document.querySelector('.page2');

    var oTime = oPage2.querySelector('.time');
    var aImg = oTime.querySelectorAll('img');
    clock();
    setInterval(clock,1000);
};








