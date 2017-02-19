function show(num1,num2){
	var a = num1+num2;
	function show2(a,b){
		alert(a+b);
	}
	document.onclick = function(){
		alert(show2(num2,a));
	};
}
show(6,2);