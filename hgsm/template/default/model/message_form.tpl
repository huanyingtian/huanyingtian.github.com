<form class="message" action="<!--{$url_message}-->" method="post">
<input name="action" type="hidden" value="saveadd" />
<table id="message_main">
<tbody>
  <tr>
    <th>联系人： </th>
    <td>
      <span class="m_label">联系人</span>   
      <input id="name" name="name" type="text" class="m_input" />
    </td>
  </tr>
  <tr>
	<th>电话：</th>
	<td>
	<span class="m_label">座机/手机号码</span>
	<input id="contact" name="contact" type="text" class="m_input" />
	</td>
  </tr>
  <th>邮箱：</th>
  <td>
  <span class="m_label">邮箱</span>
  <input id="email" name="email" type="text" class="m_input" />
  </td>
  </tr>
  <th>地址：</th>
  <td>
  <span class="m_label">地址</span>
  <input id="address" name="address" type="text" class="m_input" />
  </td>
  </tr>
  <tr>
	<th>留言内容：</th>
	<td>
	 <span class="m_label c_label">请在此输入留言内容，我们会尽快与您联系。</span>
	 <textarea id="content" rows="2" cols="80" name="content" class="m_input"></textarea>
	</td>
  </tr>
  <tr>
	<th>验证码：</th>
	<td>
   <div id="code">
   <input id="checkcode" name="checkcode" type="text" /> 
   <img id="checkCodeImg" src="<!--{$url_index}-->data/include/imagecode.php?act=verifycode" />
   <a href="javascript:void(0)" id="change_code" onclick="changCode('<!--{$url_index}-->')">换一张</a>
     </div>
	</td>
  </tr>
  <tr>
	<th></th>
	<td><input type="submit" class="msgbtn" name="btn" value="发 送" /></td>
  </tr>
</tbody>
</table>
</form>