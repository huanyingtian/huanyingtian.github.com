<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_detail">
    <div class="title"><!--{$single_product.title}--> </div>
    <div class="img">
        <img src="<!--{$single_product.uploadfiles}-->" alt="<!--{$volist.title}-->" />
    </div>
    <div class="handin">
      <a href="<!--{$url_message}-->">在线询价</a>
    </div>
</div>
 
<div class="product_content">
    <div class="title">详细内容</div>
    <div class="content"><!--{$single_product.content}--></div>
    <!--{$shang}-->
</div>
<!--{/block}-->