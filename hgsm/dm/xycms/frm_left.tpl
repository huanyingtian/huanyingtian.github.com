<span id="sidebar" class="open stretch" title="展开与关闭"><i class="fa fa-bars" aria-hidden="true"></i></span>
<!--{if $mod eq "index"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>首页</h3>
    <div class="menu-box" style="display:block;">
        <dd class="current">
            <a href="" rel="admincp.php?mod=main" data-title="基本信息"><i class="fa fa-database"></i><span>基本信息</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_admin.php?action=changepassword" data-title="修改密码"><i class="fa fa-key"></i><span>修改密码</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_guestbook.php" data-title="留言管理"><i class="fa fa-folder-open"></i><span>留言管理</span><em class="badge"><!--{$message_num.num}--></em></a>
        </dd>
        <dd>
            <a href="" rel="xycms_setting.php?action=set" data-title="站点设置"><i class="fa fa-gear"></i><span>站点设置</span></a>
        </dd>
  </div>
</dl>
<!--{elseif $mod eq "system"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>系统设置</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_setting.php?action=set" data-title="站点设置"><i class="fa fa-cog"></i><span>站点设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_link.php" data-title="友情链接"><i class="fa fa-link"></i><span>友情链接</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_task.php" data-title="计划任务"><i class="fa fa-picture-o"></i><span>计划任务</span></a>
        </dd>
        <!--{if $config.translate eq 1}-->
        <dd>
            <a href="" rel="xycms_translate.php" data-title="语言版本"><i class="fa fa-columns"></i><span>语言版本</span></a>
        </dd>
        <!--{/if}-->
        <dd>
            <a href="" rel="styleswitch.php" data-title="主题切换"><i class="fa fa-th"></i><span>主题切换</span></a>
        </dd>
        <dd>
            <a href="" rel="css_user.php" data-title="自定义 css"><i class="fa fa-css3"></i><span>自定义 css</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span></i>SEO设置</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_tag.php" data-title="关键词设置"><i class="fa fa-cog"></i><span>关键词设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_rss.php" data-title="RSS生成"><i class="fa fa-magic"></i><span>RSS生成</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_wzkeyword.php" data-title="标签生成"><i class="fa fa-rocket"></i><span>标签生成</span></a>
        </dd>
        <dd>
            <a href="" rel="region.php/" data-title="区域管理"><i class="fa fa-cubes"></i><span>区域管理</span></a>
        </dd>
<!--         <dd>
            <a href="" rel="xycms_getkey.php?action=configure" data-title="关键词库配置"><i class="fa fa-object-group"></i><span>关键词库配置</span></a>
        </dd> -->
        <dd>
            <a href="" rel="xycms_getkey.php?action=show" data-title="关键词库(自动)"><i class="fa fa-object-ungroup"></i><span>关键词库(自动)</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_getkey.php?action=lists" data-title="扩展词库(手动)"><i class="fa fa-pie-chart"></i><span>扩展词库(手动)</span></a>
        </dd>
    </div>
</dl>
<!--{elseif $mod eq "super"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>高级设置</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_setting.php?action=config" data-title="站点设置"><i class="fa fa-cog"></i><span>站点设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_setting.php?action=img" data-title="缩略图设置"><i class="fa fa-picture-o"></i><span>缩略图设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_setting.php?action=seo" data-title="SEO设置"><i class="fa fa-chevron-right"></i><span>SEO设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_setting.php" data-title="统计设置"><i class="fa fa-bar-chart"></i><span>统计设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_log.php" data-title="系统日志"><i class="fa fa-puzzle-piece"></i><span>系统日志</span></a>
        </dd>
        <dd>
            <a href="" rel="cache.php" data-title="缓存管理"><i class="fa fa-ellipsis-h"></i><span>缓存管理</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_link.php?action=config" data-title="友情链接库配置"><i class="fa fa-cog"></i><span>友情链接库配置</span></a>
        </dd>
    </div> 
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>风格主题</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a data-url="link" href="ace.php" target="_blank" data-title="模板文件"><i class="fa fa-laptop"></i><span>模板文件</span></a>
        </dd>
    </div>  
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>管理员</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_admin.php" data-title="管理员设置"><i class="fa fa-user"></i><span>管理员设置</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_authgroup.php" data-title="管理组设置"><i class="fa fa-user-plus"></i><span>管理组设置</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>数据库管理</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_database.php" data-title="数据备份"><i class="fa fa-database"></i><span>数据备份</span></a>
        </dd>
    </div>  
</dl>
<!--{elseif $mod eq "content"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>内容中心</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_page.php" data-title="概况管理"><i class="fa fa-file-o"></i><span>概况管理</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_pagecate.php" data-title="概况分类"><i class="fa fa-file-zip-o"></i><span>概况分类</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_delimitlabel.php" data-title="说明页列表"><i class="fa fa-file-sound-o"></i><span>说明页列表</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_ads.php" data-title="广告图片管理"><i class="fa fa-file-movie-o"></i><span>广告图片管理</span></a>
        </dd>
        <dd>
            <a href="" rel="listsp.php" data-title="碎片管理"><i class="fa fa-stack-overflow"></i><span>碎片管理</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>案例管理</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_case.php" data-title="案例列表"><i class="fa fa-photo"></i><span>案例列表</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_casecate.php" data-title="案例分类"><i class="fa fa-sitemap"></i><span>案例分类</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>下载中心</h3>
    <div class="menu-box">
        <dd>
            <a href="" rel="xycms_download.php" data-title="下载列表"><i class="fa fa-sort-amount-desc"></i><span>下载列表</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_downloadcate.php" data-title="下载分类"><i class="fa fa-sitemap"></i><span>下载分类</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>人才招聘</h3>
    <div class="menu-box">
        <dd>
            <a href="" rel="xycms_job.php" data-title="招聘列表"><i class="fa fa-street-view"></i><span>招聘列表</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_jobcate.php" data-title="招聘分类"><i class="fa fa-sitemap"></i><span>招聘分类</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_resume.php" data-title="招聘简历"><i class="fa fa-edit"></i><span>招聘简历</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>自定义页面</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_p.php" data-title="页面列表"><i class="fa fa-align-left"></i><span>页面列表</span></a>
        </dd>
    </div>
</dl>
<!--{elseif $mod eq "product"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>产品管理</h3>
    <dd>
        <a href="" rel="xycms_product.php" data-title="产品列表"><i class="fa fa-file-picture-o"></i><span>产品列表</span></a>
    </dd>
    <dd>
        <a href="" rel="xycms_productcate.php" data-title="分类列表"><i class="fa fa-sitemap"></i><span>分类列表</span></a>
    </dd>
    <dd>
        <a href="" rel="xycms_product.php?action=recommend" data-title="推荐产品"><i class="fa fa-thumbs-o-up"></i><span>推荐产品</span></a>
    </dd>
    <dd>
        <a href="" rel="xycms_product.php?action=isnew" data-title="最新产品"><i class="fa fa-bookmark"></i><span>最新产品</span></a>
    </dd>
</dl>
<!--{elseif $mod eq "info"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>新闻管理</h3>
    <dd>
        <a href="" rel="xycms_info.php" data-title="新闻列表"><i class="fa fa-indent"></i><span>新闻列表</span></a>
    </dd>
    <dd>
        <a href="" rel="xycms_infocate.php" data-title="分类列表"><i class="fa fa-sitemap"></i><span>分类列表</span></a>
    </dd>
</dl>
<!--{elseif $mod eq "other"}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>营销中心</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="" rel="xycms_guestbook.php" data-title="询盘管理"><i class="fa fa-folder-open"></i><span>询盘管理</span><em class="badge"><!--{$message_num.num}--></em></a>
        </dd>
        <dd>
            <a href="" rel="xycms_onlinechat.php" data-title="在线客服"><i class="fa fa-user-plus"></i><span>在线客服</span></a>
        </dd>
    </div>
</dl>
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>优化中心</h3>
    <div class="menu-box" style="display:block;">
        <!--{if $config.tj_url neq ""}-->
        <dd>
            <a href="" rel="xycms_seologin.php" data-title="网站统计"><i class="fa fa-bar-chart"></i><span>网站统计</span></a>
        </dd>
        <!--{/if}--> 
        <dd>
            <a href="#" onclick= "javascript:window.open('http://seo.chinaz.com/?host=<!--{$siteurl}-->');" data-title="站长工具"><i class="fa fa-ellipsis-h"></i><span>站长工具</span></a>
        </dd>
        <dd>
            <a href="" rel="tg2.html" data-title="免费推广"><i class="fa fa-map-pin"></i><span>免费推广</span></a>
        </dd>
    </div>
</dl>
<!--{if $config.tagging eq 1}-->
<dl class="menu">
    <h3><span class="fa fa-caret-right plus-change"></span>门店中心</h3>
    <div class="menu-box" style="display:block;">
        <dd>
            <a href="#" rel="xycms_map.php" data-title="门店概况管理"><i class="fa fa-map-marker"></i><span>门店概况管理</span></a>
        </dd>
        <dd>
            <a href="" rel="xycms_mapcate.php" data-title="门店分类管理"><i class="fa fa-sitemap"></i><span>门店分类管理</span></a>
        </dd>
    </div>
</dl>
<!--{/if}-->
<!--{/if}-->
<script type='text/javascript' src='js/command.js'></script>
<script type="text/javascript">
$(function(){
    //展开和关闭左侧导航
    $('#sidebar').on('click',function(){
        var left_menu = document.getElementById("left_menuchange");
        var notice    = document.getElementById('message-notice');
        if($(this).data('clicknum') == 1) {
            startMove(left_menu, "width", parseInt($(this).data('main_width')));
            $('#logo-back').show();
            $('.menu dd > a').css("paddingLeft", "35px");
            $(this).data('clicknum', 0);
            $('#message-notice').hide();
            $(this).find('i').removeClass('change');
        }else{
            $(this).data('main_width', $('.left_menu').css('width'));
            startMove(left_menu, "width", 40);
            $('#message-notice').show();
            $('#logo-back').hide();
            $('.menu dd > a').css("paddingLeft", "15px");
            $('.menu dd').hover(function(){
                var text = $(this).find('a').data('title');
                var top  = this.offsetTop;
                $('#message-notice').find('span').text(text);
                top+= 46;
                startMove(notice, 'top', top);
            },function(){
                startMove(notice, 'top', -40);
            });
            $(this).data('clicknum', 1);
            $(this).find('i').addClass('change');
        }
    });
});
</script>