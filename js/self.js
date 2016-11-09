function toDou(n){
    return n<10?'0'+n:''+n;
}
window.onload=function(){
    ;(function(){
        var aLi = document.querySelectorAll('header div ul li');
        var aLi1 = document.querySelectorAll('header div ul li div');
        for(var i=0;i<aLi.length;i++){
            aLi[i].index = i;
            aLi[i].onmouseover=function(){
                aLi1[this.index].style.display='block';
                var _this = this;

                this.onmouseout=function(){
                    timer=setTimeout(function(){
                        aLi1[_this.index].style.display='none';

                    },100)
                    //alert(_this.index)
                    aLi1[_this.index].onmouseover=function(){

                        clearTimeout(timer);
                    }
                }

            }
        }
    })();
    ;(function(){
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
        var oPage1 = document.querySelector('div.time .page1');

        var oTime = oPage1.querySelector('.clock');
        var aImg = oTime.querySelectorAll('img');
        clock();
        setInterval(clock,1000);
    })();
    ;(function(){
        var oUl = document.querySelector('.banner div ul');
        var oOl = document.querySelector('.banner div ol');
        var n = 0;
        var aLi = document.querySelectorAll('.banner div ul li');
        var aBtn = document.querySelectorAll('.banner div ol li');
        var timer = null;
        var oLeft = document.querySelectorAll('.banner div a')[0];
        var oRight = document.querySelectorAll('.banner div a')[1];
        var oDiv = document.querySelector('.banner div');
        for(var i=0;i<aBtn.length;i++){
            aBtn[i].index = i;

            aBtn[i].onclick=function(){
                n=this.index;
                for(var i=0;i<aBtn.length;i++){
                    aBtn[i].className = ''
                };
                aBtn[n].className='active';
                oUl.style.transform='translateX('+(-n*aLi[0].offsetWidth)+'px)';
            }//点击
        }
        oDiv.onmouseover=function(){
            clearInterval(timer);
            oLeft.style.display='block';
            oRight.style.display='block';
            oDiv.onmouseout=function(){
                oLeft.style.display='none';
                oRight.style.display='none';
                timer=setInterval(clock,5000)
            }
        }
        function tab(){
            for(var i=0;i<aBtn.length;i++){
                aBtn[i].className = ''
            };
            aBtn[n].className='active';
            oUl.style.transform='translateX('+-(n*aLi[0].offsetWidth)+'px)'
        }
        oRight.onclick=function(){
            n++;
            if(n>aBtn.length-1){
                n=0;
            }
            tab();
        }
        oLeft.onclick=function(){
            n--;
            if(n<0){
                n=aBtn.length-1;
            }
            tab();
        }
        function clock(){
            n++;
            if(n>aBtn.length-1){
                n=0;
            }
            tab();
        }
        clock();
        timer=setInterval(clock,5000)
    })();
    ;(function(){})();
    ;(function(){})();
}