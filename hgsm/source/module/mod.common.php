<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         在线留言
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Mod_Common{
	private static $obj  = NULL;
    private static $urlpath = NULL;

	/*
		@ 留言显示
		@ param string/int $num 显示数量
	*/
	public static function message($num=30){
		self::$obj = $GLOBALS['db'];
		$sql = "SELECT * FROM ".DB_PREFIX."guestbook where flag=1 order by id DESC limit ".$num;
		$array  = self::$obj->getall($sql);
		foreach ($array as $key => $val) {
			$array[$key]['telcontact'] = substr_replace($val['contact'],'****',3,4);;
		}
		return $array;
	}

	/*
		@ 招聘显示
		@ param string/int $cid 栏目id
		@ param string/int $num 显示数量
		@ param string/int $orders 排序
	*/
	public static function job($cid=0,$num=6,$orders=0){
		self::$obj = $GLOBALS['db'];
		self::$urlpath = PATH_URL;
		$where = " flag = '1'";
		$sort = 'DESC';
		if($cid > 0){
           $where .= ' and cid='.$cid;
		}
		if($orders == 1){
			$sort = 'ASC';
		}
		$where .= " ORDER BY id ".$sort;
		if($num > 0){
           $where .= ' limit '. $num;
		}
		$sql = "SELECT * FROM ".DB_PREFIX."job where".$where;
		$array  = self::$obj->getall($sql);
		foreach ($array as $key => $value) {
			$array[$key]['url'] = self::$urlpath."job/".$value['id'].".html";
			if($value['thumbfiles'] == ''){
				$array[$key]['thumbfiles'] = self::$urlpath."template/static/images/nopic.jpg";
			}else{
				$array[$key]['thumbfiles'] = self::$urlpath.$value['thumbfiles'];
			}
		}
		return $array;
	}

	/* 分类绑定banner  $cid=cid  $dbtable=表名 */
    public static function banners($cid,$dbtable) {
    	self::$obj = $GLOBALS['db'];
    	$sql = "SELECT banner,parentid FROM ".DB_PREFIX.$dbtable." where cid=".$cid;
    	$result = self::$obj->fetch_first($sql);
    	if($result['banner'] == ''){
        	if($result['parentid'] != 0){
      	  		return self::banners($result['parentid'],$dbtable);
        	}
        }else{
      		$result['banner'] = PATH_URL.$result['banner'];
    	}
      	return $result['banner'];
    }




}

