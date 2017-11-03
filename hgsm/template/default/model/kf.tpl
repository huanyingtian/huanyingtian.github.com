<!--{if $config.qqstatus==1 && $volist_onlinechat}-->
<link rel="stylesheet" type="text/css" href="<!--{$skinpath}-->style/kf.css" />
<div class="kf clearfix">
  <div class="kf_btn">
    <span>在线客服</span>
    <div class='open'></div>
  </div>

  <div class="kf_main">
    <div class='top_bg'>
    </div>
    <div class='top_center'>
         <ul class="kf_list">
          <!--{foreach $volist_onlinechat as $value}-->
        <!--{if $value.ontype==1}-->
        <li>
           <a rel="nofollow" href="http://wpa.qq.com/msgrd?v=3&uin=<!--{$value.number}-->&site=qq&menu=yes" target="_blank" >
           <img src="<!--{$skinpath}-->images/kf/qq.png"><span><!--{$value.title}--></span>
        </a></li>
        <!--{else if $value.ontype==2}-->
        <li>
          <a rel="nofollow" target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<!--{$value.number}-->&site=cntaobao&s=1&charset=utf-8" >
            <img src="<!--{$skinpath}-->images/im/wangwang.gif" alt="<!--{$value.title}-->" /><!--{$value.title}-->
          </a>
        </li>
      <!--{else if $value.ontype==3}-->
      <li><a href="msnim:chat?contact=<!--{$value.number}-->" target="_blank" ><img src="<!--{$skinpath}-->images/im/msn.gif" alt='<!--{$value.title}-->' /><!--{$value.title}--></a></li>
    <!--{else}-->
          <li class='sky'><a href="skype:<!--{$value.number}-->?chat"><img src="<!--{$skinpath}-->images/im/skype.gif" style="border:none;" alt="Call me!" /><span><!--{$value.title}--></span></a></li>  
        <!--{/if}-->
    <!--{/foreach}-->
    </ul>
    <div class="hyperlink_a othercolor"><a href="<!--{$url_message}-->">在线留言</a></div>
    <div id='hidden_share' class="hyperlink_b othercolor"><a href="javascript:void(0)">分享到...</a></div>
      <div class='e_code'>
         <img class="code" src="<!--{$urlpath}--><!--{$config.qr_code}-->" alt="二维码" width="100" />
         <h3>扫描二维码</h3>
      </div>
     
    </div>
        <div class='bottom_bg'> </div>
      </div>
</div>


<div class="alignCenter">
  <div class="title">
      分享 <img src="<!--{$skinpath}-->images/kf/chahao.jpg">
  </div>
  <div class='content'>
     <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_mshare" data-cmd="mshare" title="分享到一键分享"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_kaixin001" data-cmd="kaixin001" title="分享到开心网"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_sohu" data-cmd="sohu" title="分享到搜狐白社会"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
  </div>
</div>


<script type="text/javascript"> 
    var href="<!--{$config.qr_code}-->";
    if(href=="")
    {
       $(".code").css("display","none");
    }
    var currentid='<!--{$currentid}-->';
    if(currentid!='7')
    {
      switch(currentid)
      {
          case '1':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/qing.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/qing1.png") left bottom no-repeat');
          $('.othercolor').css('background','#40c0ac');
          break;

          case '2':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/puper.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/puple1.png") left bottom no-repeat');
          $('.othercolor').css('background','#8838cc');
          break;

          case '3':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/kefu_yellow.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/yellow1.png") left bottom no-repeat');
          $('.othercolor').css('background','#ffc713');
          break;

          case '4':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/kefu_left.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/red1.png") left bottom no-repeat');
          $('.othercolor').css('background','#e5212d');
          break;

          case '5':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/kefu_cheng.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/cheng1.png") left bottom no-repeat');
          $('.othercolor').css('background','#e65a22');
          break;

          case '6':
          $('.kf_btn').css('background','url("<!--{$skinpath}-->images/kf/green.png") left 33px no-repeat');
          $('.top_bg').css('background','url("<!--{$skinpath}-->images/kf/green1.png") left bottom no-repeat');
          $('.othercolor').css('background','#78cf1b');
          break;
 
      }
    }
    var _windowScrollTop=0;    //滚动条距离顶端距离  
    var _windowWidth=$(window).width(); //窗口宽度  
    $(window).scroll(actionEvent).resize(actionEvent);  //监听滚动条事件和窗口缩放事件  
        //响应事件  
    function actionEvent(){  
        _windowScrollTop = $(window).scrollTop();  //获取当前滚动条高度  
     //   _windowWidth=$(window).width();//获取当前窗口宽度  
        moveQQonline();//移动面板  
    }  
        //移动面板  
    function moveQQonline(){  
                //.stop()首先将上一次的未完事件停止，否则IE下会出现慢速僵死状态，然后重新设置面板的位置。  
        $(".kf").stop().animate({  
              top: _windowScrollTop+100
             }, "fast"); 
        $('.alignCenter').stop().animate({  
              top: _windowScrollTop+133
             }, "fast"); 
    }  
$(".kf_btn").toggle(
  function()
  {
    $('.open').addClass('close');
    $('.alignCenter').hide();
    $(".kf_main").animate({width:'hide',opacity:'hide'},'normal',function(){
      $(".kf_main").hide();
      var href="<!--{$config.qr_code}-->";
      if(href==""){
        $(".code").css("display","none");
      }else{
        $('.e_code img').animate({width:'hide',opacity:'hide'});
      }
      
    });
  },
  function(){ 
    $('.open').removeClass('close');
    $(".kf_main").animate({opacity:'show'},'normal',function(){
      $(".kf_main").show();
      var href="<!--{$config.qr_code}-->";
      if(href==""){
        $(".code").css("display","none");
      }else{
        $('.e_code img').animate({opacity:'show'});
      }
      
    });
  }
);

$('#hidden_share').click(function(){
    $('.alignCenter').show();
})
$('.alignCenter .title img').click(function(){
    $('.alignCenter').hide();
})
</script>
<!--{/if}-->