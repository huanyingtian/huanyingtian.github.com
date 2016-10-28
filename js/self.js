window.onload=function() {
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
    var oPage1 = document.querySelector('.page1');

    var oTime = oPage1.querySelector('.time');
    var aImg = oTime.querySelectorAll('img');
    clock();
    setInterval(clock,1000);
};








