<!-- 新闻详细 -->
<div class="news_detail">
	<h1 class="title"><!--{$download.title}--></h1>
	<div class="share">
	
	</div>
	<div class="down_info">
      <table>
      <thead>
        <tr><th>发布时期</th><th>发布来源</th><th>下载次数</th><th>文件类型</th><th>文件大小</th></tr>
      </thead>
      <tbody>
      <tr>
          <td><span><!--{$download.timeline|date_format:"%Y-%m-%d"}--></span></td>
          <td><span><!--{$source_url}--></span></td>
          <td><span><!--{$download.downs}-->次</span></td>
          <td><span><!--{$download.exten}--></span></td>
          <td><span><!--{$download.filesize}--></span></td>
       </tr>
       <tr>
         <td colspan="5"><a href="<!--{$download.downurl}-->" id="download">点击下载</a></td>
       </tr>
        </tbody>
      </table>   
	</div>
	<div class="content" id="down_detail">
	  <div class="title"><strong>详细介绍</strong></div>
	  <div class="text"><!--{$download.content}--></div>
	</div>
   <div class="page">上一篇：<!--{$previous_item}--><br />下一篇：<span><!--{$next_item}--></span></div>
</div>