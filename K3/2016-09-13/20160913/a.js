// 定义一个模块
define(function(require,exports,module){
	// require 加载文件
	// exports 吐出什么
	// module 多个吐出
	var num = require('b.js');
	exports.init = function(){
		alert(num.a());
	}
	

})