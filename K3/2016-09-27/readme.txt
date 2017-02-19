笔记
=================================================
ajax
	注意：
		1.缓存问题要处理
		2.返回都是字符串，所以数据需要解析
		3.编码一定要统一
		4.不关心后缀名(后缀名是给人看的)

访问一个不存在的变量，一定是报错。
访问一个不存在的属性，一定是undefined。
if条件可以判断真假，但是不能判断报错。


自己写ajax
	1.创建ajax对象
		var oAjax = new XMLHttpRequest();
		不兼容 	IE6

		var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
		兼容IE6、7、8

		兼容写法:
		if(window.XMLHttpRequest){
			var oAjax = new XMLHttpRequest();
		}else{
		 	var oAjax = new ActiveXObject('Microsoft.XMLHTTP');
		}
	2.打开连接
		oAjax.open(交互类型,url,是否异步);

		oAjax.open('GET',url,true);
	3.发送请求
		oAjax.send();
	4.接收响应
		oAjax.onreadystatechange = function(){
			//判断ajax状态
			if(oAjax.readyState==4){
				//判断http状态码
				if(oAjax.status>=200&&oAjax.status<300||oAjax.status==304){
					成功
					//响应内容
					oAjax.responseText
				}else{
					失败
				}
			}
		};
======================================================
	字符编码
		把文字转变成unicode编码
		encodeURIComponent(str); 		√
		把unicode编码变成文字
		decodeURIComponent(str);
======================================================
	ajax(url,fnSucc,fnFaild)
	ajax(url,data(String),fnSucc,fnFaild);
	ajax(url,data(JSON),fnSucc,fnFaild);


	{"t":0.3333,"act":"add","user":"lisi","pass":"123"}
	't=0.3333&act=add&user=lisi&pass=123'

	交互的方式
		ajax(url,type,data(JSON),fnSucc,fnFaild);

		GET
			oAjax.open('GET',url+'?'+data,true);
			oAjax.send();
		POST
			oAjax.open('POST',url,true);
			//设置请求头
			oAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			oAjax.send(data);

为什么封装：
	减少代码冗余、方便性、易用性、随意性

	参数合并
		ajax(json);
		ajax({
			url:'',
			type:'',
			data:{},
			success:fn,
			error:fn
		});

	ajax(json);
	ajax({
		url:'',
		type:'', 		可选
		data:{}, 		可选
		timeout:{}, 	可选
		success:fn,
		error:fn,
		loading:fn 		可选
	});
======================================================
	重新写一遍ajax
	ajax({
		url:string,
		type:string,
		data:object,
		timeout:number,
		loading:fn,
		success:fn,
		error:fn
	});
	微博留言

======================================================
	var oDate = new Date();
	oDate.toGMTString() 		统一成GMT格式
======================================================
ajax


作业
=============================================
	许愿墙 		坑多

 	
