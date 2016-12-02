function tab(a,b,c,d,f){
    var oYs1_lul = document.getElementById(a);
    var oYs1_limg = oYs1_lul.getElementsByTagName(b);
    var oYs1_bul = document.getElementById(c);
    var oYs1_btn = oYs1_bul.getElementsByTagName(d);

    for(var i=0;i<oYs1_btn.length;i++){
        oYs1_btn[i].index = i;
        oYs1_btn[i].onmouseover = function(){
            for(var i=0;i<oYs1_btn.length;i++){
                oYs1_btn[i].className = '';
                oYs1_limg[i].style.display = 'none';
            }
            this.className = f;
            oYs1_limg[this.index].style.display = 'block';
        }
    }
}
window.onload = function(){
    (function(){
        var oNav_btn = document.getElementById('nav_btn');
        var oNav_li = oNav_btn.getElementsByTagName('li');
        var oNav_p = oNav_btn.getElementsByTagName('p');

        for(var i=0;i<oNav_li.length;i++){
            if(oNav_li[i].title == '详情'){
                oNav_li[i].onmouseover = function(){
                    this.id = 'top_hover'
                }
                oNav_li[i].onmouseout = function(){
                    this.id = ''
                }
            }
        }

        var  oBtnBox = document.getElementById('ys3_tzhiye');
        var aBtn_li= oBtnBox.getElementsByTagName('li');
        var oBox_div=document.getElementById('ys3_bzhiye');
        var aShowBox= oBox_div.getElementsByTagName('div');
        var arr = ['0','-109','-219','-329','-439','-549']
        for(var i=0; i<aBtn_li.length; i++){
            aBtn_li[i].index=i;
            aBtn_li[i].onmouseover = function(){
                for(var i=0; i<aBtn_li.length; i++){
                    aBtn_li[i].style.backgroundPosition = '';
                    aShowBox[i].className='';
                }
                this.style.backgroundPosition=arr[this.index]+'px -471px';
                aShowBox[this.index].className='ys3_zhiye_hover';
            }
        }
    })();
    tab('ys1_limg','a','ys1_lbtn','li','ys1_l_btn1');
    tab('ys1_rbnr','div','ys1_nav','li','ys1_head_li2');
    tab('ys4_playnr','div','ys4_play','li','ys4_play_li');
    tab('ys4_meiti','div','ys4_meitinr','li','ys4_play_li');
    tab('ys4_videoul','div','ys4_video_h','li','ys4_play_li');
    tab('ys1_rbnr','div','ys1_nav','li','ys1_head_li2');
}