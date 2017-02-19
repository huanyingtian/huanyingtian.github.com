'use strict'
function AutoTab(id){
	Tab.apply(this,arguments);
	this.timer = null;
	this.autoInit();
}
AutoTab.prototype = new Tab();
AutoTab.prototype.constructor = AutoTab;
AutoTab.prototype.autoInit = function(){
	var _this = this;
	this.play();
	this.oTab.onmouseover = function(){
		_this.stop();
	};
	this.oTab.onmouseout = function(){
		_this.play();
	};
};
AutoTab.prototype.next = function(){
	this.iNow++;
	if(this.iNow==this.aBtn.length){
		this.iNow = 0;
	}
	this.tab();
};
AutoTab.prototype.play = function(){
	var _this = this;
	this.timer = setInterval(function(){
		_this.next();
	},1000);
};
AutoTab.prototype.stop = function(){
	clearInterval(this.timer);
};