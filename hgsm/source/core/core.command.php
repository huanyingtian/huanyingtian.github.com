<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}

class Core_Command{

	protected static $config = array();
	protected static $obj = NULL;
	// private static $var = array();

	public static function runlog($loguser="",$content,$type=1){
		self::$obj = $GLOBALS['db'];
		if(!Core_Fun::ischar($loguser)){
			if($type==1){
				$loguser = $GLOBALS['libadmin']->uc_adminname;
			}
		}
		$array = array(
			'username'=>$loguser,
			'ip'=>Core_Fun::getip(),
			'content'=>$content,
			'logtype'=>$type,
			'timeline'=>time(),
		);
		self::$obj->insert(DB_PREFIX."log",$array);
	}

	public static function command_savetag($tags){
		self::$obj = $GLOBALS['db'];
		if(Core_Fun::ischar($tags)){
			$tagtp = explode(",",$tags);
			for($ii=0;$ii<sizeof($tagtp);$ii++){
				$tag = trim($tagtp[$ii]);
				if(!(self::$obj->checkdata("SELECT tagid FROM ".DB_PREFIX."tag WHERE tag='".$tag."'"))){
					$tagid = self::$obj->fetch_newid("SELECT MAX(tagid) FROM ".DB_PREFIX."tag",1);
					$array = array(
						'tagid'=>$tagid,
						'tag'=>$tag,
						'flag'=>1,
						'timeline'=>time(),
					);
					self::$obj->insert(DB_PREFIX."tag",$array);
				}
			}
		}

	}

	public static function paging_num($content){
		$rel_content = '';
		if(($pos = strpos($content, "_ueditor_page_break_tag_")) !== false){
			$paging_array = explode("_ueditor_page_break_tag_", $content);
			$count = count($paging_array);
			$rel_content = "<div class='total'>";
			foreach ($paging_array as $key => $value) {
				$num = $key+1;
				if($num == 1){
					$rel_content.= "<div class='paging' data_num='{$num}'>".$value."</div>";
				}else{
					$rel_content.= "<div class='paging' style='display:none;' data_num='{$num}'>".$value."</div>";
				}
			}
			$rel_content.= "</div><ul class='paging_num'>";
			// echo $rel_content;exit;
			for ($i=0; $i < $count; $i++) { 
				$rel_content.= "<a href='javascript:;'>".($i+1)."</a>";
			}
			$rel_content.= "</ul>";
		}else{
			$rel_content = $content;
		}
		return $rel_content;

	}

	public static function command_replacetag($content)
	{
		$tag_content = $content;
		if(!Core_Fun::ischar($content))
		{
			;
		}
		else
		{
			self::$config  = $GLOBALS['config'];
			self::$obj     = $GLOBALS['db'];
			$color = self::$config['tagcolor'];
				$sql  = "SELECT tag,url FROM ".DB_PREFIX."tag WHERE enabled=1 ORDER BY tagid asc";
				$tags = self::$obj->getall($sql);
                //正则查找图片
				$pattern     = "/<img.*\>/isU";
				$data        = array();
                $result = preg_match_all($pattern,$tag_content,$temp);
                $flag   = 0;
                if($result)
				{
                  $temp = $temp[0];
                  $temp = array_unique($temp);
                  foreach($temp as $img)
				  {
               	   $tag_content = str_replace($img,base64_encode($img),$tag_content);
                  }
                  $flag = 1;
				}
				foreach($tags as $key=>$value)
				{
                   self::str_replace_once($value['tag'],md5($value['tag']),$tag_content);
				}
				foreach($tags as $key=>$value)
				{
					$tagurl = "<font color=#".$color."><strong>".$value['tag']."</strong></font>";
					$tagurl = "<a href='".$value['url']."' target='_blank' class='key_tag'>".$tagurl."</a>";
                   self::str_replace_once(md5($value['tag']),$tagurl,$tag_content);
			    }
			    if($flag == 1)
				{
					foreach($temp as $img)
					{
						$tag_content = str_replace(base64_encode($img),$img,$tag_content);
					}
			    }
		}
		return $tag_content;
	}

	public static function str_replace_once($search,$replace,&$content){
      $pos     = strpos($content,$search);
      $start   = $pos;
      if ($pos === false) {
        return false;
      }
       $content = substr_replace($content,$replace,$pos,strlen($search));
      return true;
	}
   public static function copyright(){
	  define('SITE_ROOT', str_replace("\\", '/', substr(dirname(__FILE__), 0, -11)));
	  require SITE_ROOT."dm/copyr.php";
   	  self::$config = $GLOBALS['config'];
   	  $var = $GLOBALS['LANVAR'];
   	  $site_url     = PATH_URL;
   	  $siteurl      = PATH_URL.'search.php?wd=';
   	  $companyname  = self::$config['sitename'];
   	  $tjcode  		= self::$config['tjcode'];
   	  $bridge  		= self::$config['bridge'];
   	  $metakeyword  = self::$config['metakeyword'];
   	  $metakeyword  = explode(',',$metakeyword);
   	  $keyword      = array_slice($metakeyword,0,3);
   	  $fkeyword     = array();

   	  $agent_name   = self::$config['agent_name'] ? self::$config['agent_name'] : $var['company_a'];
   	  $agent_url    = self::$config['agent_url'] ? 'http://'.str_replace('http://','',rtrim(self::$config['agent_url'],'/')) : 'http://www.cn86.cn'; 
   	  $tag = PATH_URL.'tag/';
      $icpcode = '<a href="http://www.miibeian.gov.cn/">'.self::$config['icpcode'].'</a>';
      $str_href ='';
      foreach ($keyword as $key => $value) {
      	 if(!empty($value)){
           $str_href .= '<a href="'.$siteurl.$value.'">'.$value.'</a>,';
      	 }
       }
      $str_href = rtrim($str_href,',');

	  if ($copyr == "true"){
	  	 $powered='Powered by <a rel="nofollow" href="http://www.cn86.cn/">'.$var['company_b'].'</a>&nbsp;&nbsp;';
	  }else{
	  	 $powered='';
	  }

	  if(self::$config['copynum'] == 1){
          $copy = self::$config['copy'];
	  }
	 
	  $array = array(
          'site_url' => $site_url,
          'companyname' => $companyname,
          'pro' => $var['pro'],
          'str_href' => $str_href,
          'advisory' => $var['advisory'],
          'icpcode' => $icpcode,
          'powered' => $powered,
          'technology' => $var['technology'],
          'agent_url' => $agent_url,
          'agent_name' => $agent_name,
          'general' =>$tjcode.$bridge.$copy,
	  );
      return  $array;
}

public static function Key_H1(){
	self::$config = $GLOBALS['config'];
    $metakeyword  = self::$config['metakeyword'];
    $keyword      = array_slice(explode(',',$metakeyword),0,3);
    $search_h1    = '';
    foreach($keyword as $list){
     $search_h1 .= '<a href="'.PATH_URL.'search.php?wd='.urlencode($list).'">'.$list.'</a>';
    }
    return $search_h1;
}


}
?>