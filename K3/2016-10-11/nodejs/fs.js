var fs = require('fs');
fs.readFile('www/1.html',function(err,data){
	if(err){
		console.log('文件没有找到');
	}else{
		console.log(''+data);
	}
});