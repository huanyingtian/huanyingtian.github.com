<?php
require CHENCY_ROOT.'source/module/app.php';
require M_ROOT."model/model_index.php";
require M_ROOT.'library/ajaxInfo.class.php';
$config_file=CHENCY_ROOT.'data/cache/style_config.php';
$config = require $config_file;

$mode_lndex = new mode_lndex();
$ajavLoad = new ajaxInfo();
$tpl->assign('pathtpl',dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME']));
$tpl->assign('banner',$ajavLoad->home());
$tpl->assign('sp',$mode_lndex->sp());
$url_array=array('url_index'=>M_PATH_URL,
             'url_about'=>M_PATH_URL.'about/',
             'url_about_old'=>M_PATH_URL.'about_mobile/m_about.html',
			 'url_news'=>M_PATH_URL.'news/',
			 'url_products'=>M_PATH_URL.'product/',
			 'url_message'=>M_PATH_URL.'message.php',
			 'url_case'=>M_PATH_URL.'case/',
			 'url_job'=>M_PATH_URL.'job/',
);

$name_array=array('index'=>'首页',
             'about'=>'公司',
			 'news'=>'新闻',
			 'products'=>'产品',
			 'message'=>'留言',
			 'case'=>'案例',
			 'job'=>'招聘'
);


$M_LANVAR = array(
	'product'=>'产品中心',
    'news'=>'新闻资讯',
	'job'=>'人才招聘',
	'case'=>'案例展示',
	'message'=>'在线留言',
	'about'=>'公司概况'
);
 
foreach($url_array as $key=>$value)
{
	$tpl->assign($key,$value);
}

foreach($name_array as $key=>$value)
{
	$tpl->assign($key,$value);
}

 global $db, $tpl;
 $tpl->assign('csspath',$config['mobile_style']);
 $sql  = "SELECT * FROM ".DB_PREFIX."delimitlabel";
 $sql1  = "SELECT * FROM ".DB_PREFIX."config";
 $page = $db->getall($sql);
 $config = $db->fetch_first($sql1);
  
 foreach($config as $key=>$value)
 {
	 $tpl->assign($key,$value);
 }
 foreach($page as $key=>$value)
 {
	 $tpl->assign('delimit_'.$value['labelname'],$value['labelcontent']);
 }

?>