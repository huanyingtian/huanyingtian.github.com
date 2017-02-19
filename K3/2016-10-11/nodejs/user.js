var http = require('http'),
	fs = require('fs'),
	mysql = require('mysql'),
	qs = require('querystring');
http.createServer(function(req,res){
	if(req.url.indexOf('?')!=-1){
		var data = req.url.split('?')[1];
		var GET = qs.parse(data);
		
		switch(GET.act){
			case 'login':
				var db = mysql.createConnection({
					host:'localhost',
					user:'root',
					password:'',
					database:'20161011'
				});
				var SQL = 'SELECT * FROM tab_user WHERE username="'+GET.user+'"';
				db.query(SQL,function(err,data){
					if(err){
						console.log('错了');
					}else{
						if(data.length){
							if(data[0].password==GET.pass){
								res.end('{"err":0,"msg":"登录成功"}');
							}else{
								res.end('{"err":1,"msg":"用户名或密码错误"}');
							}
						}else{
							res.end('{"err":1,"msg":"此用户未注册"}');
						}
					}
				});
				break;
			case 'add':
				var db = mysql.createConnection({
					host:'localhost',
					user:'root',
					password:'',
					database:'20161011'
				});
				var SQL = 'SELECT * FROM tab_user WHERE username="'+GET.user+'"';
				db.query(SQL,function(err,data){
					if(err){
						console.log('错了');
					}else{
						if(data.length){
							res.end('{"err":1,"msg":"用户名已被占用"}');
						}else{
							var SQL = 'INSERT INTO tab_user VALUES("'+GET.user+'","'+GET.pass+'")';
							db.query(SQL,function(err,data){
								if(err){
									console.log('错了');
								}else{
									res.end('{"err":0,"msg":"注册成功"}');
								}
							});
						}
					}
				});
				break;
		}
		
	}else{
		fs.readFile('www'+req.url,function(err,data){
			if(err){
				res.end('404');
			}else{
				res.end(data);
			}
		});
	}
}).listen(8081);