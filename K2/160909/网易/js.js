window.onload = function(){
    function tab(id1,id2) {
        var oTab = document.getElementById(id1);
        var aLi = oTab.getElementsByTagName('li');
        var oTa = document.getElementById(id2);
        var aDiv = oTa.children;
        var aSpan = oTab.getElementsByTagName('span');
        var timer = null;
        for (var i = 0; i < aLi.length; i++) {
            aLi[i].index = i;
            aLi[i].onmouseover = function () {
                var _this = this;
                timer = setTimeout(function () {
                    for (var i = 0; i < aLi.length; i++) {
                        aSpan[i].style.display = 'none';
                        aDiv[i].style.display = 'none';
                        aLi[i].className = '';
                    }
                    aLi[_this.index].className = 'current';
                    aSpan[_this.index].style.display = 'block';
                    aDiv[_this.index].style.display = 'block';

                }, 50)
            };
            aLi[i].onmouseout = function () {
                clearTimeout(timer);
            }
        }
    }
    tab('tab-u','tab-bd');
    tab('tab-right','right-gg');

    function main(id1,id2,cla){
        var oTa = document.getElementById(id1);
        var aLii = oTa.getElementsByTagName('li');
        var oTaa = document.getElementById(id2);
        var aDivv=oTaa.children;

        var timer = null;
        for (var i = 0; i < aLii.length; i++) {
            aLii[i].index = i;
            aLii[i].onmouseover = function () {
                var _this = this;
                timer = setTimeout(function () {
                    for (var i = 0; i < aLii.length; i++) {

                        aDivv[i].style.display = 'none';
                        aLii[i].className = '';
                    }
                    _this.className = cla;
                    aDivv[_this.index].style.display = 'block';
                }, 50)
            };
            aLii[i].onmouseout = function () {
                clearTimeout(timer);
            }
        }
    }
    main('sport','picture','active');
    main('sportt2','army','active');
    main('sport2','easy','active');
    main('car-m','finance','on');
    main('subject-1','videovideo1','on');
    main('subject-2','com-main-3','on')
    main('subject-a','friend-a','on')
    main('subject-b','friend','on')
    main('subbbb','video2','on')
    main('subjecctt','shop','on')
    main('subject1','com-main1','on')
    main('subject2','com-main2','on')
    main('subject3','com-main3','on')
    main('subject4','com-main4','on')
    main('subject5','com-main5','on')
    main('subject6','com-main6','on')
    main('subject7','com-main7','on')
    main('subject8','com-main8','on')
    main('subject-3','com-main-2','on')
    main('subject-4','com-main-4','on')
    main('subject-6','com-main-6','on')
    main('subject-7','com-main-7','on')
    main('subject-8','com-main-8','on')
    main('subject-9','com-main-9','on')
    main('subject-10','com-main-10','on')
    main('subject-11','com-main-11','on')
    main('subject-12','com-main-12','on')
    main('subject-13','com-main-13','on')
    main('subject-14','com-main-14','on')

    var oBtn  =document.getElementById('btn');
    var oH = document.documentElement.clientHeight;
    var timer = null;
    var lock = true;
    window.onscroll = function(){
        var oT = document.documentElement.scrollTop||document.body.scrollTop;
        if(oT>=oH){
            oBtn.style.display = 'block';
        }else{
            oBtn.style.display = 'none';
        }
        if(!lock){
            clearInterval(timer)
        }
        lock = false;
    };
    oBtn.onclick = function(){
        timer = setInterval(function(){
            var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
            var count = Math.floor(-scrollTop/30);
            document.documentElement.scrollTop=document.body.scrollTop=scrollTop+count ;
            lock = true;
            if(scrollTop==0){
                clearInterval(timer);
            }
        },30);
    }
}

/**
 * Created by Administrator on 2016/9/10.
 */
