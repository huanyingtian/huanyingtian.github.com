<!--[if IE 6]>  
<style type="text/css">
#m_div{position:absolute;}
</style>  
<![endif]-->
<div id="m_div">
<div class="w_title">
	<div id="m_top"></div>
	<div id="m_mid"></div>
	<div id="m_bot">欢迎给我们留言</div>
	<a href="javascript:void(0);" class="m_close" title="最小化"></a>
</div>
<form class="message w_message" action="<!--{$url_message}-->" method="post">
	<input name="action" type="hidden" value="saveadd" />
 	<div class='index_message'>
    	<span class="m_label d_label">请在此输入留言内容，我们会尽快与您联系。</span>
		<textarea id="content" rows="2" cols="80" name="content" class="m_input"></textarea>
 	</div>
	<div class='name_input clearfix'>
    	<div class='input_left'>姓名</div>
     	<div class='input_right'>
        	<span class="m_label">联系人</span>   
        	<input id="name" name="name" type="text" class="m_input" />
    	</div>
	</div>

	<div class='name_input clearfix'>
    	<div class='input_left'>电话</div>
    	<div class='input_right'>
        	<span class="m_label">座机/手机号码</span>
	    	<input id="contact" name="contact" type="text" class="m_input" />
        </div>
    </div>

    <div class='name_input clearfix'>
    	<div class='input_left'>邮箱</div>
    	<div class='input_right'>
        	<span class="m_label">邮箱</span>
	    	<input id="email" name="email" type="text" class="m_input" />
        </div>
    </div>

    <div class='name_input clearfix'>
    	<div class='input_left'>地址</div>
    	<div class='input_right'>
        	<span class="m_label">地址</span>
	    	<input id="address" name="address" type="text" class="m_input" />
        </div>
    </div>
 
	<div id="code">
		<input id="checkcode" name="checkcode" type="text" /> 
	    <img id="checkCodeImg" src="<!--{$url_index}-->data/include/imagecode.php?act=verifycode" onclick="changCode('<!--{$url_index}-->')"  />
	</div>
 
	<div class="m_under">
		<input type="submit" class="msgbtn" name="btn" value="发送" />
    </div>
</form>
</div>
<script type="text/javascript">
$(".w_title").toggle(function(){
	$(".w_message").hide();
	$(".m_close").attr("title","最大化");	
	$(".m_close").addClass("m_open");
},
function(){
	$(".w_message").show();
	$(".m_close").attr("title","最小化");
	$(".m_close").removeClass("m_open");	
}
);
var currentid='<!--{$currentid}-->';
if(currentid!='7')
{
	switch(currentid)
	{
		case '1':
		 $('#m_top').css('background','#3cb6a2');
		 $('#m_mid').css('background','#3cb6a2');
		 $('#m_bot').css('background','#3cb6a2');
		 $('.w_message').css('border-color','#3cb6a2');
		 $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style1.png") left bottom no-repeat');
		break;

		case '2':
		  $('#m_top').css('background','#8039c5');
		  $('#m_mid').css('background','#8039c5');
		  $('#m_bot').css('background','#8039c5');
		  $('.w_message').css('border-color','#8039c5');
		  $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style2.png") left bottom no-repeat');
		break;

		case '3':
		  $('#m_top').css('background','#ffc50c');
		  $('#m_mid').css('background','#ffc50c');
		  $('#m_bot').css('background','#ffc50c');
		  $('.w_message').css('border-color','#ffc50c');
		  $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style3.png") left bottom no-repeat');
		break;

		case '4':
		  $('#m_top').css('background','#ed2b36');
		  $('#m_mid').css('background','#ed2b36');
		  $('#m_bot').css('background','#ed2b36');
		  $('.w_message').css('border-color','#ed2b36');
		  $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style4.png") left bottom no-repeat');
		break;

		case '5':
		  $('#m_top').css('background','#e4531a');
		  $('#m_mid').css('background','#e4531a');
		  $('#m_bot').css('background','#e4531a');
		  $('.w_message').css('border-color','#e4531a');
		  $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style5.png") left bottom no-repeat');
		break;

		case '6':
		  $('#m_top').css('background','#74cb17');
		  $('#m_mid').css('background','#74cb17');
		  $('#m_bot').css('background','#74cb17');
		  $('.w_message').css('border-color','#74cb17');
		  $('.w_message .msgbtn').css('background','url("<!--{$skinpath}-->images/newadd/style6.png") left bottom no-repeat');
		break;
 
	}
}
</script>