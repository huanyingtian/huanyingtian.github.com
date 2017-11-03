<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         菜单栏目URL处理
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Url{
	private static $tpl = NUll;
	private static $obj = NUll;
	private static $urlpath = NULL;
	private static $config = array();
	private static $var = array();
	public static function display_menurl(){
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
        self::$tpl->assign("url_index",self::$urlpath."");
		self::$tpl->assign("url_about",self::$urlpath."about/");
		self::$tpl->assign("url_search",self::$urlpath."search.php");
	    self::$tpl->assign("url_sitemap",self::$urlpath."sitemap/");
		self::$tpl->assign("url_message",self::$urlpath."message/");
		self::$tpl->assign("url_news",self::$urlpath."news/");
		self::$tpl->assign("url_case",self::$urlpath."case/");
		self::$tpl->assign("url_blog",self::$urlpath."blog/");
		self::$tpl->assign("url_download",self::$urlpath."download/");
		self::$tpl->assign("url_product",self::$urlpath."product/");
		self::$tpl->assign("url_job",self::$urlpath."job/");
		self::$tpl->assign("url_getkey",self::$urlpath."getkey/");
		self::langnav();
	}
	private static function langnav(){
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$var = $GLOBALS['LANVAR'];
		foreach(self::$var as $key=>$value){
			self::$tpl->assign("lang_".$key."",$value);
		}
	}

	/* 返回顶级分类cid*/
    public static function firstcid($cid,$dbtable) {
      self::$obj = $GLOBALS['db'];
      $sql = "SELECT cid,cname,parentid,depth FROM ".DB_PREFIX.$dbtable." where cid=".$cid;
      $arrid = self::$obj->fetch_first($sql);
      if($arrid['depth'] != 0){
      	 return self::firstcid($arrid['parentid'],$dbtable);
      }
         return $arrid;
    }
	
//伪静态url
public static function site_url($table,$id){
	$url = PATH_URL.$table."/".$id.".html";
	return $url;
}

public static function content_change(&$content,$table = 'product')
{
	global $db;
	self::$config = $GLOBALS['config'];
	// print_r($GLOBALS['city_one']);die();
	if($table == "product")
	{
		foreach($content as $key=>$value)
		{
			if(is_array($GLOBALS['city_one']))
			{
				$sql_region = "SELECT * FROM ".DB_PREFIX."region where flag=1";
				$rel_region = $db->getall($sql_region);
				foreach ($rel_region as $kes => $regs) {
					if(($pos = strpos($content[$key]['title'],$regs['name'])) !== false){
						$content[$key]['title'] = str_replace($regs['name'], '', $content[$key]['title']);
						break;
					}
				}
				$content[$key]['title'] = $GLOBALS['city_one']['name'].$content[$key]['title'];
				$content[$key]['url'] = PATH_URL."{$table}/{$GLOBALS['city_one']['en']}_{$value['id']}.html";
				$content[$key]['caturl'] = PATH_URL."$table/{$GLOBALS['city_one']['en']}_{$value['word']}/";
			}
			else
			{
				$content[$key]['url'] = PATH_URL."{$table}/{$value['id']}.html";
				$content[$key]['caturl'] = PATH_URL."$table/{$value['word']}/";
			}
       
			$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 60,'...');
			if(isset($value['target']) && $value['target'] == 2)
			{
				$content[$key]['target'] = "_blank";
			}
			if($value['thumbfiles'] == '')
			{
				$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
			}
			else
			{
				$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				$content[$key]['uploadfiles'] = PATH_URL.$value['uploadfiles'];
			}
		}
		// print_r($content);
	}
	elseif ($table == "info")
	{
		foreach($content as $key=>$value)
		{
			$content[$key]['url'] = PATH_URL."news/{$value['id']}.html";
			$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 60,'...');
			$content[$key]['caturl']   = self::$urlpath."news/".$value['word']."/";
			if(isset($value['target']) && $value['target'] == 2)
			{
				$content[$key]['target'] = "_blank";
			}
			if($value['thumbfiles'] == '')
			{
				$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
			}
			else
			{
				$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				$content[$key]['uploadfiles'] = PATH_URL.$value['uploadfiles'];
			}
		}
   }
   elseif ($table == "case")
	{
		foreach($content as $key=>$value)
		{
			$content[$key]['url'] = PATH_URL."case/{$value['id']}.html";
			$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 60,'...');
			$content[$key]['caturl']   = self::$urlpath."case/".$value['word']."/";
			if(isset($value['target']) && $value['target'] == 2)
			{
				$content[$key]['target'] = "_blank";
			}
			if($value['thumbfiles'] == '')
			{
				$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
			}
			else
			{
				$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				$content[$key]['uploadfiles'] = PATH_URL.$value['uploadfiles'];
			}
		}
   }
   elseif ($table == "getkey")
	{
		foreach($content as $key=>$value)
		{
			$content[$key]['url'] = PATH_URL."getkey/{$value['word']}/";
			$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 60,'...');
			if($value['thumbfiles'] == '')
			{
				$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
			}
			else
			{
				$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				$content[$key]['uploadfiles'] = PATH_URL.$value['uploadfiles'];
			}
		}
   }
   else
   {
		foreach($content as $key=>$value)
		{
			$content[$key]['url']      = self::site_url($table,$value['id']);
			$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 60,'...');
			/*--TAGS标签输出--*/
			$content[$key]['tag'] = Mod_Product::v_tag($value['tag']);
			if($value['thumbfiles'] == '')
			{
				$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
			}
			else
			{
				$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
			}
		}   	 
	}
}



}
?>