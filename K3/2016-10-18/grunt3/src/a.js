var num1 = 12;
var num2 = 5;
function show (num1,num2){
	return {
		sum:function(){
			return num1+num2;
		}
	}
}
var result = show(num1,num2).sum();
alert(result);