/**
 * Created by dell on 2016/9/20.
 */
define(function(require,exports,module){
    exports.init=function(){
        window.onload=function(){
            var oBox = document.getElementById('box');
            var oUl = oBox.children[0];
            var oDot = oBox.children[1];
            var aLi = oUl.children;
            var aBtn = oDot.children;
            for(var i=0;i<aBtn.length;i++){
                aBtn[i].onclick=function(){
                    for (var i=0;i<aBtn.length;i++){
                        aBtn[i].className='';
                    }
                }
            }
        }
    }
});
