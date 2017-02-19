/**
 * Created by dell on 2016/9/13.
 */
define(function(require,experts,module){
    var mov = require('move1.js').mov;
    experts.init=function(){
        window.onload=function(){
            var oBox = document.getElementById('box');
            var oSon = oBox.children[0];
            var aBtn = oSon.children;
            var oUl = document.getElementsByTagName('ul')[0];
            var aLi = oUl.children;
            for(var i=0;i<aBtn.length;i++){
                (function(index){
                    aBtn[i].onclick=function(){
                        for(var i=0;i<aBtn.length;i++){
                            aBtn[i].className='';
                        }
                        this.className='active';
                        mov(oUl,{top:-index*aLi[0].offsetHeight})
                    }
                })(i)
            }
        }
    }
})