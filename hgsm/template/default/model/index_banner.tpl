<div class="banner">
<ul class="bb">
     <!--{foreach $ads_zone1 as $volist}-->
      <li>
       <a title="<!--{$volist.adsname}-->" <!--{if $volist.url != ''}-->href="<!--{$volist.url}-->" target="_blank"<!--{/if}-->>
        <img src="<!--{$volist.uploadfiles}-->" alt="<!--{$volist.adsname}-->" width="1000" height="325" />
       </a>
      </li>
     <!--{/foreach}-->
</ul>
</div>