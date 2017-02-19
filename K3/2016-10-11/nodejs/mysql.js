var mysql = require('mysql');

var db = mysql.createConnection({
	host:'localhost',
	user:'root',
	password:'',
	database:'20161011'
});
db.query('SELECT * FROM tab_user',function(err,data){
	for(var i=0;i<data.length;i++){
		console.log('用户名:'+data[i].username+',密码:'+data[i].password);
	}
});











