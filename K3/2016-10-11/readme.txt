笔记
========================================
数据库
	mysql

	库 	 	管理表的 			本身不能存数据
	表 		真正存储数据的 		真正存数据
		行 	某一条数据
		列 	某一项数据
操作数据库
	1.命令行 		
	2.可视化操作（Navicat）
	3.Web形式操作

	http://localhost/phpmyadmin/
		数据库管理可视化

	1.创建一个数据库
		输入数据库名字，选择编码，点击创建
	2.创建一个表
		输入表名，输入列数。点击执行
			字段

		类型	
			INT 		整数 			12 	5 	3
			FLOAT 		单精度浮点数 	1.1 12.5 
			DOUBLE 		双精度浮点数 	超过一位小数
			CHAR 		字符
			VARCHAR 	字符串
			TEXT 		大字符串

		长度

		点击保存
	3.给表插入数据

操作数据：只有四种
	增删改查



php操作mysql数据
	1.建立连接
		mysql_connect(连接地址,用户名,密码);
				连接地址
					localhost
				用户名
					root
				密码
					空字符串
					admin
					root
	2.选择数据库
		mysql_select_db(数据库名字);
	3.执行SQL语句
		$result = mysql_query(SQL语句);
		$result 	查询到的结果

	4.遍历数据
		$row = mysql_fetch_row($result);

SQL是一门语言

查询SQL语句
SELECT * FROM 表名

SELECT * FROM tab_user;

SELECT * FROM 表名 WHERE 条件;

SELECT * FROM tab_user WHERE username='eric';


插入SQL语句

INSERT INTO 表名 VALUES(字段,字段...);

INSERT INTO tab_user VALUES('lisa','123');


============================================
用户登录注册
============================================
瀑布流
	查询语句：限制范围
	SELECT * FROM 表名 LIMIT start,count

	SELECT * FROM tab_flow LIMIT 0,10;
	SELECT * FROM tab_flow LIMIT 10,10;
	SELECT * FROM tab_flow LIMIT 20,10;

	0 		0,10 
	1 		10,10
	2 		20,10
	3 		30,10

	SELECT * FROM tab_flow LIMIT $page*$PAGE_SIZE,$PAGE_SIZE;
============================================================
nodejs
1.性能高 			php的86倍
	200台 			400W
	3台 			6W
2.很多大公司在用
3.语法跟js一模一样
=======================================================
官网:http://nodejs.org/
安装:无限下一步
验证是否安装成功
	node -v
	npm -v
=======================================================
	nodejs的文件其实就是js文件
	运行 	node 文件名 		回车
		node 		没有BOM和DOM
=======================================================
用node搭建一个服务器
	http协议 		作者想到你不会了，所以给你封装好了。

===============================================
1.引入模块
	http模块
	var http = require('http');
2.创建服务
	var server = http.createServer(function(request,response){
		request.url 		请求地址
		response.write() 	响应输出
		response.end() 		响应结束
	});
3.监听端口
	端口区分工作
	server.listen(端口号);

问题：
	1.改变文件之后，服务器需要重启
	2.读取文件


fs模块 		文件系统
var fs = require('fs');
fs.readFile(路径,function(err,data){
	err 		错误信息
		如果是真的就有错，否则就没错
	data 		文件内容
});

=========================================================
搭建服务器总结：
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
====================================================
npm 		nodejs第三方模块的管理
	node package manager
http://npmjs.com/
	通过命令安装模块

		npm install 模块名

mysql
		npm install mysql



	
需要命令行
windows 			dos命令
mac 				linex命令
=========================================================
dos命令简介
win+R 		打开运行
	输入 		cmd   回车

退出 		exit 		回车
清屏 		cls 		回车
切换盘符 	盘符: 		回车
			E: 			回车
查看文件列表
			dir 		回车
切换目录 	cd 	 		

=================================================
MVC
	M 	model			数据层
	V 	view			视图层
	C 	controller		控制层

	最开始是后台的
		1.代码分离
		2.降低代码耦合

前端
	M 	Model 				数据层 		数据交互
	V 	View 				视图层 		DOM创建
	C 	Controller 			控制层 		逻辑控制

公司不会让你手写MVC
1.不是每个人都会。
2.代码不统一

=================================================
说一下库和框架的区别？
库 		jquery
	辅助程序员开发
	程序员占主导位置
框架 	angularjs
	限制程序员开发
	框架占主导位置

========================================================
AngularJS
	MVVM框架

非常火
	由Google推动

	致力于解决交互所带来的痛苦

	数据就是一切

面向过程
面向对象
面向数据
====================================================
尽量把php，mysql，nodejs。研究一下。
