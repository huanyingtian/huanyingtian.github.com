<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$page_charset}-->" />
<title>站点设置</title>
<meta name="author" content="<!--{$copyright_author}-->" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/other.css" media="screen" />
<script type='text/javascript' src='js/jquery-1.8.3.min.js'></script>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src='../data/editor/kindeditor.js'></script>
<script src="js/datepicker/WdatePicker.js"></script>
</head>
<body>
<!--{if $action == ''}-->
<div class="main-wrap">
  <form name="myform" method="post" action="xycms_setting.php">
  <input type="hidden" name="action" value="savesetting" />
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>统计设置</p></div>
  <div class="main-cont">
    <div>
	<div class="set-area">
	  <div class="form web-info-form">
		<div class="form-row">
		  <label for="declare" class="form-field">流量统计代码</label>
		  <div class="form-cont"><textarea name="tjcode" id="tjcode" class="input-area area-s4 code-area" style="width:580px;height:60px;"><!--{$config.tjcode}--></textarea></div>
		</div>
		<div class="form-row">
		  <label for="declare" class="form-field">统计跳转链接</label>
		  <div class="form-cont"><input name="tj_url" id="tj_url" class="input-txt" type="text" value="<!--{$config.tj_url}-->" style="width:580px;" /></div>
		</div>
		<div class="form-row">
		  <label for="declare" class="form-field">产品分类<br />Descri模板</label>
		  <div class="form-cont"><textarea name="pcate_d" id="pcate_d" class="input-area area-s4 code-area" style="width:580px;height:40px;" ><!--{$config.pcate_d}--></textarea></div>
		</div>
		<div class="form-row">
		  <label for="declare" class="form-field">产品详细<br />Descri模板</label>
		  <div class="form-cont"><textarea name="plist_d" id="plist_d" class="input-area area-s4 code-area" style="width:580px;height:40px;" ><!--{$config.plist_d}--></textarea></div>
		</div>    
		<div class="form-row">
		  <label for="declare" class="form-field">分类<br />Descri模板</label>
		  <div class="form-cont"><textarea name="pdetail_d" id="pdetail_d" class="input-area area-s4 code-area" style="width:580px;height:40px;" ><!--{$config.pdetail_d}--></textarea></div>
		</div> 
		<div class="form-row">
		  <label for="declare" class="form-field">详细页<br />Descri模板</label>
		  <div class="form-cont"><textarea name="pdetail_page" id="pdetail_page" class="input-area area-s4 code-area" style="width:580px;height:40px;" ><!--{$config.pdetail_page}--></textarea></div>
		</div>
		
		<div class="form-row">
		  <label for="declare" class="form-field">防复制代码</label>
		  <div class="form-cont"><textarea name="copy" id="pdetail_d" class="input-area area-s4 code-area" style="width:580px;height:60px;" ><!--{$config.copy}--></textarea></div>
		</div> 
       <div class="btn-area"><input type="submit" name="btn_save" class="button" value="更新保存" /></div>     
	  </div>
	</div>
   </div>     
  </div>
  </form>
</div>

<!--{elseif $action == 'config'}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>站点设置</p></div>
  <div class="main-cont">
    <form name="myform" method="post" action="xycms_setting.php">
    <input type="hidden" name="action" value="saveconfig" />
	<table class='table_form'> 
		<tr>
			<th width="110">网站地址：</th> 
			<td><input name="siteurl" id="siteurl" class="input-txt" type="text" value="<!--{$config.siteurl}-->" /><span id="dsiteurl"></span><p class="form-tips"></p></td>
		</tr>
		<tr>
			<th>手机站绑定域名：</th> 
			<td><input name="murl" id="murl" class="input-txt" type="text" value="<!--{$config.murl}-->" /><span id="dsiteurl"></span><p class="form-tips"></p></td>
		</tr>
		<tr>
			<th>是否开启301：</th>
			<td>  	 
				<label><input class="radioes" type="radio" name="open301" value="1" <!--{if $config.open301==1}-->checked="checked"<!--{/if}--> /> 开启</label>&nbsp;&nbsp;
				<label><input class="radioes" type="radio" name="open301" value="0" <!--{if $config.open301==0}-->checked="checked"<!--{/if}--> /> 关闭</label>
			</td>
		</tr>
		<tr>
			<th>版本切换</th>
			<td>  	 
				<label><input type="radio" name="fuxing" value="fuxing" <!--{if $version=='fuxing'}-->checked="checked"<!--{/if}--> /> 福星</label>&nbsp;&nbsp;
				<label><input type="radio" name="fuxing" value="xiangyun" <!--{if $version=='xiangyun'}-->checked="checked"<!--{/if}--> /> 祥云</label>
			</td>
		</tr>
		<tr>
			<th>是否开启Powered：</th>
			<td>  	 
				<label><input type="radio" name="copyr" value="true" <!--{if $copyr=='true'}-->checked="checked"<!--{/if}--> /> 打开</label>&nbsp;&nbsp;
				<label><input type="radio" name="copyr" value="false" <!--{if $copyr=='false'}-->checked="checked"<!--{/if}--> /> 关闭</label>
			</td>
		</tr>
		<tr>
			<th>语言版本：</th> 
			<td><label>前台是否开启语言版本：<input type="checkbox" name="translate" id="translate" value="1" <!--{if $config.translate==1}-->checked="checked"<!--{/if}--> /></label></td>
		</tr>
		<tr>
			<th>门店标注：</th> 
			<td><label>是否开启门店标注：<input type="checkbox" name="tagging" id="tagging" value="1" <!--{if $config.tagging==1}-->checked="checked"<!--{/if}--> /></label></td>
		</tr>
	    <tr>
			<th>网站版本：</th> 
			<td>
			<select name='version' id='version'>
				<option value=''> ==请选择套餐版本== </option>
				<!--{foreach $version_arr as $val}-->
                    <option value='<!--{$val}-->'><!--{$val}--></option>
				<!--{/foreach}-->
			</select> 
		</td>
		</tr>
		<tr>
		  <th>网站开始时间<span class="f_red"></span></th>
		  <td><input type="text" onclick="WdatePicker()" name="timestart" id="timestart" class="input-s input1 Wdate" value="<!--{$config.timestart}-->" />
		      <span style="padding:0 5px;">网站到期时间</span>
              <input type="text" onclick="WdatePicker()" name="timeend" id="timeend" class="input-s input1 Wdate" value="<!--{$config.timeend}-->" />
		  </td>
	    </tr>	  	  	  	   	  	   	  	  	  	  
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>	  
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<script>
   $("#version option[value='<!--{$config.version}-->']").attr("selected", true);
</script>

<!--{elseif $action == 'img'}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：缩略图配置<span>&gt;</span>高级设置</p></div>
  <div class="main-cont">
    <form name="myform" method="post" action="xycms_setting.php">
    <input type="hidden" name="action" value="setimg" />
	<table class='table_form'> 
	  <tr>
	   <th width="120">默认缩略图大小：</th> 
	   <td>宽： <input class="input-text" type="text" name="thumbwidth" id="thumbwidth" size="5" value="<!--{$config.thumbwidth}-->" /> 像素（px） ， 高： <input class="input-text" type="text" name="thumbheight" id="thumbheight" size="5" value="<!--{$config.thumbheight}-->" /> 像素（px） ，图片比率： <input class="input-text" type="text" name="ratio" id="ratio" size="5" value="<!--{$config.ratio}-->" /> 倍 </td>
	  </tr>	  
	  <tr>
	   <th>全站图片大小：</th> 
	   <td>
	   	宽：<!--{$config.uploadwidth}--> 像素（px） ， 高：<!--{$config.uploadheight}--> 像素（px）
	   </td>
	  </tr>
	  <tr>
		<th></th>
		<td>
			<input type="submit" name="btn_save" class="button" value="更新保存" />
		</td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>

<!--{elseif $action == 'set'}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>站点设置</p></div>
  <div class="main-cont">
	<h3 class="title title_padding"><span class="pro_hover">站点设置</span><span>高级信息</span></h3>
    <form name="myform" id="myform" method="post" action="xycms_setting.php">
    <input type="hidden" name="action" id="action" value="saveset" />
	<table class='table_form tab_forms'>
		<tr>
			<th width="80">网站名称：</th> 
			<td><input name="sitename" id="sitename" class="input-txt" type="text" value="<!--{$config.sitename}-->" /><span id="dsitename"></span></td>
		</tr>
		<tr>
			<th width="80">后置长尾词：</th> 
			<td>
				<input name="tailword" id="tailword" class="input-txt" type="text" value="<!--{$config.tailword}-->" />
				<a class="tag-update" href="javascript:void(0)">整站更新长尾词</a>
				<span class="tag-state"></span>
				<span id='dtag' class='new_post'>长尾词最多3个，以英文 ',' 逗号分开</span>
			</td>
		</tr>		
		<tr>
			<th>备案号码：</th> 
			<td><input name="icpcode" id="icpcode" class="input-txt" type="text" value="<!--{$config.icpcode}-->" /><span id="dicpcode"></span></td>
		</tr>
		<tr>
			<th>手机版直拨电话：</th> 
			<td><input name="phone" id="phone" class="input-txt" type="text" value="<!--{$config.phone}-->" /><span id="dicpcode"></span><span class="tips">&nbsp;&nbsp;&nbsp;</span></td>
		</tr>
		<tr>
			<th width="110">询盘手机绑定：</th> 
			<td><input name="tel" id="tel" class="input-txt" type="text" value="<!--{$config.tel}-->" /><span>&nbsp;&nbsp;&nbsp;</span></td>
		</tr> 	  	  	 	
		<tr>
			<th>留言到手机：</th> 
			<td><label>留言是否发布到手机：<input type="checkbox" name="message_tel" id="m_tle" value="1" <!--{if $config.message_tel==1}-->checked="checked"<!--{/if}--> /></label></td>
		</tr>
		<tr>
			<th>防复制代码：</th> 
			<td><label>是否开启防复制代码：<input type="checkbox" name="copynum" id="copy" value="1" <!--{if $config.copynum==1}-->checked="checked"<!--{/if}--> /></label></td>
		</tr>
		<tr>
			<th>技术支持：</th> 
			<td>
				名称：<input name="agent_name" id="tj_url" class="input-txt input2" type="text" value="<!--{$config.agent_name}-->" />
				网址：<input name="agent_url" id="tj_url" class="input-txt input2" type="text" value="<!--{$config.agent_url}-->" />
			</td>
		</tr>
		<tr>
			<th>业务代表：</th> 
			<td>
				姓名：<input name="business" id="business" class="input-txt input2" type="text" value="<!--{$config.business}-->" />
				电话：<input name="serviceline" id="serviceline" class="input-txt input2" type="text" value="<!--{$config.serviceline}-->" />
			</td>
		</tr>
		<tr style="height:40px;">
			<th>产品首页分类列表：</th> 
			<td><label>产品首页是否显示分类列表页：<input type="checkbox" name="custom_tel" id="cus_tle" value="1" <!--{if $config.custom_tel==1}-->checked="checked"<!--{/if}--> />&nbsp;&nbsp;</label></br>
			<span id="categorylist">分类显示产品数：
				<input name="categorynumber" style="width:50px;" id="categorynumber" class="input-txt input2" type="text" size='5' value="<!--{$config.categorynumber}-->" />
			</span>
			</td>
			<script type="text/javascript">
			  $(function(){
			  	if($("#cus_tle").prop("checked") == false){
			  		$("#categorylist").hide();
			  	}else{
			  		$("#categorylist").show();
			  	}
			  	$("#cus_tle").change(function(){
			  		if($("#cus_tle").prop("checked") == true){
			  			$("#categorylist").show(300);
			  		}else{
			  			$("#categorylist").hide(300);
			  		}
			  	});
			  	$('.tag-update').on('click', function(){
			  		var urlPath = window.location.href;
			  		var urlArr  = urlPath.split("?");
			  		var urlSet  = urlArr[0] + '?action=tagupdate';
			  		var tagText = $("#tailword").val();
			  		$.ajax({
			  			type: "GET",
		  				url: urlSet,
		  				data: {"tailword": tagText},
		  				success: function(data){
		  					if(data == 1) {
		  						$('.tag-state').text("更新成功！").fadeIn(500).delay(1000).fadeOut("slow");
		  					}else {
		  						$('.tag-state').text("更新失败，请再次更新！").fadeIn(500).delay(1000).fadeOut("slow");
		  					}
		  				}
			  		});
			  	});
			  });
			</script>
		</tr>
		<tr>
			<th>产品列表页描述：</th> 
			<td><textarea name="prodescription" id="prodescription" class="input-area area-s4 code-area" style="width:553px;height:60px;"><!--{$config.prodescription}--></textarea><span>描述字数不要大于150个字符！</span>
			</td>
		</tr>	 
        <tr>
			<th>百度商桥：</th> 
			<td><textarea name="bridge" id="pdetail_d" class="input-area area-s4 code-area" style="width:553px;height:60px;"><!--{$config.bridge}--></textarea>
			</td>
		</tr>	
 	  	 	
		<tr>
			<th>分页数量</th>  
			<td>
			<div class="pagecount">	
				新闻：每页  <input type='text' name='newspagesize' id='newspagesize' size='5' value="<!--{$config.newspagesize}-->" />
				<span>产品：</span>每页 <input type='text' name='productpagesize' id='productpagesize' size='5' value="<!--{$config.productpagesize}-->" />
				<span>案例：</span>每页 <input type='text' name='casepagesize' id='casepagesize' size='5' value="<!--{$config.casepagesize}-->" />
				<span>下载：每页 </span><input type='text' name='downpagesize' id='downpagesize' size='5' value="<!--{$config.downpagesize}-->" />
				<span>招聘：每页  </span><input type='text' name='jobpagesize' id='jobpagesize' size='5' value="<!--{$config.jobpagesize}-->" />
			</div>
		</td>
	    </tr>
	    <tr>
	    	<th>在线QQ客服：</th> 
	    	<td>  	 
	    		<label><input type="radio" name="qqstatus" id="qqstatus" value="1" <!--{if $config.qqstatus==1}-->checked="checked"<!--{/if}--> /> 开启</label>&nbsp;&nbsp;
	    		<label><input type="radio" name="qqstatus" id="qqstatus" value="0" <!--{if $config.qqstatus==0}-->checked="checked"<!--{/if}--> /> 关闭</label>
	   		</td>
	 	</tr> 
	    <tr>
	  		<th>底部留言：</th>
	    	<td>  	 
	    		<label><input type="radio" name="msgstatus" id="qqstatus" value="1" <!--{if $config.msgstatus==1}-->checked="checked"<!--{/if}--> /> 开启</label>&nbsp;&nbsp;
	    		<label><input type="radio" name="msgstatus" id="qqstatus" value="0" <!--{if $config.msgstatus==0}-->checked="checked"<!--{/if}--> /> 关闭</label>&nbsp;&nbsp;
	   		</td>
	  	</tr> 	 	   	  	  	  	  
	    <tr>
	   		<th>二维码：</th> 
			<td>
				<input type="hidden" name="uploadfiles_qr" id="uploadfiles" class="uploadfiles_qr"  value="<!--{$config.qr_code}-->" />
				<!--{if $config.qr_code != ''}-->
				<img class='upload_img upload_img_qr' src="../<!--{$config.qr_code}-->" />
				<!--{else}-->
				<img class='upload_img' /> 
				<!--{/if}-->
				<a href="javascript:void(0)" class="pic_remove">删除</a>
				<iframe id='iframe_t' class="iframe_t1" frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=other&is_thumb=2'></iframe>
				<script type="text/javascript">
					var t = "<!--{$config.qr_code}-->";
					if(t != ''){
		    			$('.uploadfiles_qr').siblings(".upload_img").css("display","block");
		    			$('.uploadfiles_qr').siblings(".pic_remove").css("display","block");
		    			$('.uploadfiles_qr').siblings("#iframe_t").css("display","none");
		    		}
		    	</script>		  	
			</td>
	  	</tr>
	    <tr>
	    	<th>LOGO图案：</th> 
			<td>
		    	<input type="hidden" name="uploadfiles" id="uploadfiles" class="logoimg"  value="<!--{$config.logoimg}-->" />
		    	<!--{if $config.logoimg != ''}-->
		  		<img class='upload_img' src="../<!--{$config.logoimg}-->" />
		    	<!--{else}-->
		        <img class='upload_img' /> 
		    	<!--{/if}-->
		    	<a href="javascript:void(0)" class="pic_remove">删除</a>
		    	<iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=other&is_thumb=2&index=2'></iframe>
		    	<script type="text/javascript">
		    		var t = "<!--{$config.logoimg}-->";
		    		if(t != ''){
		    			$('.logoimg').siblings(".upload_img").css("display","block");
		    			$('.logoimg').siblings(".pic_remove").css("display","block");
		    			$('.logoimg').siblings("#iframe_t").css("display","none");
		    		}
		    	</script>		  	
			</td>
	    </tr>
	    </table>
	    <table class='table_form tab_forms' style="display:none;">
			<tr>
		    	<th width="120">手机站icon图片：</th>
				<td>
			  		<input type="hidden" name="uploadfiles_icon" id="uploadfiles" class="logoimg_icon"  value="<!--{$config.icon}-->" />
			  		<!--{if $config.icon != ''}-->
			  		<img class='upload_img' src="../<!--{$config.icon}-->" />
			    	<!--{else}-->
			    	<img class='upload_img' /> 
			    	<!--{/if}-->
			    	<a href="javascript:void(0)" class="pic_remove">删除</a>
			    	<iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=m&is_thumb=2&index=3'></iframe>
			    	<script type="text/javascript">
			    		var t = "<!--{$config.icon}-->";
			    		if(t != ''){
			    			$('.logoimg_icon').siblings(".upload_img").css("display","block");
			    			$('.logoimg_icon').siblings(".pic_remove").css("display","block");
			    			$('.logoimg_icon').siblings("#iframe_t").css("display","none");
			    		}
					</script>		  	
				</td>
		    </tr>
		    <tr>
		   		<th>PC站ico图片：</th> 
				<td>
			    	<input type="hidden" name="uploadfiles_pcico" id="uploadfiles" class="logoimg_pcico"  value="<!--{$config.pcico}-->" />
			  		<!--{if $config.pcico != ''}-->
			  		<img class='upload_img' src="../<!--{$config.pcico}-->" />
			  		<!--{else}-->
			     	<img class='upload_img' /> 
			  		<!--{/if}-->
			  		<a href="javascript:void(0)" class="pic_remove">删除</a>
			  		<iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=ico&is_thumb=2&index=4'></iframe>
			  		<script type="text/javascript">
			   			var t = "<!--{$config.pcico}-->";
			    		if(t != ''){
			    			$('.logoimg_pcico').siblings(".upload_img").css("display","block");
			    			$('.logoimg_pcico').siblings(".pic_remove").css("display","block");
			    			$('.logoimg_pcico').siblings("#iframe_t").css("display","none");
			    		}
			  		</script>
				</td>
		  	</tr>	 
		  	<tr>
		    	<th>手机站LOGO图片：</th>
				<td>
			  		<input type="hidden" name="uploadfiles_webimg" id="uploadfiles" class="logoimg_webimg"  value="<!--{$config.webimg}-->" />
			  		<!--{if $config.webimg != ''}-->
			  	 	<img class='upload_img' src="../<!--{$config.webimg}-->" />
			  		<!--{else}-->
			     	<img class='upload_img' /> 
			  		<!--{/if}-->
			  		<a href="javascript:void(0)" class="pic_remove">删除</a>
			  		<iframe id='iframe_t' frameborder='0' scrolling='no' width='450' height='25' src='upload_input.php?filepath=other&is_thumb=2&index=5'></iframe>
			  		<script type="text/javascript">
			   			var t = "<!--{$config.webimg}-->";
			    		if(t != ''){
			    			$('.logoimg_webimg').siblings(".upload_img").css("display","block");
			    			$('.logoimg_webimg').siblings(".pic_remove").css("display","block");
			    			$('.logoimg_webimg').siblings("#iframe_t").css("display","none");
			    		}
			    	</script>		  	
				</td>
		    </tr>   	  	  
		    <tr>
		   		<th>水印设置：</th> 
				<td><label><input type="radio" name="watermarkflag" value="1"<!--{if $config.watermarkflag==1}--> checked<!--{/if}--> /> 是</label>，<label><input type="radio" name="watermarkflag" value="0"<!--{if $config.watermarkflag==0}--> checked<!--{/if}--> /> 否</label></td>
		  	</tr>	  
		    <tr>
		    	<th>水印文字位置：</th> 
				<td>
					<input id="text-position" name="fontpot" type="hidden" />
					<div id="img-position">
						<span class="first" data-xy='0'>随机</span>
                    	<div class="content clearfix">
                    		<span data-xy='1'>上左</span>
                    		<span data-xy='2'>上中</span>
                    		<span data-xy='3'>上右</span>
                    		<span data-xy='4'>中左</span>
                    		<span data-xy='5'>中间</span>
                    		<span data-xy='6'>中右</span>
                    		<span data-xy='7'>下左</span>
                    		<span data-xy='8'>下中</span>
                    		<span data-xy='9'>下右</span>
                    	</div>
					</div>
				</td>
		    </tr>
		    <tr>
		   		<th>文字水印属性：</th> 
				<td>
					大小：<input name="fontsize" id="fontsize" size="6" type="text" value="<!--{$watertext.fontsize}-->" />
					&nbsp;颜色：<input name="fontcolor" id="fontcolor" size="8" type="text" value="<!--{$watertext.fontcolor}-->" />
					&nbsp;字体：
					<select name='fontfamily' id='fontfamily'>
						<option value='mncjs.TTF'>迷你简粗宋</option>
						<option value='fzxzyjt.ttf'>方正新综艺简体</option>
						<option value='arial.ttf'>Arial (英文)</option>
						<option value='elephant.ttf'>elephant (英文)</option>
						<option value='Vineta.ttf'>Vineta (英文)</option>
						<option value='FetteSteinschrift.ttf'>FetteSteinschrift (英文)</option>

						
					</select>
					&nbsp;透明度：<input name="fontopa" id="fontopa" size="5" type="text" value="<!--{$watertext.fontopa}-->" />
				</td>
		  	</tr>  
		  	<tr>
		   		<th>水印文字：</th> 
				<td>
					<input name="fonttext" id="fonttext" class="input-txt" type="text" value="<!--{$watertext.fonttext}-->" />
					<span id="preview">点击预览水印效果</span>
					<div id="watermark">
						<div id="watwe-img"></div>
						<div class="content">
							<span id="closes">关闭</span>
							<span id="refresh">刷新</span>(改变水印属性后，请刷新测试效果)
						</div>
					</div>
				</td>
		  	</tr>
		  	<tr>
		   		<th>一键处理水印图片：</th> 
				<td>
					<select name='processing' id='processing'>
						<option value=''>请选择</option>
						<option value='increase'>为所有图片加水印</option>
						<option value='cancel'>取消所有图片水印</option>
					</select>
					<span id="submits">提交</span>
				</td>
		  	</tr>
	    </table>
	    <table class='table_form'>
			<tr>
				<th width="110"></th>
				<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
			</tr>	  
		</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>

<script type="text/javascript">
	$("#fontfamily option[value='<!--{$watertext.fontfamily}-->']").attr("selected", true);
    $(".title span").click(function(){
    	var index = $(this).index();
    	$(this).addClass("pro_hover").siblings("span").removeClass("pro_hover");
    	$('.tab_forms').hide();
    	$('.tab_forms').eq(index).show();
    });
    '<!--{$watertext.fontpot}-->' == '' ? fontpot = 0 : fontpot = '<!--{$watertext.fontpot}-->';
    $('#img-position span').each(function(){
    	if($(this).data('xy') == fontpot){
        	$(this).addClass('cur');
    	}
    })
    $('#text-position').val($('#img-position span.cur').data('xy'));
    $('#img-position span').click(function(){
    	$('#img-position span').removeClass('cur');
    	$(this).addClass('cur');
    	$('#text-position').val($(this).data('xy'));
    })
    $('#preview').click(function(){
    	$('#watermark').show(200);
    	ajax_img();
    })
    $('#closes').click(function(){
    	$('#watermark').hide(200);
    })
    $('#refresh').click(function(){
    	ajax_img();
    })
    
    function ajax_img(){
		var url          = 'water_img.php',
		    fontfamily   = $("#fontfamily").val(),
		    fontsize     = $('#fontsize').val(),
		    fonttext     = $('#fonttext').val(),
     		fontpot      = $('#text-position').val(),
     		fontopa      = $('#fontopa').val(),
     		fontcolor    = $('#fontcolor').val();

		$.post(url,{fontfamily:fontfamily,fontsize:fontsize,fonttext:fonttext,fontpot:fontpot,fontopa:fontopa,fontcolor:fontcolor}, function(data){
	    		$('#watwe-img').html(data);
	    });
	}
	$('#submits').click(function(){
		var    url       =    'watermark_image.php',
		    processing   = $('#processing').val();
		if(processing == ''){
        	alert('请选择处理水印图片的行为！');
		}
    	$.post(url,{processing:processing}, function(data) {
			var data = jQuery.parseJSON(data);
			if (data.success){
				alert('处理成功！');
				console.log(data.error);
			}else{
			    alert('处理失败');
			}
		});
    })
</script>
<!--{elseif $action == 'seo'}-->
<div class="main-wrap">
  <div class="path"><p>当前位置：系统设置<span>&gt;</span>站点SEO设置</p></div>
  <div class="main-cont">
    <form name="myform" method="post" action="xycms_setting.php">
    <input type="hidden" name="action" value="saveseo" />
	<table class='table_form' id="seosetting">
	  <tr>
		<th width="150">标题（Title）：</th>
		<td><input type="text" name="sitetitle" id="sitetitle" size="67" value="<!--{$config.sitetitle}-->" style="padding:6px;" />
		</td>
	  </tr>
      <tr>
		<th>主关键字（Keywords）：</th>
        <td>
         <input type="text" name="keyword1" id="keyword1" size="14" value="<!--{$keyword1}-->" style="padding:6px;" />
         &nbsp;&nbsp;<input type="text" name="keyword2" id="keyword2" size="14" value="<!--{$keyword2}-->" style="padding:6px;" />
         &nbsp;&nbsp;<input type="text" name="keyword3" id="keyword3" size="14" value="<!--{$keyword3}-->" style="padding:6px;" />
        </td>
	  </tr>
	  <tr>
			<th>网站名称（Webname）：</th>
			<td><input name="webname" id="webname" class="input-txt" type="text" value="<!--{$config.webname}-->" /></td>
	  </tr>
      <tr>
		<th>副关键字（Fkeywords）：</th>
        <td>
        <input type="text" name="f_keyword1" id="f_keyword1" size="14" value="<!--{$f_keyword1}-->" style="padding:6px;" />
        &nbsp;&nbsp;<input type="text" name="f_keyword2" id="f_keyword2" size="14" value="<!--{$f_keyword2}-->" style="padding:6px;" />
        &nbsp;&nbsp;<input type="text" name="f_keyword3" id="f_keyword3" size="14" value="<!--{$f_keyword3}-->" style="padding:6px;" /></br>
        <input type="text" name="f_keyword4" id="f_keyword4" size="14" class="f-keyword-top" value="<!--{$key.6}-->" style="padding:6px;" />
        &nbsp;&nbsp;<input type="text" name="f_keyword5" id="f_keyword5" size="14" class="f-keyword-top" value="<!--{$key.7}-->" style="padding:6px;" />
        &nbsp;&nbsp;<input type="text" name="f_keyword6" id="f_keyword6" size="14" class="f-keyword-top" value="<!--{$key.8}-->" style="padding:6px;" />
        </td>
	  </tr>
	  <tr>
		<th>描述（Description）：<br /><span style="color:#a2a2a2;line-height:30px;">最大字数为：76</span></th>
		<td><textarea name="metadescription" id="metadescription" style="width:50%;height:80px;display:;overflow:auto;font-size:12px;padding:6px;margin-right:10px;"><!--{$config.metadescription}--></textarea><span id="cc1"></span>
         <script> $("#cc1").text("当前字数为："+$("#metadescription").val().length);</script>
        </td>
	  </tr>
	  <tr>
		<th></th>
		<td><input type="submit" name="btn_save" class="button" value="更新保存" /></td>
	  </tr>
	</table>
	</form>
  </div>
  <div style="clear:both;"></div>
</div>
<script type="text/javascript">

   var nameword="<!--{$nameword}-->";
   var oldword ="<!--{$config.sitetitle}-->";
   
   function addword01(){
   	var sd=oldword.indexOf(nameword);
   	  if(sd > -1)
   	  {  
   	  	$("#sitetitle").val(oldword);
   	  }else if( sd = -1 )
   	  {
   	  	$("#sitetitle").val(oldword+nameword);
   	  }
       
   }
   function addword02(){
   	var sd=oldword.indexOf(nameword);
   	  if(sd > -1)
   	  {  
   	  	var oldwordnew=oldword.replace(nameword,"");
   	  	$("#sitetitle").val(oldwordnew);
   	  }else if( sd = -1 )
   	  {
   	  	$("#sitetitle").val(oldword);
   	  }
   }

</script>
<!--{else}-->
暂无信息
<!--{/if}-->
</body>
</html>
