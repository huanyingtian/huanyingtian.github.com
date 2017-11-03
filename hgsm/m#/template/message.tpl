<!--{extends file="$pathtpl/template/template.tpl"}-->

<!--{block name="content"}-->
<div class="message_div">
    <form action="<!--{$url_index}-->message1.php" id="message" method="post">
        <div class="item"><input placeholder="联系人" name="name" /></div>
        <div class="item"><input placeholder="座机/手机号码" name="contact" /></div>
        <div class="item"><textarea class="content" placeholder="留言内容" name="content"></textarea></div>
        <div class="item code">
        <input placeholder="验证码" name="verifycode" /><img id="checkcode" src="<!--{$url_index}-->imagecode.php?act=verifycode" width="100" height="36" />
        </div>
        <div class="btn"><input type="submit" class="submit" value="提交留言" /></div>
   </form>
</div>

<script>
    $('body').css('background','#e7ebe9');
    var code_src = $('#checkcode').attr('src');
    $('.item').on('click', '#checkcode', function(){
        $('#checkcode').attr('src', code_src + '&rand=' + Math.random());
    }); 
</script>
<!--{/block}-->