<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>首页</title>
<link href="xycms/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="xycms/css/component.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="xycms/css/admin.css" media="screen" />
<link type="text/css" rel="stylesheet" href="xycms/css/bootstrap-datetimepicker.css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/echarts.min.js'></script>
<script type='text/javascript' src='js/jump.js'></script>
<script type='text/javascript' src='js/vue.js'></script>
<script type='text/javascript' src='js/move.js'></script>
<script type="text/javascript">
 $(document).ready(function(){
    var h1="frm_left.php?mod=content";
    var h2="frm_left.php?mod=product";
    var h3="frm_left.php?mod=info";
    var h4="frm_left.php?mod=other";
    var h5="frm_left.php?mod=other";
    var h6="frm_left.php?mod=system";
    var h7="frm_left.php?mod=system";   
    $(".btn-group div").click(function(){
     var href=$(this).attr("class");
    switch (href)
　　    {
　　     case "m1":
　　       $("#menu-frame",parent.document.body).attr("src",h1)
  　　     break;
  　　   case "m2":
　　       $("#menu-frame",parent.document.body).attr("src",h2)
  　　     break;
    　　  case "m3":
　　       $("#menu-frame",parent.document.body).attr("src",h3);
  　　     break;
      　     case "m4":
　　      $("#menu-frame",parent.document.body).attr("src",h4);
  　　     break;
      　     case "m5":
　　      $("#menu-frame",parent.document.body).attr("src",h5);
  　　     break;
      　     case "m6":
　　      $("#menu-frame",parent.document.body).attr("src",h6);
  　　    break;
      　     case "m7":
　　       $("#menu-frame",parent.document.body).attr("src",h7);
  　　     break;
　　    default:
　　      break;     
        }
     });
});
</script>
</head>
<body>
<div class="main-wrap-hom">
  <div class="home-infor">
    <div class="login-txt">
      <div class="login-user-message">
        <span>Hi,<!--{$uc_adminname}--></span>
        <span class="login-user-span-a"><em>您当前所属用户组：</em>管理员</span>
        <span class="login-user-span-a"><em>您上次登录时间：</em> <!--{$logintimeline|date_format:"%Y-%m-%d %R"}--></span>
      </div>
      <div class="login-user-message iptxt">
        <span class="login-user-span-a"><em>此次登陆IP：</em><!--{$loginip}--></span>
        <span class="login-user-span-a"><em>当前版本号：</em><!--{$copyright_version}--> </span>
        <span class="login-user-span-a"><em>技术支持：</em><i class="fa fa-mixcloud"></i><a href="http://www.cn86.cn/" alt="祥云平台" target="_blank">祥云平台</a> </span>
        <span class="login-user-span-a">
        <!--{if $config.business != ''}-->
          <em>业务代表：</em><!--{$config.business}--> 
        <!--{/if}-->
        <!--{if $config.serviceline != ''}-->
          <em>&nbsp;&nbsp;服务电话：</em><!--{$config.serviceline}--> 
        <!--{/if}-->
        </span>
        <!--{if $config.timestart != '' && $config.timeend != ''}-->
            <span class="login-user-span-a"><i class="fa fa-calendar-minus-o fa-size-big"></i><em>网站服务起止时间：</em><!--{$config.timestart}--> ~ <!--{$config.timeend}--></span>
        <!--{/if}-->
      </div>
    </div>
  </div>
  <!--{if $version != 'fuxing'}-->
  <div class="box count"> 
    <ul class="clear">
      <li>
        <div class="info">
          <span class="ico g1"><i class="fa fa-futbol-o" aria-hidden="true"></i></span>
          <p>
            <span>关键词库数量</span>
            <span class="num numa"><!--{$keywordCount}--></span>
          </p>
        </div>
        <a class="more" href="xycms_getkey.php?action=show"><i class="fa fa-plus fa-size-small"></i>查看更多</a>
      </li>
      <li>
        <div class="info">
          <span class="ico g2"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
          <p>
            <span>区域数量</span>
            <span class="num numb"><!--{$regionCount}--></span>
          </p>
        </div>
        <a class="more" href="../region/" target="_blank"><i class="fa fa-plus fa-size-small"></i>查看更多</a>
      </li>
      <li>
        <div class="info">
          <span class="ico g3"><i class="fa fa-link" aria-hidden="true"></i></span>
          <p>
            <span>友情链接数量</span>
            <span class="num numc"><!--{$linkCount}--></span>
          </p>
        </div>
        <a class="more" href="xycms_link.php"><i class="fa fa-plus fa-size-small"></i>查看更多</a>
      </li>
    </ul>
  </div>
  <!--{/if}-->
  <div class="panel panel-default mt20 chart-base">
    <div class="panel-heading">基本信息环形图</div>
    <div class="panel-body">
      <div id="main" style="width: 450px;height:330px;"></div>
    </div>
  </div>
  <div class="panel panel-default mt20 chart-base today-data">
    <div class="panel-heading">当前日期</div>
    <div class="panel-body">
      <div id="datetimepicker"></div>
    </div>
  </div>
</div>
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
$('#datetimepicker').datetimepicker({
    language: 'zh-CN', 
    weekStart: 1,
    autoclose: true,
    orientation:'right',
    minView: 'month',
});

$(".count li").last().addClass('count_last');
var myChart      = echarts.init(document.getElementById('main'));
var productCount = <!--{$productCount}-->;
var infoCount    = <!--{$infoCount}-->;
var caseCount    = <!--{$caseCount}-->;
var messageCount = <!--{$messageCount}-->;
var inquiryCount = <!--{$inquiryCount}-->;

var option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        x: 'left',
        data:['产品中心','新闻资讯','案例中心','询盘管理','友情链接']
    },
    series: [
        {
            name:'栏目信息',
            type:'pie',
            radius: ['50%', '70%'],
            avoidLabelOverlap: false,
            label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '20',
                        fontWeight: 'bold'
                    }
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:productCount, name:'产品中心',
                  itemStyle: {
                      normal: {
                          color: '#2086ee',
                      }
                  }
                },
                {value:infoCount, name:'新闻资讯',
                  itemStyle: {
                      normal: {
                          color: '#f39c11',
                      }
                  }
                },
                {value:caseCount, name:'案例中心',
                  itemStyle: {
                      normal: {
                          color: '#27ae61',
                      }
                  }
                },
                {value:messageCount, name:'询盘管理',
                  itemStyle: {
                      normal: {
                          color: '#5bc0de',
                      }
                  }
                },
                {value:inquiryCount, name:'友情链接',
                  itemStyle: {
                      normal: {
                          color: '#d9534f',
                      }
                  }
                }
            ]
        }
    ]
};
myChart.setOption(option);
</script>
</body>
</html>
