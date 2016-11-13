'use strict'
function Sprite(img){
	this.img = img;
	this.sx = 0;
	this.sy = 0;
	this.x = 0;
	this.y = 0;
	this.w = 0;
	this.h = 0;
	this.r = 0;
	this.iSpeed = 0;
}
Sprite.prototype.draw=function(gd){
	gd.save();
	gd.beginPath();
	gd.translate(this.x,this.y);
	gd.rotate(d2a(this.r));
	gd.drawImage(
		this.img,
		this.sx,this.sy,this.w,this.h,
		-this.w/2,-this.h/2,this.w,this.h
	);
	gd.restore();
};
Sprite.prototype.collTest = function(obj){
	var a = obj.x-this.x;
	var b = obj.y-this.y;
	
	var dis = Math.sqrt(a*a+b*b);
	if(dis<30){
		return true;
	}else{
		return false;
	}
};
Sprite.prototype.move = function(){
	var iSpeedX = Math.sin(d2a(this.r))*this.iSpeed;
	var iSpeedY = -Math.cos(d2a(this.r))*this.iSpeed;
	this.x+=iSpeedX;
	this.y+=iSpeedY;
};