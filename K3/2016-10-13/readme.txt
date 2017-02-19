笔记
================================================
AngularJS
	MVVM的框架
	解决交互所带来的痛苦

	function 		angular自带的一些方法
		angular.module
		angular.equals
		angular.copy
		angular.element
		angular.forEach
		angular.isArray
		angular.uppercase
		angular.lowercase
	directive 		angular中的指令
		ng-app 			开启angular的application

		ng-model
		ng-bind
		ng-show
		ng-hide
		ng-init
		ng-repeat
		ng-click
		ng-controller

ng-repeat的时候
	如果有重复的就会报错，解决方案如下:
	ng-repeat="item in arr track by $index"

===================================================
控制器可以有多个。
控制器可以有父子级。可以继承

父级和子级之间的数据传递
	子级给父级发送数据
		$scope.$emit(名字,数据);
		$scope.$on(名字,function(event,data){
			data
		});


	父级给子级发送数据
		$scope.$broadcast(名字,数据);
		$scope.$on(名字,function(event,data){
			data
		});

===========================================
控制器写法
	app.controller(name,function($scope){
		$scope.a = 12;
	});

	app.controller(name,['$scope',function(abc){
		abc.a = 12;
	}]);

=======================================================
***一切都是数据
=======================================================
service 			服务
	$scope 		服务

脏检查
	$scope.$apply(function(){

	});
	$interval
	$timeout
=======================================================
filter 			过滤器
	过滤数据
	currency 				货币
	data 					日期
	json 					json标准写法
	limitTo 				限制
			限制条数、字数
	lowercase 				转小写
	uppercase 				转大写
	number 					千位符
	orderBy 				排序
	filter 					过滤器


	{{value|过滤器:参数}}
=====================================================
自定义过滤器
	cap 				首字母大写


	app.filter(过滤器的名字,function(){
		return function(input){
 			需要过滤的东西
		};
	});

	var str = 'welcome to zhinengshe';
	return str.replace(/\w+/g,function(str){
		return str.charAt(0).toUpperCase()+str.substring(1);
	});

==========================================
directive 		扩展html
	ng-bind
	ng-model
	ng-init
	ng-repeat


	<div ng-red></div>
==============================================
自定义指令
	app.directive(指令名,function(){
		return function(scope,element,attr){
 			scope 			ng域
 			element 		angular.element
 			attr 			属性
		};
	});

======================================================
交互
	$http.get(url,{params:{}}).success(fn).error(fn);

	https://sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su
======================================================
高级运动
	圆
	拉钩
	弹性
	碰撞
	doMove
	










