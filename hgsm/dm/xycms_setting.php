<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/run.php';
require '../source/core/image.class.php';
require 'admin.inc.php';
require 'config.php';
require 'copyr.php';
$action	= Core_Fun::rec_post("action");
if(! in_array($action, array('set', 'saveset'))){
	$libadmin->checkSuper();
}
Core_Auth::checkauth("config");
switch($action){
	case 'savecache':
	    savecache();
		break;
	case 'saveseo':
	    saveseo();
		break;
	case 'seo':
	    seo();
		break;
	case 'saveconfig':
	    saveconfig();
		break;
	case 'set':
	    set();
		break;
	case 'saveset':
	    saveset();
		break;
	case 'clearcache':
	    clearcache();
		break;
	case 'savesetting':
	    savesetting();
		break;
	case 'setimg':
	    setimg();
		break;
	case 'tagupdate':
	    tagupdate();
		break;	
	default:
	    setting();
		break;
}

function setting(){
	global $config,$tpl;
	
	$logoimgname = Core_Mod::getpicname($config['logoimg']);
	$tpl->assign("logoimgname",$logoimgname);
	$tpl->assign("version",$version);
	$tpl->assign("copyr",$copyr);
}


function savesetting(){
	$tjcode			= Core_Fun::strip_post("tjcode",1);
	$tj_url			= Core_Fun::strip_post("tj_url",1);
	$pcate_d		= Core_Fun::strip_post("pcate_d",1);
	$plist_d		= Core_Fun::strip_post("plist_d",1);
	$pdetail_d		= Core_Fun::strip_post("pdetail_d",1);
	$pdetail_page	= Core_Fun::strip_post("pdetail_page",1);

	$copy		    = Core_Fun::strip_post("copy",1);
	$array	= array(
		'tjcode'=>$tjcode,
		'tj_url'=>$tj_url,
		'pcate_d'=>$pcate_d,
		'plist_d'=>$plist_d,
		'pdetail_d'=>$pdetail_d,
		'pdetail_page'=>$pdetail_page,
		'copy'=>$copy,
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","更新站点设置成功");
		msg::msge('更新成功','xycms_setting.php');
	}
}

function clearcache(){
	global $tpl;
	$tpl->clearAllCache();
	$tpl->clearCompiledTemplate();
	Core_Command::runlog("","清除网站缓存成功");
	msg::msge('网站缓存清除成功!');
}

function setimg(){
	$thumbwidth			= Core_Fun::detect_number(Core_Fun::rec_post("thumbwidth",1));
	$thumbheight		= Core_Fun::detect_number(Core_Fun::rec_post("thumbheight",1));
	$ratio		        = Core_Fun::rec_post("ratio",1);
	$uploadwidth  = $thumbwidth*$ratio;
	$uploadheight = $thumbheight*$ratio;
	$patharr[0] = "../data/images/product/";
	$patharr[1] = "../data/images/case/";
	foreach ($patharr as $num => $path) 
	{
		$img=new Image($path);
		$list = scandir($path);// 得到该文件下的所有文件和文件夹
		foreach ($list as $file) 
		{
			$file_location = $path.$file;//生成路径
			if($file!="." && $file!="..")
			{
				$str = "thumb";
				if(substr_count($file,$str) > 0)
				{
					unlink($file_location);
				}
			}
		}
		$new_list = scandir($path);
		foreach ($new_list as $key => $filename) 
		{
			if($filename!="." && $filename!="..")
			{
				$img->thumb($filename, $thumbwidth, $thumbheight);
			}
		}
	}
 
	$array	= array(
		'thumbwidth'=>$thumbwidth,
		'thumbheight'=>$thumbheight,
		'ratio'=>$ratio,
		'uploadwidth'=>$uploadwidth,
		'uploadheight'=>$uploadheight,
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","更新缩略图配置成功");
		msg::msge('更新成功','xycms_setting.php?action=img');
	}
}

function saveconfig()
{
	$siteurl		    = Core_Fun::strip_post("siteurl",1);
	$murl		    	= Core_Fun::strip_post("murl",1);
	$open301			= Core_Fun::detect_number(Core_Fun::rec_post("open301",1));
	$translate		    = Core_Fun::detect_number(Core_Fun::rec_post("translate",1));
	$tagging		    = Core_Fun::detect_number(Core_Fun::rec_post("tagging",1));
    $versionname		= Core_Fun::rec_post("version",1);
    $timestart		    = Core_Fun::rec_post("timestart",1);
    $timeend     		= Core_Fun::rec_post("timeend",1);

	$file=fopen("config.php", "w+") or die('文件version无法创建');
	$version=$_POST['fuxing'];
    $c = '<?php $version='.'"'.$version.'"; ?>';
	if(!fwrite($file,$c))
	{
		fclose($file);
		exit('注意参数无法写入配置文件！');
	}
	fclose($file);
	$file=fopen("copyr.php", "w+") or die('文件copyr无法创建');
	$copyr=$_POST['copyr'];
    $c = '<?php $copyr='.'"'.$copyr.'"; ?>';
	if(!fwrite($file,$c))
	{
		fclose($file);
		exit('注意参数无法写入配置文件！');
	}
	fclose($file);
	
	$siteurl = str_replace('http://','',rtrim($siteurl,'/'));
	$murl = str_replace('http://','',rtrim($murl,'/'));
	if(($pos = strpos($siteurl, 'gotoip')) !== false){
		$robotsurl = CHENCY_ROOT."robots.txt";
		if(file_exists($robotsurl)){
			$content = "User-agent: * 
Disallow: /";
			file_put_contents($robotsurl, $content);
		}else{
			$content = "User-agent: * 
Disallow: /";
			file_put_contents($robotsurl, $content);
		}
	}else{
		$robotsurl = CHENCY_ROOT."robots.txt";
		$content = "User-agent: * 
Disallow: /dm/
Disallow: /source/";
        file_put_contents($robotsurl, $content);
	}
	 
	$array	= array(
		'siteurl'=>$siteurl,
		'murl'=>$murl,
		'timestart'=>$timestart,
		'timeend'=>$timeend,
		'version'=>$versionname,
		'translate'=>$translate,
		'tagging'=>$tagging,
		'open301' => $open301,
	);
	write_rewrite($open301, 'apache');
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","更新站点参数设置成功");
		msg::msge('更新成功','xycms_setting.php?action=config');
	}
}
/**
 * $status_301: 开启和关闭301，默认关闭
 * $server: 服务器类型，默认是apache
 * @param unknown_type $status
 */
function write_rewrite($status_301 = 0, $server = 'apache'){
	global $config;
	$url = strtolower(rtrim(str_replace(array('http://', 'www.', ' '), '', $config['siteurl']), ' /'));
	$url1 = 'www.'.$url;
	$url2 = 'http://www.'.$url;
	// echo $url2;exit;
	$ser = array(
		'IIS8' => 'web.config',
		'apache' => '.htaccess'	
	);
	$rule = array(
		'IIS8' => '<rule name="301Redirect" stopProcessing="true"><match url="(.*)" />
	  <conditions logicalGrouping="MatchAny">
		  <add input="{HTTP_HOST}" pattern="^'.$url1.'$" />
	  </conditions>
	  <action type="Redirect" url="'.$url2.'/{R:0}" redirectType="Permanent" />
  </rule>',	
		'apache' => 'RewriteCond %{HTTP_HOST} 	 !^'.$url1.'$ [NC]
RewriteRule ^(.*)$ 		 '.$url2.'/$1 [L,R=301]'
	);
	// print_r($rule);exit;
	$file = CHENCY_ROOT."source/rewrite/$ser[$server]";

	if(!is_file($file)){
		msg::msge('确认伪静态模板文件');
	}
	$target = CHENCY_ROOT.$ser[$server];
    $target_open=file_get_contents($target);
	$content = file_get_contents($file);
	if($status_301 == 1){
		$content = str_replace("#301Redirect", $rule[$server], $content);
	}else{
		$targetn = str_replace($rule[$server],"#301Redirect", $target_open);
		file_put_contents($target, $targetn);
	}
	file_put_contents($target, $content);
	return true;
}

function set(){
	global $config,$tpl;
	//print_r();
	$tpl->assign("watertext",json_decode($config['watertext'],true));
}

function saveset(){
	global $config;
	$sitename		= Core_Fun::strip_post("sitename",1);
	$mtitle		    = Core_Fun::strip_post("sitename",1);
	$tailword		= Core_Fun::strip_post("tailword",1);
	$tailword       = rtrim($tailword, ",");
	$icpcode		= Core_Fun::strip_post("icpcode",1);
	$phone			= Core_Fun::strip_post("phone",1);
	$newspagesize		= Core_Fun::detect_number(Core_Fun::rec_post("newspagesize",1),15);
	$productpagesize	= Core_Fun::detect_number(Core_Fun::rec_post("productpagesize",1),15);
	$casepagesize	    = Core_Fun::detect_number(Core_Fun::rec_post("casepagesize",1),15);
	$jobpagesize		= Core_Fun::detect_number(Core_Fun::rec_post("jobpagesize",1),15);
	$downpagesize		= Core_Fun::detect_number(Core_Fun::rec_post("downpagesize",1),15);
	$qqstatus			= Core_Fun::detect_number(Core_Fun::rec_post("qqstatus",1));
	$categorynumber		= Core_Fun::detect_number(Core_Fun::rec_post("categorynumber",1));
	$msgstatus			= Core_Fun::detect_number(Core_Fun::rec_post("msgstatus",1)) ? Core_Fun::detect_number(Core_Fun::rec_post("msgstatus",1)) : 0;
	$qr_code			= Core_Fun::rec_post("uploadfiles_qr",1);
	$logoimg			= Core_Fun::rec_post("uploadfiles",1);
	$icon			    = Core_Fun::rec_post("uploadfiles_icon",1);
	$pcico			    = Core_Fun::rec_post("uploadfiles_pcico",1);
	$webimg			    = Core_Fun::rec_post("uploadfiles_webimg",1);
	$agent_name		    = Core_Fun::strip_post("agent_name",1);
	$agent_url		    = Core_Fun::strip_post("agent_url",1);
	$prodescription		= Core_Fun::strip_post("prodescription",1);
	$tel				= Core_Fun::strip_post("tel",1);
	$message_tel		= Core_Fun::detect_number(Core_Fun::rec_post("message_tel",1));
	$copynum		    = Core_Fun::detect_number(Core_Fun::rec_post("copynum",1));
	$custom_tel		    = Core_Fun::detect_number(Core_Fun::rec_post("custom_tel",1));
	$bridge		        = Core_Fun::strip_post("bridge",1);
    $business			= Core_Fun::rec_post("business",1);
	$serviceline		= Core_Fun::rec_post("serviceline",1);
	$watermarkflag		= Core_Fun::detect_number(Core_Fun::rec_post("watermarkflag",1));

	$watertext = array();
	$watertext['fontpot']	  = Core_Fun::rec_post("fontpot",1);
	$watertext['fontsize']	  = Core_Fun::rec_post("fontsize",1);
	$watertext['fontcolor']	  = $_POST['fontcolor'];
	$watertext['fontfamily']  = Core_Fun::rec_post("fontfamily",1);
	$watertext['fontopa']	  = Core_Fun::rec_post("fontopa",1);
	$watertext['fonttext']	  = Core_Fun::rec_post("fonttext",1);



	if(count(explode(',', $tailword)) > 3){
		msg::msge('后置长尾词最多能填写三个！');
	}
	$tailword  =str_replace("，", ",", $tailword);
	if(empty($prodescription)){
		$prodescription = $config['metadescription'];
	}
	$array	= array(
			'tel' => $tel,
			'message_tel'=>$message_tel,
			'copynum'=>$copynum,
			'custom_tel'=>$custom_tel,
			'sitename'=>$sitename,
			'mtitle'=>$mtitle,
			'tailword'=>$tailword,
			'icpcode'=>$icpcode,
			'phone'=>$phone,
			'newspagesize'=>$newspagesize,
			'productpagesize'=>$productpagesize,
			'casepagesize'=>$casepagesize,
			'jobpagesize'=>$jobpagesize,
			'downpagesize'=>$downpagesize,
			'qqstatus'=>$qqstatus,
			'msgstatus' =>$msgstatus,
			'categorynumber' =>$categorynumber,
			'qr_code'=>$qr_code,
			'logoimg'=>$logoimg,
			'icon'=>$icon,
			'pcico'=>$pcico,
			'webimg'=>$webimg,
			'agent_name'=>$agent_name,
			'agent_url'=>$agent_url,
			'prodescription'=>$prodescription,
			'bridge'=>$bridge,
			'business'=>$business,
			'serviceline'=>$serviceline,
			'watermarkflag'=>$watermarkflag,
			'watertext'=>json_encode($watertext),
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败');
	}else{
		Core_Command::runlog("","更新站点参数设置成功");
		msg::msge('更新成功','xycms_setting.php?action=set');
	}
}

function seo(){
   global $db,$config,$tpl;
   $front =$config['front'];
   $sql   ="SELECT `name` FROM ".DB_PREFIX."region order by id ASC";
   $name  =$db->getall($sql);
   $valuex =array();
   foreach ($name as $key => $value) {
      $valuex[$key]=$value['name'];
   }
   
   $tpl->assign("nameword","【".$nameword."】");
   $tpl->assign("front",$front);
}

function saveseo(){

	global $db,$config,$tpl;
	$sitetitle			= Core_Fun::strip_post("sitetitle",1);
	$front			    = Core_Fun::strip_post("front",1);
	$metadescription	= Core_Fun::rec_post("metadescription",1);
	$keyword1		    = Core_Fun::rec_post("keyword1",1);
	$keyword2	     	= Core_Fun::rec_post("keyword2",1);
	$keyword3	    	= Core_Fun::rec_post("keyword3",1);
	$webname	    	= Core_Fun::rec_post("webname",1);
    $keyword            = $keyword1.",".$keyword2.",".$keyword3;
    // print_r($GLOBALS['libadmin']);die();
	for($i=1;$i<=9;$i++){
      $f  = 'f_keyword'.$i;
      $f2 = Core_Fun::rec_post($f,1);
      if($f2 != ''){
      	$f_keyword .= $f2.',';
      }
	}
	if($f_keyword != ''){
	  	$len = strlen($f_keyword);
	  	$f_keyword = substr($f_keyword,0,$len-1);
	  	$metakeyword = $keyword.','.$f_keyword;
	}else{
		$metakeyword = $keyword;
	}
	$array	= array(
		'sitetitle'=>$sitetitle,
		'front'=>$front,
		'metadescription'=>$metadescription,
		'metakeyword'=>$metakeyword,
		'webname'=>$webname,
	);
	$result = $GLOBALS['db']->update(DB_PREFIX."config",$array,"");
	if(!$result){
		msg::msge('更新失败!');
	}else{
		Core_Command::runlog("","更新站点SEO成功");
		msg::msge('更新成功!','xycms_setting.php?action=seo');
	}
}

function tagupdate(){
	global $db,$config,$tpl;
	$tailword = Core_Fun::strip_post("tailword",2);
	$array = array(
       'nagao' => $tailword,
   	);
	$result = $db->update(DB_PREFIX."product",$array,"post=2");
	if($result) {
		echo 1;
		exit;
	}else {
		echo 0;
		exit;
	}
}

$arrays = require '../source/conf/arrays.php';

$tpl->assign("action",$action);
$tpl->assign("version",$version); 
$tpl->assign("version_arr",$arrays[0]); 
$tpl->assign("copyr",$copyr);
$tpl->display(ADMIN_TEMPLATE."setting.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
 
