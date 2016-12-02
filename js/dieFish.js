'use strict'
function DieFish(aResult,type){
	Sprite.call(this,aResult['fish'+type]);
	this.w = FISH_SIZE[type].w;
	this.h = FISH_SIZE[type].h;
	this.iSpeed = 0;
	this.sx = this.w*4;
	this.status = 0;
}
DieFish.prototype = new Sprite();
DieFish.prototype.constructor = DieFish;
DieFish.prototype.goDie = function(){
	this.sx+=this.w;
	if(this.sx==this.w*8){
		this.sx = this.w*4;
		this.status = 1;
	}
};