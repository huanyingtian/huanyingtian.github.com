define(function(require,exports,module){
	var com=require('com');
	exports.show=function(){
		var oPlay=document.getElementById('play');
		var oOl=oPlay.children[0];
		var aBtn=oOl.children;
		var oUl=oPlay.children[1];
		var aLi=oUl.children;
		
		for(var i=0; i<aBtn.length; i++){
			(function(index){
				aBtn[i].onclick=function(){
					for(var i=0; i<aBtn.length; i++){
						aBtn[i].className='';
					}
					this.className='active';
					//oUl.style.top=-index*aLi[0].offsetHeight+'px';
					com.move(oUl,{top:-index*aLi[0].offsetHeight});
				}
			})(i);
		}
	};
});