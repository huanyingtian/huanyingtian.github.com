<!-- 新闻详细 -->
<div class="job_detail">
	<h1 class="title"><!--{$job.title}--></h1>
	<div class="info_title clearfix">	
		<h3 class="title_bar">
			发布日期：<span><!--{$job.timeline|date_format:"%Y-%m-%d %H:%M"}--></span>
	 		点击：<span><script src="<!--{$urlpath}-->data/include/jobhits.php?id=<!--{$job.id}-->"></script></span>
		</h3>
		<div class="share">
			<!-- Baidu Button BEGIN -->
			<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
				<a class="bds_tsina"></a>
				<a class="bds_qzone"></a>
				<a class="bds_tqq"></a>
				<a class="bds_hi"></a>
				<a class="bds_qq"></a>
				<a class="bds_tieba"></a>
				<span class="bds_more">更多</span>
				<a class="shareCount"></a>
			</div>
			<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6513684" ></script>
			<script type="text/javascript" id="bdshell_js"></script>
			<script type="text/javascript">
			document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
			</script>
			<!-- Baidu Button END -->	
		</div>
	</div>	
   	<div class="content">
		<h4>岗位职责</h4>
		<div class="text"><!--{$job.jobdescription}--></div>
		<h4>职位要求</h4>
		<div class="text"><!--{$job.jobrequest}--></div>
        <!--{if $job.jobotherrequest!=""}-->
          <h4>其他要求</h4>
          <div class="text"> <!--{$job.jobotherrequest}--></div>
        <!--{/if}-->
        <h4>工作地点</h4>
        <div class="text"><!--{$job.workarea}--></div>
        <h4>招聘人数</h4>
        <div class="text"><!--{$job.number}--></div>
        <h4>招聘负责人联系方式</h4>
        <div class="text"><!--{$job.jobcontact}--></div>
	</div>
	<div class="job-title">
		<a href="#" class="job-send" data-reveal-id="myModal">简历提交</a>
	</div>
	<div id="myModal" class="reveal-modal">
	    <div class="send-title">个人信息</div>
		<form class="message-job" action="<!--{$url_index}-->resume.php" method="post" enctype="multipart/form-data">
		    <input type="hidden" name="action" value="saveadd" />
		    <input type="hidden" name="joburl" value="<!--{$url_job}--><!--{$id}-->.html" />
		    <input type="hidden" name="title" value="<!--{$job.title}-->" />
		    <li class="clearfix">
				<label>姓名：</label>
		   		<input id="j-cname" type="text" name="cname" class="jobinput" />
		   		<span>*</span>
		    </li>
		    <li class="clearfix">
				<label>性别：</label>
		   		<input type="radio" name="sex" value="男" checked="checked">男
		   		<input type="radio" name="sex" value="女">女
		    </li>
		    <li class="clearfix">
				<label>电话：</label>
		    	<input id="j-tel" type="text" name="tel" class="jobinput" />
		    	<span>*</span>
		    </li>
		    <li class="clearfix">
				<label>学历：</label>
		    	<select name="education" id="education">
					<option value="初中及以下">初中及以下</option>
					<option value="高中">高中</option>
					<option value="中专">中专</option>
					<option value="大专">大专</option>
					<option value="本科">本科</option>
					<option value="研究生及以上">研究生及以上</option>
				</select>
		    </li>
			<li class="clearfix">
				<label>工作经历：</label>
				<textarea id="experience" rows="2" cols="80" name="experience" class="m_input"></textarea>
		   		<span>*</span>
		    </li>
		    <li class="clearfix">
				<label>验证码</b>：</label>
		    	<input id="checkcode" name="checkcode" type="text" /> 
				<img id="checkCodeImg" src="<!--{$url_index}-->data/include/imagecode.php?act=verifycode" />
				<a href="javascript:void(0)" id="change_code" onclick="changCode('<!--{$url_index}-->')">换一张</a>
		    	<span>*</span>
		    </li>
		    <li class="last">信息选填</li>
		 	<input type="file" id="file" name="file" value="上传简历" />
		 	<div class="resume-prompt">上传简历最大2M，DOC/PDF/XLS等常用格式，请用：职位-姓名-学</div>
	        <input type="submit" id="jobbtn" class="jobbtn" name="btn" value="提交" />
	        <input type="reset" class="jobbtn" name="btn" value="重置" />
	        <span class="last">(请填写准确有效的内容，以方便核实！)</span>
		</form>
		<a class="close-reveal-modal">&#215;</a>
	</div>
   <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>

<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/reveal.css?9.3.2" />
<script src="<!--{$skinpath}-->js/jquery.reveal.js?9.3.2"></script>
<script>
  $("#jobbtn").click(function(){
	var cname      = $("#j-cname");
	var tel        = $("#j-tel");
	var experience = $("#experience");
	var checkcode = $("#checkcode");
	
	switch (true){
		case cname.val() == '':
			alert("姓名不能为空！");
			cname.focus();
			return false;
			break;
		case tel.val() == '':
			alert("电话不能为空！");
			tel.focus();
			return false;
			break;
		case experience.val() == '':
			alert("工作经历不能为空！");
			experience.focus();
			return false;
			break;
		case checkcode.val() == '':
			alert("验证码不能为空！");
			checkcode.focus();
			return false;
			break;
	}
    var pattern = new RegExp(/^[0-9-+]+$/);
	if(!pattern.test(tel.val())){
	   alert('您输入有效电话号码！');
	   tel.focus();
	   return false;
	}
});
</script>

