var http = require('http');

var server = http.createServer(function(request,response){
	//request 			请求
	//response 			响应
	response.write('<!doctype html><html><head><meta charset="utf-8"><meta name="author" content="智能社 - zhinengshe.com" /><meta name="copyright" content="智能社 - zhinengshe.com" /><meta name="description" content="智能社是一家专注于web前端开发技术的公司，目前主要提供JavaScript培训和HTML5培训两项服务，同时还推出了大量javascript基础知识教程，智能课堂为你带来全新的学习方法和快乐的学习体验。" /><title>智能社— http://www.zhinengshe.com</title><style>*{margin:0; padding:0;}div{width:200px; height:200px; background:red;}</style><script>window.onload = function(){	var oDiv = document.getElementsByTagName("div")[0];	oDiv.onclick = function(){		this.style.background = "green";	};};</script></head><body><div></div></body></html>');
	response.end();
});
server.listen(8081);