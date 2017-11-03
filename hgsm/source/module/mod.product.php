<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         产品展示
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Product{
	private static $obj = NULL;
	private static $tpl = NUll;
	private static $urlpath = NULL;
	private static $config = array();

	/*
	  @$Id 根据sql条件查询列表
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function volist($where="",$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*,c.catename,c.word,c.img,c.cssname,c.target,c.linktype,c.linkurl".
			     " FROM ".DB_PREFIX."product AS v".
			     " LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cateid=c.cateid".
		         " WHERE v.flag=1";
		if(Core_Fun::ischar($where)){
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY v.orders desc";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}else{
			$query .= " LIMIT ".intval(self::$config['productnum'])."";
		}
		$array = self::$obj->getall($query);
        Mod_Url::content_change($array,"product");    
		return $array;
	}
	/*
	  @$Id 根据category id 查询列表 查询结果含子类
	  @params $cid      -- 分类ID
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function catvolist($cid=0,$orderby="",$limitnum=0){
		self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
		$orderby = Core_Fun::forbidchar($orderby);
		$query  = "SELECT v.*,c.catename,c.word,c.img,c.cssname,c.target,c.linktype,c.linkurl".
			     " FROM ".DB_PREFIX."product AS v".
			     " LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cateid=c.cateid".
		         " WHERE v.flag=1";
		$cid = intval($cid);
		if(intval($cid)>0){
			$childs_sql = Core_Mod::build_childsql("productcate","v",$cid,"");
			if(Core_Fun::ischar($childs_sql)){
				$query .= " AND (v.cateid=$cid".$childs_sql.")";
			}else{
				$query .= " AND v.cateid=$cid";
			}
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY v.id DESC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}else{
			$query .= " LIMIT ".intval(self::$config['productnum'])."";
		}
		$array = self::$obj->getall($query);
		foreach($array as $key=>$value){
			$array[$key]['url'] = self::$urlpath."product/".$value['id'].".html";
			$array[$key]['caturl'] = self::$urlpath."product/".$value['word']."/";
			if(intval($value['linktype'])==2){
				$array[$key]['caturl'] = $value['linkurl'];
			}
			if(intval($value['target'])==2){
				$array[$key]['target'] = "_blank";
			}
			if(Core_Fun::ischar($value['thumbfiles'])){
				$array[$key]['thumbfiles'] = self::$urlpath.$value['thumbfiles'];
			}
			if(Core_Fun::ischar($value['uploadfiles'])){
				$array[$key]['uploadfiles'] = self::$urlpath.$value['uploadfiles'];
			}
		}
		return $array;
	}


	/*
	  @$Id 一级分类
	  @params $where    -- 查询条件
	  @params $orderby  -- 排序
	  @params $limitnum -- 显示数量
	*/
	public static function category($where="",$orderby="",$limitnum=0)
	{
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$where = Core_Fun::forbidchar($where);
		$orderby = Core_Fun::forbidchar($orderby);
		$query = "SELECT c.* FROM ".DB_PREFIX."productcate AS c".
			     " WHERE c.flag=1 AND c.parentid=0";
		
		if(is_array($GLOBALS['city_one']))
		{
			$query .= " AND c.front=1 ";
		}
		
		if(Core_Fun::ischar($where)){
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY c.orders ASC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}
		
		$array = self::$obj->getall($query);
		
		foreach($array as $key=>$value)
		{
			if(intval($value['linktype'])==2)
			{
				$array[$key]['url'] = $value['linkurl'];
			}
			else
			{
				$array[$key]['url'] = self::$urlpath."product/".$value['word']."/";
		    }
			
		    if($GLOBALS['city_one'])
			{
		    	$array[$key]['cname'] = $GLOBALS['city_one']['name'].$value['cname'];
		    	$array[$key]['url']   = self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$value['word']}/";
		    }
			if(intval($value['target'])==2)
			{
				$array[$key]['target'] = "_blank";
			}
			if($value['img'] == '')
			{
				$array[$key]['img'] = PATH_URL."static/images/nopic.jpg";
			}
			else
			{
				$array[$key]['img'] = PATH_URL.$value['img'];
			}		
		}
		return $array;
	}
	
	//显示某个一级分类的子分类
	public static function category_son($cid, &$parent_title, &$word)
	{
		if(trim($cid) != '' && is_numeric($cid))
		{
			self::$obj = $GLOBALS['db'];
			self::$config = $GLOBALS['config'];
			self::$urlpath = PATH_URL;
			$parent_null = 0; 
			$sql = 'SELECT `depth`,`parentid`,`cname`,`word` FROM '.DB_PREFIX."productcate WHERE `flag`='1' AND `cid`='{$cid}'";
			$array = self::$obj->fetch_first($sql);
			$depth = intval($array['depth']);
			if($depth > 0)
			{
				$cid = $array['parentid'];
			}
			else
			{
				$parent_title = $array['cname'];
				$word 		  = $array['word']; 
				$parent_null  = 1;
			}
			$sql = "SELECT * FROM ".DB_PREFIX."productcate"." WHERE flag=1 AND parentid='{$cid}' ORDER BY orders,cid DESC";
			$array = self::$obj->getall($sql);
			foreach($array as $key=>$value)
			{
				if(intval($value['linktype']) == 2)
				{
					$array[$key]['url'] = $value['linkurl'];
				}
				else
				{
					$array[$key]['url'] = self::$urlpath."product/".$value['word']."/";
				}
				if(intval($value['target'])==2)
				{
					$array[$key]['target'] = "_blank";
				}
				if($value['img'] == '')
				{
					$array[$key]['img'] = PATH_URL."static/images/nopic.jpg";
				}
				else
				{
					$array[$key]['img'] = PATH_URL.$value['img'];
				}
			}
			if($parent_null != 1)
			{
				$sql = 'SELECT `cname`,`word` FROM '.DB_PREFIX."productcate WHERE `flag`='1' AND `cid`='{$cid}' ORDER BY orders,cid DESC";
				$cnameArray   = self::$obj->fetch_first($sql);
				$parent_title = $cnameArray ? $cnameArray['cname'] : '';
				$word		  =  $cnameArray['word'];
			}
			return $array;		
		}
		else
		{
			return '';
		}
	}
	
	public static function CategorySon($cid)
	{
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		
		$sql = "SELECT depth, parentid, front FROM ".DB_PREFIX."productcate "."WHERE cid=".$cid;
		$result = self::$obj->getall($sql);
		if (is_array($GLOBALS['city_one']))
		{
			if ($result[0]['front'] == 0)
				return array();
		}
		$depth = $result[0]['depth'];
		
		while ($depth != 0)
		{
			$cid = $result[0]['parentid'];
			$sql = "SELECT depth, parentid FROM ".DB_PREFIX."productcate "."WHERE cid=".$cid;
			$result = self::$obj->getall($sql);
			$depth = $result[0]['depth'];
		}
		
		$answer = self::_DfsCatCore($cid);
		//echo ("<pre>");
		//print_r($answer);
		//echo ("</pre>");
		return $answer;
	}
	
	/*返回其孩子的数组，如果没有孩子，则返回空数组*/
	public static function _DfsCatCore($cid)
	{
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$array = array();
		$sql = "SELECT depth FROM ".DB_PREFIX."productcate "."WHERE cid=".$cid;
		$result = self::$obj->getall($sql);
		$depth = $result[0]['depth'];
		if ($depth != 2)
		{
			if(is_array($GLOBALS['city_one']))
			{
				$append = "AND front=1 ";
			}
			else
			{
				$append = "";
			}
			$sql = "SELECT * FROM ".DB_PREFIX."productcate "."WHERE parentid=".$cid." AND flag=1 ".$append." ORDER BY orders,cid DESC";
			$result = self::$obj->getall($sql);
			foreach($result AS $key=>$value)
			{
				if(intval($value['linktype'])==2)
				{
					$url = $value['linkurl'];
				}
				else
				{
					if(is_array($GLOBALS['city_one']))
					{
						$url = self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$parent_value['word']}/";
					}
					else
					{
						$url = self::$urlpath."product/".$value['word']."/";
					}
				}
				
				if(is_array($GLOBALS['city_one']))
				{
					$value['cname'] = $GLOBALS['city_one']['name'].$value['cname'];
				}
				
				$array[] = array(
					'cid' => $value['cid'],
					'cname' => $value['cname'],
					'url' => $url,
					'childcategory' => self::_DfsCatCore($value['cid'])
				);
			}
		}
		return $array;
	}

	/*
	  @$Id 3级树形分类
	  @params $parentnum -- 一级分类个数
	  @params $childnum  -- 二级分类个数
	  @params $childnum  -- 三级分类个数
	*/
	public static function treecategory($parentnum=0,$childnum=0)
	{
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$array  = array();
		$target = '';
		$append = "";   
		if(is_array($GLOBALS['city_one']))
		{
			$append = " AND front=1 ";
		}
		else
		{
			$append = "";
		}
		
		$parent_sql = "SELECT * FROM ".DB_PREFIX."productcate".
			         " WHERE parentid=0 AND depth=0 AND flag=1".$append.
			         " ORDER BY orders ASC";
		if(intval($parentnum)>0){
			$parent_sql .= " LIMIT ".intval($parentnum)."";
		}
		$parent_array = self::$obj->getall($parent_sql);
		$i = 0;
		foreach($parent_array as $parent_key=>$parent_value)
		{
			if(intval($parent_value['linktype'])==2){
				$parent_url = $parent_value['linkurl'];
			}else{
                $parent_url = self::$urlpath."product/".$parent_value['word']."/";
			}
			if(intval($parent_value['target'])==2){
				$target = "_blank";
			}
			$array[] = array(
				'i'=>$i,
				'cid'=>$parent_value['cid'],
				'parentid'=>$parent_value['parentid'],
				'word'=>$parent_value['word'],
				'intro'=>$parent_value['intro'],
				'cname'=>$parent_value['cname'],
				'img'=>$parent_value['img'],
				'url'=>$parent_url,
				'target'=>$target,
				'content'=>$parent_value['content'],
				'childcategory'=>array()
			);
			
			if(is_array($GLOBALS['city_one']))
			{
		    	$array[$parent_key]['cname'] = $GLOBALS['city_one']['name'].$parent_value['cname'];
		    	$array[$parent_key]['url']   = self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$parent_value['word']}/";
				$append = " AND front=1 ";
		    }
			else
			{
				$append = "";
			}
			//$i++;/*moved south*/
			

			$child_sql = "SELECT * FROM ".DB_PREFIX."productcate".
				        " WHERE parentid=".intval($parent_value['cid'])." AND flag=1".$append.
				        " ORDER BY orders ASC";
			if(intval($childnum)>0)
			{
				$child_sql .= " LIMIT ".intval($childnum)."";
			}
			$child_array = self::$obj->getall($child_sql);
			$ii = 0;
			foreach($child_array as $child_key=>$child_value)
			{
				if(intval($child_value['linktype'])==2)
				{
					$child_url = $child_value['linkurl'];
				}else
				{
					$child_url = self::$urlpath."product/".$child_value['word']."/";
				}
				if(intval($child_value['target'])==2){
					$target = "_blank";
				}
				$array[$i]['childcategory'][] = array(
					'i'=>$ii,
					'cid'=>$child_value['cid'],
					'parentid'=>$child_value['parentid'],
					'word'=>$child_value['word'],
					'intro'=>$child_value['intro'],
					'cname'=>$child_value['cname'],
					'img'=>$child_value['img'],
					'url'=>$child_url,
					'target'=>$target,
					'content'=>$child_value['content'],
					'childcategory'=>array()
				);
				
				if(is_array($GLOBALS['city_one']))
				{
					$array[$i]['childcategory'][$child_key]['cname'] = $GLOBALS['city_one']['name'].$child_value['cname'];
					$array[$i]['childcategory'][$child_key]['url']   = self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$child_value['word']}/";
					$append = " AND front=1 ";
				}
				else
				{
					$append = "";
				}
				
				$grandchild_sql = "SELECT * FROM ".DB_PREFIX."productcate".
				        " WHERE parentid=".intval($child_value['cid'])." AND flag=1".$append.
				        " ORDER BY orders ASC";
				$grandchild_array = self::$obj->getall($grandchild_sql);
				$iii = 0;
				foreach($grandchild_array as $grandchild_key=>$grandchild_value)
				{
					if(intval($grandchild_value['linktype'])==2)
					{
						$grandchild_url = $grandchild_value['linkurl'];
					}else
					{
						$grandchild_url = self::$urlpath."product/".$grandchild_value['word']."/";
					}
					if(intval($grandchild_value['target'])==2)
					{
						$target = "_blank";
					}
					
					$array[$i]['childcategory'][$ii]['childcategory'][] = array(
						'i'=>$iii,
						'cid'=>$grandchild_value['cid'],
						'parentid'=>$grandchild_value['parentid'],
						'word'=>$grandchild_value['word'],
						'intro'=>$grandchild_value['intro'],
						'cname'=>$grandchild_value['cname'],
						'img'=>$grandchild_value['img'],
						'url'=>$grandchild_url,
						'content'=>$grandchild_value['content'],
						'target'=>$target
					);
					
					if(is_array($GLOBALS['city_one']))
					{
						$array[$i]['childcategory'][$ii]['childcategory'][$grandchild_key]['cname'] = $GLOBALS['city_one']['name'].$grandchild_value['cname'];
						$array[$i]['childcategory'][$ii]['childcategory'][$grandchild_key]['url']   = self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$grandchild_value['word']}/";
					}
					//print_r($array);
					//var_dump($array);
					$iii++;
				}
				$ii++;
			}
			$i++;
		}
		// echo ("<pre>");
		// print_r($array);
		// echo ("</pre>");
		//print_r($array);die();
		// var_dump($array);die();
		return $array;
	}

	/* 上一个 */
	public static function previousitem($id)
	{
		require CHENCY_ROOT."/source/conf/tail.php";
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		
		if(is_array($GLOBALS['city_one']))
		{
			$append = " AND front=1 ";
		}
		else if ($GLOBALS['tail_one'])
		{
			$append = " AND tail=1 ";
		}
		else
		{
			$append = "";
		}
		
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$sql = "SELECT orders FROM ".DB_PREFIX."product where id='{$id}' and flag=1";
			$value = self::$obj->fetch_first($sql);
			$query = "SELECT id,title,orders FROM ".DB_PREFIX."product WHERE orders > {$value['orders']} AND cid=(SELECT cid FROM ".DB_PREFIX."product WHERE id = {$id}) ".$append.
					 " ORDER BY orders DESC"; 
			$rows  = self::$obj->getall($query);
			$min = null;
			$len = count($rows);
			for ($i=0; $i<$len; $i++)
			{
			    if ($i==0){
			        $min = $rows[$i];
			        continue;
			    }

			    if ($rows[$i]['orders']<$min['orders']){
			        $min = $rows[$i];
			    }
			}
			$rows = $min;
			if($rows)
			{
				if($GLOBALS['city_one'])
				{
					$temp = "<a href='".self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$rows['id']}.html'>{$GLOBALS['city_one']['name']}{$rows['title']}</a>";
				}
				else if ($GLOBALS['tail_one'])
				{
					$temp = "<a href='".self::$urlpath."product/{$rows['id']}_{$GLOBALS['tail_one']}.html'>{$rows['title']}{$tailWords[$GLOBALS['tail_one']]}</a>";
				}
				else
				{
			   		$temp = '<a href="'.self::$urlpath.'product/'.$rows['id'].'.html">'.$rows['title']."</a>";
				}
			}
			else
			{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

	/* 下一个 */
	public static function nextitem($id)
	{
		require CHENCY_ROOT."/source/conf/tail.php";
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		
		if(is_array($GLOBALS['city_one']))
		{
			$append = " AND front=1 ";
		}
		else if ($GLOBALS['tail_one'])
		{
			$append = " AND tail=1 ";
		}
		else
		{
			$append = "";
		}
		
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$sql = "SELECT orders FROM ".DB_PREFIX."product where id='{$id}' and flag=1";
			$value = self::$obj->fetch_first($sql);
			$query = "SELECT id,title,orders FROM ".DB_PREFIX."product WHERE orders < {$value['orders']} AND cid=(SELECT cid FROM ".DB_PREFIX."product WHERE id = {$id}) ".$append.
					 " ORDER BY orders DESC";
			$rows  = self::$obj->getall($query);
			$min = null;
			$len = count($rows);
			for ($i=0; $i<$len; $i++)
			{
			    if ($i==0){
			        $min = $rows[$i];
			        continue;
			    }

			    if ($rows[$i]['orders']>$min['orders']){
			        $min = $rows[$i];
			    }
			}
			$rows = $min;
			// print_r($rows);die();
			if($rows)
			{
				if($GLOBALS['city_one'])
				{
					$temp = "<a href='".self::$urlpath."product/{$GLOBALS['city_one']['en']}_{$rows['id']}.html'>{$GLOBALS['city_one']['name']}{$rows['title']}</a>";
				}
				else if ($GLOBALS['tail_one'])
				{
					$temp = "<a href='".self::$urlpath."product/{$rows['id']}_{$GLOBALS['tail_one']}.html'>{$rows['title']}{$tailWords[$GLOBALS['tail_one']]}</a>";
				}
				else
				{
					$temp = '<a href="'.self::$urlpath.'product/'.$rows['id'].'.html">'.$rows['title'].'</a>';
				}
			}
			else
			{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

	/*  标签tag输出 */
 public static function v_tag($tag=""){
   $tag_list = '';
   if($tag != ''){ 	
   	 if($tag ==''){ return NULL;}
     $tag = str_replace(" ","",$tag);
     $taglist=explode(',',$tag);
   	 $tag_content = array();
   	 foreach($taglist as $key=>$value){
   		$tag_list .= '<a href="'.PATH_URL."tag/".urlencode($value).'">'.$value.'</a>'.',';
   	 }
   	 $tag_list = rtrim($tag_list,',');
   }
   return $tag_list;
}
/*  标签tag结束 */

/* -- 相关产品或新闻 -- */

   public static function relate($tag="",$limitnum=4,$table="product",$id=""){
        self::$obj = $GLOBALS['db'];
		self::$tpl = $GLOBALS['tpl'];
		self::$urlpath = PATH_URL;
		self::$config = $GLOBALS['config'];
		$array = "";
		$sql = 'flag=1 and';
		$taglist = array();
		if ($tag == ""){
           $array ="";
		}else{
		 $taglist = explode(',',$tag);
		 $tag_count = count($taglist);
		 $sql .=" tag like '%".$taglist[0]."%'";
		 for($i=1;$i<$tag_count;$i++){
           $sql .=" or tag like '%".$taglist[$i]."%'";
		 }
		 if($id != ""){
		 	$query  = "SELECT *"." FROM ".DB_PREFIX.$table." WHERE (".$sql.") and `id` <> ".$id." ORDER BY timeline DESC limit 10";
		 }
		 else{
		    $query  = "SELECT *"." FROM ".DB_PREFIX.$table." WHERE ".$sql." ORDER BY timeline DESC limit 10";
		 }
         $array = self::$obj->getall($query);
         shuffle($array); //对数据进行随机排序
         $array = array_slice($array,0,$limitnum);
         Mod_Url::content_change($array,$table);
       	 return $array;

   }
 }

/* -- 相关产品结束 -- */




}
?>