<div id="footer">
	<div class="nav_foot"><!--{$delimit_footerlink}--></div>
	<div class="copyright">
		Copyright © <!--{$copyright.site_url}--> <!--{$copyright.companyname}--> <!--{$copyright.pro}--><!--{$copyright.str_href}--><!--{$copyright.advisory}--><br><!--{$copyright.icpcode}-->&nbsp;&nbsp;<!--{$copyright.powered}--><!--{$copyright.technology}--><a rel='nofollow' href='<!--{$copyright.agent_url}-->' target='_blank'><!--{$copyright.agent_name}--></a>
	</div>
	<div><a href="<!--{$url_getkey}-->" title="热推产品">热推产品</a>&nbsp;&nbsp;|&nbsp;&nbsp;<!--{if empty($regions)}--><!--{else}-->主营区域：
	<!--{foreach $regions as $volist}-->
		<span><a href="<!--{$volist.url}-->"><!--{$volist.name}--></a></span>
	<!--{/foreach}-->
	<!--{/if}-->
	</div>
</div>

<!-- 此处为统计代码 -->
<!--{$copyright.general}-->

<!--{include file="$tplpath/model/kf.tpl"}-->
<!--{if $config.msgstatus == 1 && $current != 'message'}-->
	<!--{include file="$tplpath/model/w_message_form.tpl"}-->
<!--{/if}-->
<script>

