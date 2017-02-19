var http = require('http');

var server = http.createServer(function(request,response){
	//request 			请求
	//response 			响应
	console.log('有人来了...');
});
server.listen(8081);