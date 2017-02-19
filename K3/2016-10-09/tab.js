'use strict'
function Tab(id){
	if(!id)return;
	this.oTab = document.getElementById(id);
	this.aBtn = this.oTab.getElementsByTagName('input');
	this.aDiv = this.oTab.getElementsByTagName('div');
	this.iNow = 0;
	
	this.init();
}
Tab.prototype.init = function(){
	var _this = this;
	for(var i=0;i<this.aBtn.length;i++){
		this.aBtn[i].index = i;
		this.aBtn[i].onclick = function(){
			_this.iNow = this.index;
			_this.tab();
		};
	}
};
Tab.prototype.tab = function (){
	for(var i=0;i<this.aBtn.length;i++){
		this.aBtn[i].className = '';
		this.aDiv[i].className = '';
	}
	this.aBtn[this.iNow].className = 'on';
	this.aDiv[this.iNow].className = 'on';
}