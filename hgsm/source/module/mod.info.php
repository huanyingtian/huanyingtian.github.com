<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         新闻资讯
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Info{
	private static $obj = NULL;
	private static $tpl = NUll;
	private static $urlpath	= NULL;
	private static $config = array();

	/*
	  @$Id 列表
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
		$query  = "SELECT v.*,c.cname,c.img,c.target,c.linktype,c.linkurl".
			     " FROM ".DB_PREFIX."info AS v".
			     " LEFT JOIN ".DB_PREFIX."infocate AS c ON v.cid=c.cid".
		         " WHERE v.flag=1";
		if(Core_Fun::ischar($where)){
			$query .= " ".$where;
		}
		if(Core_Fun::ischar($orderby)){
			$query .= " ".$orderby;
		}else{
			$query .= " ORDER BY v.id DESC";
		}
		if(intval($limitnum)>0){
			$query .= " LIMIT ".intval($limitnum)."";
		}
		$array = self::$obj->getall($query);
		foreach($array as $key=>$value){
			$array[$key]['url'] = self::$urlpath."news/".$value['id'].".html";
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
	
	public static function CategorySon($cid)
	{
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		
		$sql = "SELECT depth, parentid FROM ".DB_PREFIX."infocate "."WHERE cid=".$cid;
		$result = self::$obj->getall($sql);
		$depth = $result[0]['depth'];
		
		while ($depth != 0)
		{
			$cid = $result[0]['parentid'];
			$sql = "SELECT depth, parentid FROM ".DB_PREFIX."infocate "."WHERE cid=".$cid;
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
		$sql = "SELECT depth FROM ".DB_PREFIX."infocate "."WHERE cid=".$cid;
		$result = self::$obj->getall($sql);
		$depth = $result[0]['depth'];
		if ($depth != 2)
		{
			$sql = "SELECT * FROM ".DB_PREFIX."infocate "."WHERE parentid=".$cid." ORDER BY orders,cid DESC";
			$result = self::$obj->getall($sql);
			foreach($result AS $key=>$value)
			{
				if(intval($value['linktype'])==2)
				{
					$url = $value['linkurl'];
				}
				else
				{
					$url = self::$urlpath."news/".$value['word']."/";
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
	  @$Id 三级分类
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
		$query = "SELECT c.* FROM ".DB_PREFIX."infocate AS c".
			     " WHERE c.parentid=0 AND c.flag=1 AND c.depth=0";
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
		$array = array();
		$target = '';
		$parent_array = self::$obj->getall($query);
		$i = 0;
		foreach($parent_array as $parent_key=>$parent_value)
		{
			if (intval($parent_value['linktype']) == 2)
			{
				$parent_url = $parent_value['linkurl'];
			}
			else
			{
				$parent_url = self::$urlpath."news/".$parent_value['word']."/";
			}
			if (intval($parent_value['target']) == 2)
			{
				$target = "_blank";
			}
			$array[] = array
			(
				'i' => $i,
				'cid' => $parent_value['cid'],
				'parentid' => $parent_value['parentid'],
				'word' => $parent_value['word'],
				'cname' => $parent_value['cname'],
				'img' => $parent_value['img'],
				'content' => $parent_value['content'],
				'url' => $parent_url,
				'target' => $target,
				'childcategory' => array()
			);
			$child_sql = "SELECT cid,word,parentid,cname,word,img,target,linktype,linkurl FROM ".DB_PREFIX."infocate".
				        " WHERE parentid=".intval($parent_value['cid'])." AND flag=1".
				        " ORDER BY orders ASC";
			$child_array = self::$obj->getall($child_sql);
			$ii = 0;
			foreach ($child_array as $child_key => $child_value)
			{
				if(intval($child_value['linktype'])==2)
				{
					$child_url = $child_value['linkurl'];
				}else
				{
					$child_url = self::$urlpath."news/".$child_value['word']."/";
				}
				if(intval($child_value['target'])==2)
				{
					$target = "_blank";
				}
				$array[$i]['childcategory'][] = array
				(
					'i' => $i,
					'cid' => $child_value['cid'],
					'parentid' => $child_value['parentid'],
					'word' => $child_value['word'],
					'cname' => $child_value['cname'],
					'img' => $child_value['img'],
					'content' => $child_value['content'],
					'url' => $child_url,
					'target' => $target,
					'childcategory' => array()
				);
				// $childnews_sql = "SELECT * FROM ".DB_PREFIX."info WHERE cid=".intval($child_value['cid'])." AND flag=1 ORDER BY orders DESC";
				// $childnews_array = self::$obj->getall($childnews_sql);
				// foreach ($childnews_array as $childnews_key => $childnews_value) {
				// 	$childnews_array[$childnews_key] = self::$urlpath."news/".$childnews_value['id'].".html";
				// }
				$grandchild_sql = "SELECT cid,word,parentid,cname,word,img,target,linktype,linkurl FROM ".DB_PREFIX."infocate".
				        " WHERE parentid=".intval($child_value['cid'])." AND flag=1".
				        " ORDER BY orders ASC";
				$grandchild_array = self::$obj->getall($grandchild_sql);
				$iii = 0;
				foreach($grandchild_array as $grandchild_key=>$grandchild_value)
				{
					if(intval($grandchild_value['linktype'])==2)
					{
						$grandchild_value = $grandchild_value['linkurl'];
					}else
					{
						$grandchild_url = self::$urlpath."news/".$grandchild_value['word']."/";
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
						'cname'=>$grandchild_value['cname'],
						'img'=>$grandchild_value['img'],
						'content'=>$grandchild_value['content'],
						'url'=>$grandchild_url,
						'target'=>$target
					);
					$iii++;
				}
				$ii++;
			}
			$i++;
		}
		return $array;
	}

	/* 上一个 */
	public static function previousitem($id,$cid){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$query = "SELECT id,title FROM ".DB_PREFIX."info WHERE id < '{$id}' AND `cid` = '{$cid}' ORDER BY id DESC LIMIT 1";
			$rows  = self::$obj->fetch_first($query);
			if($rows){
			 $temp = "<a href=\"".self::$urlpath."news/".$rows['id'].".html\">".$rows['title']."</a>";
			}else{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

	/* 下一个 */
	public static function nextitem($id,$cid){
		self::$obj = $GLOBALS['db'];
		self::$config = $GLOBALS['config'];
		self::$urlpath = PATH_URL;
		$var = $GLOBALS['LANVAR'];
		$temp  = "";
		if(Core_Fun::isnumber($id)){
			$id = intval($id);
			$query = 'SELECT id,title FROM '.DB_PREFIX."info WHERE `id` > '{$id}' AND `cid` = '{$cid}' ORDER BY id ASC LIMIT 1";
			$rows  = self::$obj->fetch_first($query);
			if($rows){
			$temp = "<a href=\"".self::$urlpath."news/".$rows['id'].".html\">".$rows['title']."</a>";
			}else{
				$temp = $var['no'];
			}
		}
		return $temp;
	}

}
?>