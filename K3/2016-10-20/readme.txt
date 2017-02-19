笔记
===================================================
1.
	if(window.XMLHttpRequest){
		var oAjax = new XMLHttpRequest();
	}else{
	 	var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
	}
2.
	oAjax.open();
	oAjax.send();
	oAjax.readyState
	oAjax.status
	oAjax.responseText
3.
	200 		成功
	304 		未修改
	404 		没有找到资源
4.
	大于等于200，小于300，或者是304
5.
	encodeURIComponent
	decodeURIComponent
6.
	0 		准备成功，未发送
	1 		发送成功
	2 		接收原始数据成功
	3 		解析成功
	4 		完成
7.
	异步 		非阻塞
			可以同时做多件事
	同步		阻塞
			同时只能做一件事
8.
	get
		明文 	大小32KB 	有缓存 		速度快
	post
		密文 	大小1GB 	没有缓存 	速度慢

9.	使用jsonp
	
10.
	function trim(str){
		return str.replace(/^\s+|\s+$/g,'');
	}

11.
	/^[a-zA-Z]\w{5,17}$/

12.
	function strLength(str){
		var count = 0;
		for(var i=0;i<str.length;i++){
			if(str.charCodeAt(i)>=19968&&str.charCodeAt(i)<=40869){
				count+=3;
			}else{
				count++;
			}
		}
		return count;
	}
13.
	oAjax.responseText;

14.
	var str='20151125' 	2015年11月25日
	str.replace(/2015/,'2015年').replace(/11/,'11月').replace(/25/,'25日');

15.
	座机
		/^0[1-9]\d{1,2}\-[1-9]\d{6,7}$/
	邮箱
		/^\w+\@[a-zA-Z0-9\-]+(\.[a-zA-Z]{2,6}){1,2}$/

16.
	baidu.com 
	www.baidu.com
	www.baidu.com/ 
	http://www.baidu.com
	https://www.baidu.com
	ued.baidu.com
	xxx.ued.bbs.baidu.com	


	协议 		可以出现可以不出现
	(http(s)?\:\/\/)?
	子域名
	([a-zA-Z0-9\-]+\.)*
	一级域名
	[a-zA-Z0-9\-]+
	域名后缀
	(\.[a-zA-Z]{2,6}){1,2}
	目录
	(\/)?
	/^(http(s)?\:\/\/)?([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+(\.[a-zA-Z]{2,6}){1,2}(\/)?$/

17.
	var re = new RegExp('\\b'+hello+'\\b');

18.
	\b 	\d \s 	\w 	\W 	\S 	\D 	.
	\n 	\t

19.
	/^\d+$/.test(oInp.value);

20.
	var str='i love javascript';
	str = str.replace(/\w+/g,function(str){
		return str.charAt(0).toUpperCase()+str.substring(1);
	});

21.
	var str='fuck shit I say nimei';
	str = str.replace(/fuck|shit|nimei/g,function(str){
		var tmp = '';
		for(var i=0;i<str.length;i++){
			tmp+='*';
		}
		return tmp;
	});

22.
	echo 
23.
	'abc'.'bcd'
24.
	smarty php 模板引擎。用php编写的，实现代码分离
	MVC框架

25.
	


不能请假
不能玩手机
必须上晚自习
不能玩游戏。。看电视。。。。。
讲东西的时候，把手头东西放下。

==============================================
问题总结
=================================================
jquery中的animate与stop什么时候一起出现
	一直一起出现
jquery on.off事件绑定、解绑、事件委托的写法
	$().on('event',['select'],function(){

	});
	
jquery插件
jquery的应用不熟练
=======================================================
找10-20个例子，写
=======================================================
ajax、jsonp获取数据的方式，上课讲的是get方式，再讲讲post方式吧。
	jsonp没有get、post之分
	ajax({
		url:URL,
		type:'get',
		data:{
			a:12,
			b:5
		},
		success:function(res){
			var json = eval('('+res+')')
		}
	});
ajax
jsonp
================================================
字符串的方法
	str.match() 	获取 		数组
	str.search() 	查看规则在字符串中的位置
	str.replace()


	正则中replace中第二个参数function的用法
	正则中的match、search、replace有什么区别？什么时候用？
字符串中的量词
	{n} 		(苹果){13} 		有13个苹果
	{n,m} 		(苹果){n,m} 	最少有n个苹果，最多m个
	{n,} 		(苹果){n,} 		最少有n个苹果，最多不限
	? 	{0,1} 	(苹果)? 		有1个苹果或者没有苹果
	+ 	{1,} 	(苹果)+ 		最少有1个苹果，最多不限
	* 	{0,} 	(苹果)* 		没有苹果，或者有苹果
[]
	任选一个
	[abc] 			
	范围
	[a-z]
	[abcdefghijklmnopqrstuvwxyz]
	[0-9]
	[0123456789]

	[14-79] 		[145679]

	排除
	[^]
	

转义
	\d 		所有数字 			
	\w 		所有英文数字_ 			
	\s 		所有空白 	
	\D 	 	除了数字 	
	\W 		除了数字英文_
	\S 		除了空白
	. 		所有字符
	\b 		单词边界
	
校验

=================================================
cookie
	如何用?
		setCookie(name,value,iDay)
		getCookie(name)
		removeCookie(name)
	什么时候用?
		当要保存东西的时候用。
=================================================
	拖拽
	选项卡
	换肤
=================================================
