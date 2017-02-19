笔记
==================================================
JQuery
	sizzle.js 			jquery的选择器
==================================================
自己写选择器
	这一次获取到的子级，是下一次获取的父级


	#id
	.class
	tag

	#box ul li

	筛选
	ele.class

	/^\w+\.\w+$/


	属性
	ele[name=value]
		/^\w+\[\w+\=\w+\]$/



	伪类选择器
		/^\w+\:\w+(\(\d+\))?$/

	li:first
	li:last
	li:even
	li:odd
	li:lt(2)
	li:gt(2)
	li:eq(2)
================================================
事件流
	DOM事件流 		高级浏览器下的事件流
				冒泡阶段
				捕获阶段
	IE事件流 		低版本IE下的事件流
				冒泡阶段

ZQuery
	jquery里面样式、属性..获取的时候默认获取第一个元素的
方法
	.css()
		.css(name); 		获取样式
		.css(name,value); 	设置样式
		.css({}); 			批量设置样式
	.attr()
		.attr(name); 		获取属性
		.attr(name,value); 	设置属性
		.attr({}); 			批量设置属性

	.addClass()

	.removeClass()

	.html()
		.html() 			获取
		.html('') 			设置
	.val()
		.val(); 			获取
		.val(''); 			设置

	.show() 				显示
	.hide() 				隐藏

事件
	click mouseover mouseout mousedown mouseup mousemove mouseenter mouseleave change keydown keyup contextmenu

	$('').click();

	事件
		组止默认事件
		取消冒泡
		return false;
================================================
	
	$('li').get(2)
	$('li').eq(2) 	
	$('li').index()
===============================================
	hover(fn1,fn2)
	toggle(fn1,fn2,fn3...)
===============================================
运动
	.animate
===============================================
	DOM操作
		$('<p>p标签</p>')

		obj.insertAdjacentHTML('插入的方式',字符串标签);


	.insertBefore() 		外部前面 	beforeBegin
	.insertAfter() 			外部后面 	afterEnd
	.appendTo() 			内部后面 	beforeEnd
	.prependTo() 			内部前面 	afterBegin

		删除元素
			$(元素).remove();
===============================================
	交互
		ajax
		jsonp
=========================================
	jquery 		扩展
	$.fn.xxx = function(){};
	$.fn.extend({
		xxx:function(){}
	});
=========================================
	链式操作

	$('div').hide().show().animate({left:500});



======================================
不方便查询的时候
	查看对象身上的属性和方法
		for(var name in obj){
			document.write(name+'<br />');
		}
===========================================
ZQuery
===========================================
PHP 		
1.市场占有率 		高
2.非常简单
3.语法跟js惊人的相似

所有后台语言都是运行在服务器上的

如何创建php文件
	*.php

标签
	<?php
		//your code
	?>

输出
	echo 12;

		后台语言中
			字符串 		"abcd" 		
			字符 		'a' 
后台代码，客户端看不到。因为在服务端运行，反馈给客户端的只是结果。


js
	+ 			加法运算、字符串拼接
	. 			操作属性
	obj.change();
php
	+ 			加法运算	
	. 			字符串拼接	
	-> 			操作属性
	obj->change();

==============================================
变量
	js
		var 变量名 = 值;
	php
		$变量名 = 值;
函数
===============================================
php  	98%↑都是操作数据

接收前端请求的数据
	GET
			$_GET["名字"]
	POST
			$_POST["名字"]

用户注册+登录
===============================================
数据库 		database
mysql
1.轻量
2.免费
3.php和mysql是好基友。

=============================================
ZQuery 		写











