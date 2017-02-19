笔记
====================================================
面向对象
	属性 		给构造函数加
	方法 		给构造函数的原型加
=================================================
prototype 		构造函数的原型
		扩展系统函数

		arr.indexOf()
			数组有indexOf方法，但是不兼容

		str.trim()
			字符串有trim方法，但是不兼容

		oDate.getCnDay()
			获取中文星期
=====================================================
this 		具体是什么需要看调用

this是什么，需要看调用

	a)调用有不同方式，有优先级。
		高
			new 			object
			定时器 			window
			事件 			触发事件的元素
			方法 			方法属于的那个元素
			正常调用		window||undefined
		低
	b)定时器、事件只管一层

	c)一定要看最后一次调用

=====================================================
选项卡
	变量变成 			属性
	函数变成 			方法
拖拽

==================================================
typeof 				检测基本数据类型
	string 	number 	boolean 	undefined function	object

instanceof 			检测复合数据类型
	a instanceof b

constructor 		检测构造函数
	a.constructor==b
===================================================
	isString()
	isArray()
	isJson()
===================================================
万物皆对象
===================================================
诡异一
Object instanceof Function 			true
Function instanceof Object 			true
Object instanceof Object 			true
Function instanceof Function 		true

诡异二
arr instanceof Array 			true
Array instanceof Function 		true
arr instanceof Function 		false

诡异三
Object.prototype.a = 12;
var a = 5;
alert(a.a); 						12
alert(a instanceof Object); 		false


Object.prototype.a = 12;
var a = new Number(5);
alert(a.a); 						12
alert(a instanceof Object); 		true

封装类

原型链
	操作任何属性和方法时，先在对象身上找，如果找不到找构造函数，如果构造函数找不到，就找父类，一直往上找。
========================================================
面向对象
	*封装 	提取事物的核心，然后封装。
	*继承 	父类有的，子类都有，子类有的父类不一定有。父类做出改变，子类跟着变。
	多态 	多重继承，多种状态。
===================================================
继承
	适合大项目

	人类 	Person
		属性
			name 			age
		方法
			showName() 		showAge()
	工人类 	Worker
		属性
			name 			age 		job
		方法
			showName() 		showAge() 	showJob

====================================================
	矫正this
		fn(arg1,arg2...);
		fn.call(this的指向,arg1,arg2...);
		fn.apply(this的指向,[arg1,arg2...]);

	属性继承
		父类.call(this,par1,par2,par3...);
		或
		父类.apply(this,arguments);

	方法继承
		a).
			子类.prototype = 父类.prototype;

			问题:
				子类的方法，父类也有了。
		b).
			for(var name in Person.prototype){
				Worker.prototype[name] = Person.prototype[name];
			}

			问题:
				w1 instanceof Person 	false
		c).
			Worker.prototype = new Person();

			瑕疵:
				w1.constructor 			Person
		d).
			Worker.prototype = new Person();
			Worker.prototype.constructor = Worker;

属性继承
	父类.call(this,para1,para2...);
	或
	父类.apply(this,arguments);
方法继承
	子类.prototype = new 父类();
	子类.prototype.constructor = 子类;
==============================================
选项卡
	自动播放选项卡

拖拽

	限制范围拖拽
		 			fnMove()
		 			先把之前的存起来。然后在改
		 			改的时候先执行老的。
	带框的拖拽
					fnDown()
					fnMove()
					fnUp()
=====================================================
构造+原型
单例模式
命名空间
		YUI 		

解决变量名冲突：
1.封闭空间 				√
2.命名空间 				用的人少了
3.面向对象 				
4.模块化 				√
====================================================