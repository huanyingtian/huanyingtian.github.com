document.addEventListener('DOMContentLoaded',function(ev){
    (function(){
        var oBtn = document.querySelector('header span');
        var oIndex = document.querySelector('section.index');
        var oN = document.querySelector('section.index span');
        oBtn.addEventListener('click',function(){
            oIndex.style.display='block';
        },false);
        oN.addEventListener('click',function(){
            oIndex.style.display='none';
        },false);
        var oBtn = document.querySelector('section.index ul li.to');
        oBtn.addEventListener('click',function(){
            oIndex.style.display='none';
        },false);
    })();
    ev.preventDefault();
},false);