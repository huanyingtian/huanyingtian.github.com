笔记
================================================
ajax
许愿墙
	后台给的文档仅供参考。
================================================
ajax有一个特点：
	不能跨域

	跨域
	www.a.com
	www.b.com

	1.第三方授权
	2.网站有多个域名
================================================
jsonp 		可以跨域交互

	https://sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su?wd=a&cb=show

		wd 		word 		关键词
		cb 		callback 	回调函数的名字

	https://www.sogou.com/suggnew/ajajjson?key=b&type=web

	https://sug.so.360.cn/suggest?callback=show&word=a

	http://tip.zhongsou.com/ctip?callback=show&w=z

	http://www.chinaso.com/search/suggest?k=a&callback=show

	注意：回调函数必须是全局的
	注意：script标签是一次性的
		每次输入的时候都重新创建一个script标签

	封装：
		jsonp(url,success);

		替换
		str.replace('被替换的','替换成谁')

		jsonp(url,data,success);

		jsonp(url,cbName,data,success);

jsonp书写流程:
function jsonp(json){
	//参数初始值
	//如果没有url直接return
	//设置回调名字
	//超时时间(ms)
	//设置data
	//回调函数的名字(解决了缓存问题)
	//把回调函数名字中的.去掉。
	//网络超时
	//定义回调函数(全局的)
		//把网络超时干掉
		//需要把script删除
		//执行成功回调函数
	//获取head标签。
	//动态创建script
	//给script加src
	//把script插入到head标签中
}


jsonp
	跨域交互

ajax如何跨域？
	ajax不能跨域，可以使用jsonp跨域。

ajax和jsonp的区别？
	a).ajax不能跨域，jsonp可以跨域
	ajax
		使用XMLHttpRequest进行交互

	jsonp
		利用script标签可以跨域调用资源的特性，来动态的创建script标签执行服务端提供的脚本语句,实现跨域。

jsonp
	开发流程
		1.获取接口
		2.分析接口的数据格式
		3.进行交互

	90%用ajax
	9%用jsonp
	1%用form
=============================================
作业：
	ajax.js
	jsonp.js
		(写会)
	百度搜索
	许愿墙

明天：
	WebQQ