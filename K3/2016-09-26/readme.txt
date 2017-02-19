笔记
===============================================
姓名： 	文强 强子 	小强 	(Eric)
年龄： 	16
手机：	13718079028
QQ： 	1677160576
===============================================
交互
 	浏览器和服务器之间的数据传递

 	form 		向服务器提交数据
 		action 		url地址
 		method 		提交方式 		(默认是get提交方式)
 			GET
 				明文提交 	容量(32KB) 	有缓存 	速度快
 				cache
 			POST
 				密文提交 	容量(1GB) 	没有缓存 速度慢

 		input 	必须有name属性
 		submit 	按钮

=======================================================
form交互，已经逐步的退出了舞台
	
form缺点:
1.会刷新页面,用户体验不好,流量（钱）
2.不能从服务器取数据
=============================================
ajax 	Asynchronous Javascript And XML
 		异步 		 javascript 和 	XML
		异步javascript和XML

		无刷新从服务器取数据

===================================================
ajax
	必须得配合服务器环境玩。
	调用函数
		地址 成功的回调函数 	失败的回调函数
	ajax(url, fnSucc,       	fnFaild)

回调函数
	这个函数你只需要定义，不需要关心调用
oBtn.onclick = function(){};

setTimeout(fn,ms);

addWheel(obj,fn);
====================================================
注意：
	1.获取到的所有的数据都是字符串
		解析json数据
		a).eval('('+result+')');				√
		b).new Function('return '+result)();
	2.注意编码
		编码要统一：(推荐使用UTF-8)

	3.
		不关心后缀名
	4.
		缓存问题
		访问同一个地址会触发
		http://www.a.com/1.html?t=1 		
		http://www.a.com/1.html?t=2
		http://www.a.com/1.html?t=3

		?t=Math.random()

		?t=new Date().getTime()

		'a.txt?t='+Math.random()

总结：
	1.返回的都是字符串
	2.注意编码统一
	3.不关心后缀名
	4.有缓存
		t=Math.random()
============================================
ajax最难的地方度过了。
	局部刷新

	造假数据

	随机排序
	arr.sort(function(){
		return Math.random()-0.5;
	});
=================================================
后台会提供接口
=================================================
手写ajax文件:

打电话:
1.捡一个手机
2.建立连接
3.发送
4.接收
=============================================
写ajax
1.创建一个ajax对象
	var oAjax = new XMLHttpRequest();
	不兼容: 	不兼容IE6

	var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
	不兼容: 	只兼容IE6、7、8


	兼容写法:
		if(window.XMLHttpRequest){
			var oAjax = new XMLHttpRequest();
		}else{
			var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
		}

2.打开连接
	oAjax.open(交互类型,url,是否异步);

				必须大写
	oAjax.open('GET','a.txt',true);

 			现实 				程序
	同步 	同时做多件事 		只能做一件事
	异步 	同时只能做一件事 	同时能做多件事


3.发送数据
	oAjax.send();
4.接收数据
	oAjax.onreadstatechange = function(){
		//判断ajax状态,等于4是成功
		if(oAjax.readyState==4){
			//判断http状态是否成功
			if(oAjax.status>=200&&oAjax.status<300||oAjax.status==304){
				//成功
				//响应内容
				oAjax.responseText
			}else{
				//失败
			}
		}
	};

	ajax状态
	0 	准备成功，未发送
	1 	发送成功
	2 	接收原始数据完成
	3 	解析原始数据完成
	4 	完成

=================================================
ajax
	无刷新从服务器取数据

	注意：
	1.注意编码统一
	2.有缓存
	3.返回都是字符串
	4.不关心后缀名

	处理缓存 	t=Math.random()

	徒手写ajax
		1.创建ajax对象
			var oAjax = new XMLHttpRequest();
			不兼容IE6

			var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
			兼容IE6、7、8
		2.打开连接
			oAjax.open('GET',url,true);
		3.发送请求
			oAjax.send();
		4.接收响应
			oAjax.onreadystatechange = function(){
				判断ajax状态
				if(oAjax.readyState==4){
					判断http状态
					if(oAjax.status>=200&&oAjax.status<300||oAjax.status==304)
				}{
					oAjax.responseText
				}else{
					失败
				}
			};
================================================
百度新闻+百度百科
用户注册+登
微博留言（选做）






































