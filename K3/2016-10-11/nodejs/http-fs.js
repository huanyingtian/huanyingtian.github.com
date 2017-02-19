var http = require('http'),
	fs = require('fs');

var server = http.createServer(function(request,response){
	fs.readFile('www'+request.url,function(err,data){
		if(err){
			response.write('404');
		}else{
			response.write(data);
		}
		response.end();
	});
});
server.listen(8081);









