<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/run.php';
require 'admin.inc.php';
$comeform	= Core_Fun::rec_post('comeform');
$inputname	= Core_Fun::rec_post('inputname');
echo("<html>");
echo("<head>");
echo("<title>上传附件</title>");
echo("<meta http-equiv='Content-Type' content='text/html; charset=".PHPOE_CHARSET."'>");
echo("<script language='javascript'>");
echo("<!--");
echo("function mysub(){");
echo("  esave.style.visibility='visible';");
echo("}");
echo("-->");
echo("</script>");
echo("</head>");
echo("<body bgcolor='#FFFFFF' text='#000000' margin='0px'>");
echo("<form name='form1' method='post' action='annexaction.php' enctype='multipart/form-data' style='margin:0px'>");
echo("<div id='esave' style='position:absolute; top:18px; left:40px; z-index:10; visibility:hidden'>");
echo("<table width='340' border='0' cellspacing='0' cellpadding='0'>");
echo("  <tr>");
echo("    <td width='20%'></td>");
echo("	<td bgcolor='#104A7B' width='60%'>");
echo("	  <table width='100%' height='120' border='0' cellspacing='1' cellpadding='0'>");
echo("	    <tr>"); 
echo("          <td bgcolor='#eeeeee' align='center'><font color=red>uploading...</font></td>");
echo("	    </tr>");
echo("	  </table>");
echo("    </td>");
echo("	<td width='20%'></td>");
echo("  </tr>");
echo("</table>");
echo("</div>");

echo("<table width='400' border='0' cellspacing='1' cellpadding='1' align='center' bgcolor='#CCCCCC'>");
echo("  <tr>");
echo("    <td height='22' align='center' valign='middle' bgcolor='#f1f1f1' width='400'>&nbsp;<font size='2'>上传附件</font>");
echo("      <input type='hidden' name='comeform' value='$comeform'>");
echo("      <input type='hidden' name='inputname' value='$inputname'>");
echo("      <input type='hidden' name='action' value='saveupload'>");
echo("    </td>");
echo("  </tr>");
echo("  <tr align='center' valign='middle'>");
echo("    <td align='left' id='upid' height='80' width='400' bgcolor='#FFFFFF' style='padding-left:5px'> <font size='2'>选择文件:</font><input type='file' name='upfile' style='width:300'  class='wenbenkuang' value=''><br><font size='2'>上传文件不得大于20M！</font><br><font size='2'>支持xls,doc,txt,pdf,rar,jpg,gif等文件格式</font>");
echo("    </td>");
echo("  </tr>");
echo("  <tr align='center' valign='middle'>");
echo("    <td bgcolor='#f1f1f1' height='24' width='400'><input type='submit' name='Submit' value='开始上传' class='go-wenbenkuang' onClick=\"javascript:mysub()\"></td>");
echo("  </tr>");
echo("</table>");
echo("</form>");
echo("</body>");
echo("</html>");
?>