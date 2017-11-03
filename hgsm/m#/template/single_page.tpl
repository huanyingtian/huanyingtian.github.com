<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="page_title">
    <ul>
        <!--{foreach $single_page as $volist}-->
          <li><a href="<!--{$volist.word}-->"><!--{$volist.title}--></a></li>
        <!--{/foreach}-->
    </ul>
</div>
  
<div class="page_content"><!--{$content}--></div>

<script>
     $('.news ul li').last().css('border-bottom','none');
     $('.product_cate ul li').last().css('border-bottom','none');
     $(function(){
          $('.page_title ul li a').each(function(){
              if($(this).attr('href')== document.location.href)
              {
                  $(this).css({'background':'#bcbbbb','color':'#fff'}); 
              } 
              })
         })
 </script>
<!--{/block}-->
