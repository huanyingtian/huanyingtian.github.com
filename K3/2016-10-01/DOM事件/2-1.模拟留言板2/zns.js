var n = 0;

function fn() {
	// 判断输入框是否为空
	if( document.getElementById("text").value == "" ) {
		alert("没填内容，\n不能提交！");
		return false;
	}

	// 清除掉初始化文字
	if( document.getElementById("box").innerHTML == "<EM>这里会显示留言内容……</EM>" || document.getElementById("box").innerHTML == "<em>这里会显示留言内容……</em>" ) {
		document.getElementById("box").innerHTML = "";
	}	

	// 动态生成留言内容
	var p = document.createElement("p");
	p.innerHTML = ++n + ". " + document.getElementById("text").value;
	document.getElementById("box").appendChild(p);

	// 清除留言框内容
	document.getElementById("text").value = "";

	event_fn();
}

// 为留言区域添加事件
function event_fn() {
	var p = document.getElementById("box").getElementsByTagName("p");
	for( var i = 0; i < p.length; i++ ) {
		p[i].onmouseover = mouseover_fn;
		p[i].onmouseout = mouseout_fn;
		p[i].onclick = delete_fn;
	}
}

function mouseover_fn() {
	// 提示删除信息背景色
	this.style.background = "yellow";
	// 提示删除文字
	var span = document.createElement("span");
	span.innerHTML = "确定要把<strong style='color: red'>“" + this.innerHTML + "”</strong>删除？";
	this.appendChild(span);
}

function mouseout_fn() {	
	this.style.background = "#f1f1f1";
	if( document.getElementsByTagName("span")[0] ) {
		this.removeChild(document.getElementsByTagName("span")[0]);
	}
}

function delete_fn() {	
	this.parentNode.removeChild(this);
	// 返回初始化文字
	if( document.getElementById("box").innerHTML == "" ) {
		document.getElementById("box").innerHTML = "<em>这里会显示留言内容……</em>";
	}
}