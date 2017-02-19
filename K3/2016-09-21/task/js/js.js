$(function(){
    var aBtn = $('ul li');
    var oP = $('#prev');
    var oN = $('#next');
    var oBox = $('#box');
    var oOl = $('ol');
    var oLi = $('ol li');

    //console.log($(oLi).clone().prependTo(oOl));
    $(oLi).clone().prependTo(oOl);
    var aLi = $('ol li');
    //alert(aLi.length)
    oOl.width(oLi.eq(0).width()*aLi.length);
    oBox.hover(function(){
            oP.show();
            oN.show();
        },
        function(){
            oP.hide();
            oN.hide();
        });

    aBtn.click(function(){
        aBtn.removeClass('active');
        $(this).addClass('active');
        oOl.stop().animate({left:-oLi.width()*$(this).index()},1000)
    });
    aLi.each(function(i){
        var n=0;
        oP.click(function(){
            n--;
            if(n%5<0){
                n=aBtn.length-1;
            }
            aBtn.removeClass('active');
            aBtn.eq(n%5).addClass('active');
            oOl.stop().animate({left:-oLi.width()*(n%5)},1000)

        });
        oN.click(function(){
            //nad();
            if(n%5>aBtn.length-1){
                n=0;
                oOl.stop().animate({left:-oLi.width()*0},0);
            }
            n++;

            aBtn.removeClass('active');
            aBtn.eq(n%5).addClass('active');
            oOl.stop().animate({left:-oLi.width()*(n%6)},1000,function(){
                if(n==5){
                    oOl.css('left','0');
                }
            });


        });
        nad();
        var timer=null;
        timer=setInterval(function(){
            n++;
            if(n%6>aBtn.length){
                oOl.stop().animate({left:-aLi.eq(0).width()*(n%10)},1000);
                n=0;
                //oOl.stop().animate({left:-oLi.width()*0},0);
            }
            aBtn.removeClass('active');
            aBtn.eq(n%5).addClass('active');
            oOl.stop().animate({left:-aLi.eq(0).width()*(n%6)},1000,function(){
                if(n==5){
                    oOl.css('left','0');
                }
            });
        },1000);
        oBox.hover(function(){
            clearInterval(timer);
        },function(){
            timer=setInterval(function(){
                n++;
                if(n%10>aLi.length-1){
                    oOl.stop().animate({left:-aLi.eq(0).width()*(n%10)},1000);
                    n=0;
                    //oOl.stop().animate({left:-oLi.width()*0},0);
                }
                aBtn.removeClass('active');
                aBtn.eq(n%5).addClass('active');
                oOl.stop().animate({left:-aLi.eq(0).width()*(n%5)},1000);
            },2000);
        });
        function nad(){

            n++;
            if(n%10>aLi.length-1){
                oOl.stop().animate({left:-aLi.eq(0).width()*(n%10)},1000);
                n=0;
                //oOl.stop().animate({left:-oLi.width()*0},0);
            }
            aBtn.removeClass('active');
            aBtn.eq(n%5).addClass('active');
            oOl.stop().animate({left:-aLi.eq(0).width()*(n%6)},1000,function(){
                if(n==5){
                    oOl.css('left','0');
                }
            });

        };
    });


});