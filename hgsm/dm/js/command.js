/*
  $Id    : jquery for ajax更改状态值
  @params: url   发送URL
  @params: imgid 标签ID
  @params: id    ID
*/
function fetch_ajax(imgid,id)
{
	var requesturl = document.URL;
	// alert(requesturl);
	var img_on  = "xycms/images/yes.gif";
	var img_off = "xycms/images/no.gif";
    var action  = $("#attr_"+imgid+id).val();
	if(action == imgid+"close")
	{
		$("#"+imgid+id).attr("src",img_off); //变灰色按钮
		$("#attr_"+imgid+id).val(imgid+"open"); //重新赋值 为 open
		$.ajax({
			type: "POST",
			url: requesturl,
			data: "act=update&action="+action+"&id="+id+"&imgid="+imgid+"&rnd="+new Date().toString(),
	        dataType : "text",
			success: function(data) {}
		});

	}
	else
	{
		$("#"+imgid+id).attr("src",img_on);
		$("#attr_"+imgid+id).val(imgid+"close");
		$.ajax({
			type: "POST",
			url: requesturl,
			data: "act=update&action="+action+"&id="+id+"&imgid="+imgid+"&rnd="+new Date().toString(),
	        dataType : "text",
			success: function(data) {}
		});
	}
}

//鼠标经过抖动效果
$(".login-logo img,.login-user-message span a,.login-img img,.box.count ul li .info .ico").each(function(k,img){
          new JumpObj(img,8);
});

function dc() {
  var elements = new Array();
  for (var i = 0; i < arguments.length; i++) {
    var element = arguments[i];
    if (typeof element == 'string') element = document.getElementById(element);
    if (arguments.length == 1) return element;
    elements.push(element);
  }
  return elements;
}

//随机数
function getrndnum(n) {
	var chars = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	var res = "";
	for(var i = 0; i < n ; i ++) {
		var id = Math.ceil(Math.random()*35);
		res += chars[id];
	}
	return res;
}

//menu
function Menuon(ID) {
	try{dc('Tab'+ID).className='tab_on';}catch(e){}
}

//close msg
function closemsg() {
	try{dc('msgbox').innerHTML = '';dc('msgbox').style.display = 'none';}catch(e){}
}

//dmsg
function dmsg(str, id, s, t) {
	var t = t ? t : 5000;
	var s = s ? true : false;
	try{if(s){window.scrollTo(0,0);}dc('d'+id).innerHTML = '<img src="xycms/images/check_error.gif" width="12" height="12" align="absmiddle"/> '+str+sound('tip');$(id).focus();}catch(e){}
	window.setTimeout(function(){dc('d'+id).innerHTML = '';}, t);
}

//sound
function sound(file) {
	return '<div style="float:left;"><embed src="xycms/images/'+file+'.swf" quality="high" type="application/x-shockwave-flash" height="0" width="0" hidden="true"/></div>';
}

//信息全选控制
function checkAll(e, itemName){
  var aa = document.getElementsByName(itemName);
  for (var i=0; i<aa.length; i++)
  aa[i].checked = e.checked;
}

function checkItem(e, allName){
  var all = document.getElementsByName(allName)[0];
  if(!e.checked) all.checked = false;
  else{
    var aa = document.getElementsByName(e.name);
    for (var i=0; i<aa.length; i++)
     if(!aa[i].checked) return;
    all.checked = true;
  }
}

//公司概况信息全选控制
function checkAllS(e, itemName){
  var aa = document.getElementsByClassName(itemName);
  for (var i=0; i<aa.length; i++)
  aa[i].checked = e.checked;
}

function checkItems(e, allName){
  var all = document.getElementsByClassName(allName)[0];
  if(!e.checked) all.checked = false;
  else{
    var aa = document.getElementsByClassName(e.className);
    for (var i=0; i<aa.length; i++)
     if(!aa[i].checked) return;
    all.checked = true;
  }
}

//CSS背景控制 //鼠标经过效果
function overColor(Obj) {
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback_o";
		Obj.bgColor="";//颜色要改
	}
	
}

//鼠标离开效果
function outColor(Obj){
	var elements=Obj.childNodes;
	for(var i=0;i<elements.length;i++){
		elements[i].className="hback";
		Obj.bgColor="";
	}
}

function IsDigit(){
    return ((event.keyCode >= 48) && (event.keyCode <= 57));
}
function IsDigit2(){
    return ((event.keyCode >= 48) && (event.keyCode <= 57) || (event.keyCode = 46));
}

//树型结构样式(列表展开,合并效果)
function collapse(img, objName){
	var obj;
	obj = document.getElementById(objName);
	if (img.src.indexOf('open') != -1){
		img.src = img.src.replace('open', 'close');
		obj.style.display = 'none';
	}else{
		img.src = img.src.replace('close', 'open');
		obj.style.display = '';
	}
}

//只能由汉字，字母，数字组合
function checkuserstr(str){  
    var re1 = new RegExp("^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|_|[a-zA-Z0-9])*$");
	if(!re1.test(str)){
		return false;
	}else{
		return true;
	}
}

//判断字符长度，一个汉字为2个字符
function strlen(s){
	var l = 0;
	var a = s.split("");
	for (var i=0;i<a.length;i++){
		if (a[i].charCodeAt(0)<299){
			l++;
		}else{
			l+=2;
		}
	}
	return l;
}

//判断所选择数量
function check_count(id, my , num){
	var oEvent = document.getElementById('em_' + id + '_edit');
	var chks = oEvent.getElementsByTagName("INPUT");
	var count = 0;
	for(var i=0; i<chks.length; i++){
		if(chks[i].type=="checkbox"){
			if(chks[i].checked == true){
				count ++;
			}
			if(count > num){
				my.checked = false;
				alert('最多只能选择' + num + '项');
				return false;
			}
		}
	}
}

//部分功能代码

$(function() { 
 //推荐tags
 $(".f_tag a").click(function() { 
  if($(this).attr("class") != "over"){
   var a = $(this).text();
   var input = $("#tag").val();
   if(input != ''){
	  input = input+","+a;   
	 }else{
	 input = a;	 
	}
   $("#tag").val(input);
   }
}); 

//判断是源码模式和编辑模式，如果是源码模式转换成编辑模式
// $(".button").click(function(){
// 	return false;
// 	var a=editor.execCommand( 'source');
// 	alert(a);
// });
 
//更新产品排序
  $("#order_btn").click(function(){
	 if(confirm('确定更新排序吗!?')){
		 $('#action').val('orders');
		 $(".id").attr("checked",true);
		 $('#myform').submit();
		 return true;
		 }
		 return false;  
   });  

//更新案例排序
  $("#order_case").click(function(){
     if(confirm('确定更新排序吗？'))
     {
        $('#action').val('orders'); 
        $(".check").attr("checked",true);
        $('#myform').submit(); 
        return true;
     }
     return false;
  });

  $("#move_select #cid").change(function(){
	  var cateid = $(this).children('option:selected').val();
	  if(cateid == ''){
		 return false;
	  }
	  var chosen = $(".id:checked").length;
	  if(chosen == 0){
		 alert("请选择你要转移的内容！");
		 return false;
	  }
	 $("#cate").val(cateid);
	 $('#action').val('move');
	 $('#myform').submit();	 
	});

  $("#copy_select #fid").change(function(){
	  var cateid = $(this).children('option:selected').val();
	  if(cateid == ''){
		 return false;
	  }
	  var chosen = $(".id:checked").length;
	  if(chosen == 0){
		 alert("请选择你要复制的内容！");
		 return false;
	  }
	 $('#action').val('copys');
	 $('#myform').submit();	 
	});
  
 //产品分类自定义目录
  $("#word_btn").click(function(){
	  
	  var title = $("#catename").val();
	  if(!title){
		  var title2 = $("#title").val();
		  if(title2){
			  title = title2;
		  }
		  if(!title){
			  alert("名称不能为空");
			  $("#catename").focus();
			  return false;
		  }
	  }
	  $.ajax({
		  type: "POST",
		  url: "../source/core/word.php",
		  dataType: "json",
		  data: {"word":title},
		  success: function(json) {
				  var result = json.word;
				  $("#word").val(result);
		  }
	  });	  
  });
  
   //智能匹配keywords
  $("#smart_keywords").click(
  function()
  {
	  
	  var cat = $("#cid option:selected").text();
	  if(cat=="==选择==")
	  {
	  	alert("请选择产品分类！");
	  	return false;
	  }
	  // var a_cat=cat.substring(2);
	  var a_cat=cat.replace("├","");
	  
	  var title=$("#title").val();
	  if(!title)
	  {
		  
			  alert("名称不能为空");
			  $("#title").focus();
			  return false;
	  }
	  var value=a_cat+","+title+"价格,"+title+"批发";
	  $("#tag").val(value);
	  // $.ajax({
		 //  type: "POST",
		 //  url: "../source/core/keywords.php",
		 //  dataType: "json",
		 //  data: {"title":title},
		 //  success: function(json) {
			// 	  var result = json.result;
			// 	  $("#tag").val(result);
		 //  }
	  // });	  
  });

     //新闻智能匹配keywords
  $("#smart_keywordsnew").click(
  function()
  {
	  
	  var title = $("#title").val();
	  if(!title)
	  {	  
			  alert("名称不能为空");
			  $("#title").focus();
			  return false;
	  }
	  $.ajax({
		  type: "POST",
		  url: "../source/core/keywords.php",
		  dataType: "json",
		  data: {"title":title},
		  success: function(json) {
				  var result = json.result;
				  $("#tag").val(result);
		  }
	  });	  
  });
  
       //手动关键词智能匹配keywords
  $("#smart_keywordsnews").click(
  function()
  {
	  var catename = $("#catename").val();
	  if(!catename)
	  {	  
			  alert("名称不能为空");
			  $("#catename").focus();
			  return false;
	  }
	  $.ajax({
		  type: "POST",
		  url: "../source/core/keywords.php",
		  dataType: "json",
		  data: {"title":catename},
		  success: function(json) {
				  var result = json.result;
				  $("#tag").val(result);
		  }
	  });	  
  });

  //添加产品后跳转到当前产品分类
   var cid = $("#add_cid").val();
   if(cid){
	   $("#cid option[value="+cid+"]").attr("selected",'true');
   }
  //高级信息
  var more = '<tr><td><a href="javascript:void(0)" id="more">高级信息</a></td><td></td></tr>';
  var hide = $(".product_tj tr:gt(7)");
  hide.hide();
  $(".product_tj").append(more);
  $("#more").click(function(){
	  hide.toggle(600,function(){
		  if(hide.css("display") != "none"){
			  $("#more").text("基本信息");
		  }else{
			  $("#more").text("高级信息");
		  }
	  });
  });

  //站点设置高级信息，表格样式：.senior
  var more_table = '<tr><td><a href="javascript:void(0)" id="more_table">高级信息</a></td><td></td></tr>';
  var hide_table = $(".senior tr:gt(17):not(:last)");
  hide_table.hide();
  $(".senior tr:last").before(more_table);
  $("#more_table").click(function(){
  	hide_table.toggle(600,function(){
  		if(hide_table.css("display") != "none")
  		{
  			$("#more_table").text("基本信息");
  		}else{
  			$("#more_table").text("高级信息");
  		}
  	});
  });


  
  //产品推荐和最新产品相关js
  $(".remove").click(function(){
	  var id = $(this).attr("rel");
	  var remove_li = $(this).parents("li");
	  var item = $(this).attr("type");
	  $.ajax({
		  type: "GET",
		  url: "xycms_product.php?action=remove_r",
		  dataType: "text",
		  data: {"id":id,"item":item},
		  success: function(data) {
			 if(data){
				 remove_li.remove();
				 //alert("移除成功！");
			 }else{
				 alert("移除失败！");
			 }
		  }
	  });	
  });
  //推荐和最新产品更新排序
  $(".update_orders").click(function(){
	  var id     = new Array();
	  var orders = new Array();
	  var data = '';
	  $(".remove").each(function(){
		  id.push($(this).attr("rel"));
	  });
	  $(".orders").each(function(){ 
		  data = $(this).val();
		  if(data != ''){
		      orders.push(data);  
		  }else{
			 alert("排序不能为空");
			 $(this).focus();
			 return false;
		  }
	  });
	  if(data == ''){
		  return false;
	  }
	  var item = $(".opera a:first").attr("type");
	  $.ajax({
		  type: "GET",
		  url: "xycms_product.php?action=orders_r",
		  dataType: "text",
		  data: {"id":id,"orders":orders,"item":item},
		  success: function(data) { 
			  if(data){
				  alert("更新排序成功！");
				  window.location.reload();
			  }else{
				  alert("更新排序失败！");
			  }
		  }
	  });
  });
  
  //图片上传
  $('.pic_remove').click(function(){
	  $(this).siblings('.upload_img').removeAttr("src");
	  $(this).siblings('#uploadfiles').val("");
	  $(this).siblings("#thumbfiles").val("");
	  $(this).siblings('.upload_img').css("display","none");
	  $(this).siblings('#iframe_t').attr("src",$(this).siblings('#iframe_t').attr('src'));
	  $(this).siblings('#iframe_t').css("display","block");
	  $(this).css("display","none");
  });
  
  //通用选项卡切换
  $('.tab ul li').click(function(){
		var index = $(this).index();
		$.cookie('tab', index);
		$(this).addClass('on').siblings('li').removeClass('on');
		$(this).parent().siblings('.tab_content').children('.contentlist').removeClass('on').eq(index).addClass('on');
  });
  
  
  
  
  
  
  
  
  
  
}); 

