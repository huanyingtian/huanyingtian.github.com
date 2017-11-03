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
$url_array=array('url_index'=>PATH_URL.'m/',
             'url_about'=>PATH_URL.'m/about/',
             'url_about_old'=>PATH_URL.'m/about_mobile/m_about.html',
			 'url_news'=>PATH_URL.'m/news/',
			 'url_products'=>PATH_URL.'m/product/',
			 'url_message'=>PATH_URL.'m/message.php',
			 'url_case'=>PATH_URL.'m/case/',
			 'url_job'=>PATH_URL.'m/job/',
);

$name_array=array('index'=>'首页',
             'about'=>'公司',
			 'news'=>'新闻',
			 'products'=>'产品',
			 'message'=>'留言',
			 'case'=>'案例',
			 'job'=>'招聘'
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