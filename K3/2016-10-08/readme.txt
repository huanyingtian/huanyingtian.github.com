笔记
================================================
ajax 			无刷新从后台获取数据
jsonp 			用来跨域

ajax和jsonp的区别，jsonp为什么不是ajax？
	ajax不能跨域，本质走的是XMLHttpRequest对象，jsonp可以跨域，本质走的是利用script能异步调用后台的脚本。

	jsonp为什么不是ajax？
		因为jsonp走的不是XMLHttpRequest对象


正则
	1.操作字符串
	2.表单校验
===================================================
	量词
		{n}	{n,m} 	{n,} 	+ 	* 	?
	转义
		\d 	\w 	\s
		\D 	\W 	\S
		. 		
	选项
		i 		Ignore 	忽略大小写
		m 		Muti-line 	多行模式
		g 		global 		全局匹配
======================================================
	var str = '       abcdefg        ';

	去掉首尾空格
		str = str.replace(/^\s+|\s+$/g,'');
	多个空格合并成一个
		str = str.replace(/\s+/g,' ');


用正则写class操作:
	removeClass
	addClass
	getByClass
	
=====================================================
	单词边界
		\b
===================================================
传统语言
	s1 = 申请空间(200);
	用。。。
	释放(s1)
		内存泄露 		√
		内存溢出

垃圾回收机制 	生命周期

局部 	短 		当函数调用结束的时候，局部就会销毁。
全局 	长 		当页面关闭的时候，才会销毁。
闭包 	可长可短
		只要里面的函数还有用，父函数内的局部变量就不会消失
		只要里面的函数还有用，父函数内的所有的局部变量都不会消失
		只要里面的函数还有用，整条作用域链上的变量都不会消失。
	


function show(){
	var a = 12;
	alert(a);
}
 				调用前 	没有a
show(); 		调用中 	有a
 				调用后 	没有a


var a = 12;
function show(){
	alert(a);
}
 				调用前 	有a
show(); 		调用中 	有a
 				调用后 	有a


function show(){
	var a = 12;
	document.onclick = function(){
		alert(a);
	};
}
 			调用前 			没有a
show(); 	调用中 			有a
 			调用后 			有a


function show(){
	var a = 12;
	var b = 5;
	document.onclick = function(){
		alert(a);
	};
}
 				调用前 		没有a，没有b
show() 			调用中 		有a，有b
 				调用后 		有a，有b

1.怕有错
2.为了性能


var a = 12;
function show(){
	var b = 5;
	function show2(){
		var c = 3;
		document.onclick = function(){
			alert(a);
		};
	}
	show2();
}

作用域链 	先在自身找，如果找不到，找父函数，如果父函数找不到，找父函数的父函数，以此类推，一直往上找。直到找到全局，如果全局有，就用，没有就报错。

解释一下什么是作用域链？

解释一下什么是闭包？
	只要里面的函数还有用，整条作用域链上的变量都不会消失。
	定义父函数，父函数中定义局部变量，在子函数中可以使用父函数中的局部变量。

有三个按钮，点击每个按钮的时候，弹出当前按钮的下标。
	
	封闭空间 	自执行函数 	闭包 	js代码
===================================================
递归 	自己调用自己
 		大事化小
===============================================
	1.兔子不会死，兔子不吃东西，不喝水。
	2.兔子可以近亲繁殖。
	3.小兔子三个月成熟，一个月下一对

1	2	3	4	5	6	7	8	9	10 	11 	12
1 	1 	2 	3 	5 	8 	13 	21 	34 	55 	89 	144

	12月 		144 			1440
	24月		46368 			463680
	36月		14930352 		149303520
	48月		4807526976 		48075269760
	60月		1548008755920 	15480087559200

兔子算法（斐波那契数列）
===================================================
性能优化
	1.稳定
	2.扩展
	3.性能

=====================================================
	网络性能
		借助工具
			Chrome 	F12 	NetWork

			YSlow 		Firefox
				a).插件 	必须有：FireBug
				b).书签 	不能测试https

			http://yslow.org/mobile/
				把YSlow按钮拖放到书签上就ok了。

			https://developer.yahoo.com/performance/rules.html#cdn=
	网络性能优化
		减少http请求
			100连接 	100请求 	100等待 	100接收
			1连接 		1请求 		1等待 		1接收
		合并文件
			减少大小

		压缩文件

		GZIP压缩

		使用CDN加速
			更快、更稳定、更安全。
		使用DNS加速

	执行性能
		有用
			1.尽量用正则操作字符串
			2.使用严格模式
			3.减少DOM操作
			4.尽量使用CSS3
			5.最好不用全局变量
			6.尽量不要使用属性

			var len = arr.length;
			for(var i=0;i<len;i++){

			}

		“没用”
 			var str = '';
 			str += 'abc';
 			str += 'bcd';
 			str += 'cde';

 			var arr = [];
 			arr.push('abc');
 			arr.push('bcd');
 			arr.push('cde');
 			arr.join('');
==================================================
面向对象 	原理你不清楚，但是不影响你使用。

面向对象
	类 		人类
	对象 	张三

===================================================
对象 	由什么组成?
	属性
	方法

	属性和变量的区别？
	属性和变量，变量谁也不属于，属性属于某个对象。

	方法和函数的区别？
	方法和函数，函数谁也不属于，方法属于某个对象。

构造函数：帮助我们创建对象的。
 		规范：首字母要大写

 	希望找到一个空白的对象
 		new Object();
 		基本上是废的。


 	问题：
 		1.没有new
 		2.方法不相等

 	new 只有两个功能：
 		1.在前面加上 	this = new Object();
 		2.在后面加上 	return this;


 	属性给构造函数加
 	方法要给构造函数的原型加
 	构造函数.prototype

 	总结：
 		属性给构造函数加
 		方法给构造函数的原型加

 		Person
 			属性
 				name 		age
 			方法
 				showName() 	showAge()

 		function Person(name,age){
 			this.name = name;
 			this.age = age;
 		}
 		Person.prototype.showName = function(){
 			return this.name;
 		};
 		Person.prototype.showAge = function(){
 			return this.age;
 		};
===================================================
人类 		Person
	属性
		name 		age 		gender
	方法
		showName() 	showAge() 	showGender()
狗类 		Dog
	属性
		name 		age 		color
	方法
		showName() 	showAge() 	showColor()
=================================================
总结：
	正则class操作
		\b 		单词边界
	垃圾回收机制
		局部 	当函数执行完毕，里面的变量消失
		全局 	只有当页面关闭时，里面的变量才会消失
		闭包 	只要里面的函数还有用，整条作用域链上的变量都不会消失

		作用域链
			作用域的走向
	递归
		思想：大事化小。
		斐波那契数列
			特点：每次都是前两次的和
	性能优化
		网络性能
		执行性能
	面向对象
		属性 		特点
			给构造函数加
		方法 		行为
			给构造函数的原型加

		this:方法属于谁，this就是谁。
===============================================
作业：
	addClass，removeClass，getByClass
	Person类、Car类
	国庆作业写完