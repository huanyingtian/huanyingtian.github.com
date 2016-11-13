'use strict'
function loadImage(json,success,loading){
	var loaded = 0;
	var total = 0;
	var images = {};
	for(var name in json){
		total++;
		var oImg = new Image();
		oImg.src = 'img/'+json[name];
		images[name] = oImg;
		oImg.onload = function(){
			loaded++;
			loading&&loading(loaded,total);
			if(loaded==total){
				success&&success(images);
			}
		};
	}
}

function d2a(n){
	return n*Math.PI/180;
}

function a2d(n){
	return n*180/Math.PI;
}

function rnd(n,m){
	return Math.floor(Math.random()*(m-n)+n);
}






