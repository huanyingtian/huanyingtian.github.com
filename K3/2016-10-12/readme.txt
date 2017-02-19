笔记
=============================================
AngularJS
	MVVM框架

	致力于解决交互所带来的痛苦

面向数据
***数据就是一切
=============================================
官网:https://angularjs.org/
API文档:https://docs.angularjs.org/api

版本
	主版本.次版本.修订号
	1.7.2

	AngularJS
		1.x.x
			1.2.x
			1.3.x 		√
		2.x.x
=======================================================
function 			angular 自带的方法
	
	angular.bind 					矫正this
		var fn = angular.bind(this是谁,调动的函数,参数);
		fn();

	angular.copy  					复制对象
	angular.element 				小jquery
	angular.equals 					比较是否相等
						(NaN等于NaN)
	angular.forEach(对象,function(value,key){ 		遍历
		key 	下标、名字
		value 	值
	});

	angular.isArray 				查看是否是数组
	angular.isDate 					查看是否是日期
 	angular.lowercase 				转小写
 	angular.uppercase 				转大写

 	**angular.module 				应用模块

====================================================
directive  			指令  ng

	ng-app 				确定angular生效的范围
				整个页面中只能出现一次

	数据从哪里来
		ng-model
	数据到哪里去
		ng-bind 			不能操作input


	单向绑定
		ng-model
		ng-bind
	双向绑定
		ng-model
		ng-model


	{{}}


	ng-init 				初始化

	ng-repeat 				重复

	ng-show 				是否显示
			true 	显示  	false   不显示
	ng-hide 				是否隐藏
			true 	隐藏 	false 	显示

	ng-click 				点击

=========================================
两个环境
	原生环境 	
	ng环境 		指令

	原生环境和ng不互通

=============================================
AngularJS的特点
	双向绑定，依赖注入
	依赖注入
		只关心写法，不关心顺序
============================================
控制器 		controller

	var mk = angular.module('mk',[])
	mk.controller('main',function($scope){
 		参数必须不能改字母
	});

父子控制器之间的数据传递
	子级给父级传递数据
		发送
			$scope.emit();
		接收
			$scope.on();

	父级给子级传递数据
		发送
			$scope.broadcast();
		接收
			$scope.on();
=====================================================
