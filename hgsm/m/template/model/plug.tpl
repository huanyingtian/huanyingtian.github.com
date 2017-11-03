<section id="mobile_share">
<h2 class="title">分享到</h2>
<div class="share_item">
  <ul>
	  <li><a href="javascript:;" data-key="weibo" class="share-link share-weibo" title="分享到新浪微博"><i></i><span>新浪微博</span></a></li>
	  <li><a href="javascript:;" data-key="renren" class="share-link share-renren" title="分享到人人网"><i></i><span>人人网</span></a></li>
	  <li><a href="javascript:;" data-key="douban" class="share-link share-douban" title="分享到豆瓣"><i></i><span>豆瓣</span></a></li>
	  <li><a href="javascript:;" data-key="qweibo" class="share-link share-qweibo" title="分享到腾讯微博"><i></i><span>腾讯微博</span></a></li>
	  <li><a href="javascript:;" data-key="qzone" class="share-link share-qzone" title="分享到QQ空间"><i></i><span>QQ空间</span></a></li>
  </ul>
</div>
</section>
 
 <script>
	 	var shareData = {
			weibo:{
				title:"新浪微博",urlTemplate:"http://service.weibo.com/share/share.php?url={url}&appkey=&title={title}&pic=&language=zh_cn"
			}
			,renren:{
				title:"人人网",urlTemplate:"http://widget.renren.com/dialog/share?resourceUrl={url}&srcUrl={url}&title={title}&description="
			}
			,douban:{
				title:"豆瓣",urlTemplate:"http://shuo.douban.com/!service/share?href={url}&name={title}"
			}
			,qweibo:{
				title:"腾讯微博",urlTemplate:"http://share.v.t.qq.com/index.php?c=share&a=index&url={url}&title={title}"
			}
			,qzone:{
				title:"QQ空间",urlTemplate:"http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={url}&title={title}&desc=&summary=&site="
			}
		};
	String.prototype.replaceAll = function(s1,s2) { 
	    return this.replace(new RegExp(s1,"gm"),s2); 
	}
	$('.share-link').on('tap', function(){
		var key = $(this).data("key");
		// alert(key);
		var h   = shareData[key];
		var url = h.urlTemplate;
		var target_url = url.replaceAll('{url}', encodeURIComponent(HOME_URL));
		var target_url = target_url.replaceAll('{title}', '祥云平台手机分享：' + encodeURIComponent(title));
		location.href = target_url;
	});
	var share = 0;
	$('.footer').on('click', '.share', function(e){
		 
		if(share == 1){
			$('#mobile_share').css('-webkit-transform','translateX(100%)');
			share = 0;
			$(this).removeClass('on');
		}else{
			$('#mobile_share').css('-webkit-transform','translateX(0)');
			share = 1;
			$(this).addClass('on');
		}
		event.stopPropagation();
	});
 </script>
