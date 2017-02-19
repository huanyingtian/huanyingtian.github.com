'use strict'
function FrameDrag(id){
	Drag.apply(this,arguments);
	this.newDiv = null;
	this.oldDiv = null;
}
FrameDrag.prototype = new Drag();
FrameDrag.prototype.constructor = FrameDrag;
var oldFn = {};
for(var name in FrameDrag.prototype){
	oldFn[name] = FrameDrag.prototype[name];
}
FrameDrag.prototype.fnDown = function(ev){
	oldFn['fnDown'].call(this,ev);
	this.newDiv = document.createElement('div');
	this.newDiv.style.border = '5px dashed #000';
	this.newDiv.style.width = this.oDiv.offsetWidth-10+'px';
	this.newDiv.style.height = this.oDiv.offsetHeight-10+'px';
	this.newDiv.style.position = 'absolute';
	this.newDiv.style.left = this.oDiv.offsetLeft+'px';
	this.newDiv.style.top = this.oDiv.offsetTop+'px';
	document.body.appendChild(this.newDiv);
	this.oldDiv = this.oDiv;
	this.oDiv = this.newDiv;
};
FrameDrag.prototype.fnUp = function(){
	oldFn['fnUp'].call(this);
	this.oldDiv.style.left = this.oDiv.offsetLeft+'px';
	this.oldDiv.style.top = this.oDiv.offsetTop+'px';
	document.body.removeChild(this.oDiv);
	this.oDiv = this.oldDiv;
};























