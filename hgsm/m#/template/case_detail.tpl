<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="product_detail">
    <div class="title"><!--{$single_case.title}--></div>
    <div class="img">
        <img src="<!--{$single_case.uploadfiles}-->" alt="<!--{$single_case.title}-->" />
    </div>
</div>
 
<div class="product_content">
    <div class="title">详细内容</div>
    <div class="content"><!--{$single_case.content}--></div>
    <!--{$shang}-->
</div>
<!--{/block}-->