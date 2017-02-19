'use strict'
function Drag(id){
	if(!id)return;
	this.oDiv = document.getElementById(id);
	this.disX = 0;
	this.disY = 0;
	this.init();
}
Drag.prototype.init = function(){
	var _this = this;
	this.oDiv.onmousedown = function(ev){
		var oEvent = ev||event;
		_this.fnDown(oEvent);
		return false;
	};
};
Drag.prototype.fnDown = function(ev){
	var _this = this;
	this.disX = ev.clientX-this.oDiv.offsetLeft;
	this.disY = ev.clientY-this.oDiv.offsetTop;
	document.onmousemove = function(ev){
		var oEvent = ev||event;
		_this.fnMove(oEvent);
	};
	document.onmouseup = function(){
		_this.fnUp();
	};
	this.oDiv.setCapture&&this.oDiv.setCapture();
};
Drag.prototype.fnMove = function(ev){
	this.oDiv.style.left = ev.clientX-this.disX+'px';
	this.oDiv.style.top = ev.clientY-this.disY+'px';
};
Drag.prototype.fnUp = function(){
	document.onmousemove = null;
	document.onmouseup = null;
	this.oDiv.releaseCapture&&this.oDiv.releaseCapture();
};
