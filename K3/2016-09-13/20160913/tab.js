define(function(require,exports,module){
	exports.tab = function(){
		window.onload = function(){
			var aInput = document.getElementsByTagName('input');
			var aDiv =  document.getElementsByTagName('div');
			for (var i = 0; i < aInput.length; i++) {
				aInput[i].index = i;
				aInput[i].onclick = function(){
					for (var i = 0; i < aInput.length; i++) {
						aDiv[i].style.display = 'none';
					}
					aDiv[this.index].style.display = 'block';
				}
			}
		}
	}
	exports.a = function(){
			var aInput = document.getElementsByTagName('input');
			var aDiv =  document.getElementsByTagName('div');
			for (var i = 0; i < aInput.length; i++) {
				aInput[i].index = i;
				aInput[i].onclick = function(){
					for (var i = 0; i < aInput.length; i++) {
						aDiv[i].style.display = 'none';
					}
					aDiv[this.index].style.display = 'block';
				}
			}
		
	};
})