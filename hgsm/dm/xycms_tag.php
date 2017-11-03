<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require_once '../source/core/run.php';
require_once 'admin.inc.php';
$action		= Core_Fun::rec_post("action");
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$spaceid    = $_GET['spaceid'];
if($page<1){$page=1;}
$comeurl	= "page=$page&sname=".urlencode($sname)."";

if(Core_Fun::rec_post('act')=='update')
{
    updateajax(Core_Fun::rec_post('id'),Core_Fun::rec_post('action'));
    die();
}

switch($action)
{
	case 'savecolor':
	    savecolor();
	    break;
	case 'update':
	    update();
	    break;
	default:
	    volist();
		break;
}

function volist()
{
	Core_Auth::checkauth("tagvolist");
	global $db, $tpl, $page, $sname, $config, $spaceid;
    $pagesize	= 20;
	$searchsql	= " WHERE 1=1";
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND tag LIKE '%".$sname."%'";
	}
	if(Core_Fun::isnumber($spaceid)){
		$searchsql .= " AND enabled=".$spaceid;
	}
	$countsql	= "SELECT COUNT(tagid) FROM ".DB_PREFIX."tag".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT * FROM ".DB_PREFIX."tag".
		          $searchsql." ORDER BY tagid asc LIMIT $start, $pagesize";
	$tag		= $db->getall($sql);
	// foreach ($tag as $key => &$val) {
	// 	if(mb_strlen($val['tag']) < 3 || mb_strlen($val['tag']) > 10){
	// 		unset($tag[$key]);
	// 	}
	// }
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "sname=".urlencode($sname)."&spaceid=".$spaceid;
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("tag",$tag);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("sname",$sname);
	$tpl->assign("color",$config['tagcolor']);
}
function rank(&$tag){
	$len = count($tag);
	for($i=0;$i<=$len-1;$i++){
	 for($j=$i+1;$j<$len;$j++){
      if(strlen($tag[$j]['tag']) > strlen($tag[$i]['tag'])){
        $temp2             = $tag[$i]['tagid'];
        $tag[$i]['tagid']  = $tag[$j]['tagid'];
        $tag[$j]['tagid']  =  $temp2;
        $temp              = $tag[$i];
        $tag[$i]           = $tag[$j];
        $tag[$j]           = $temp;
     }
    }
   }
}

function update()
{
	$place = is_numeric($_POST['place']) ? $_POST['place']:0;
	// print_r($place);die();
	global $db,$tpl,$config;
	//清空tag表
	$sql = "truncate table ".DB_PREFIX."tag";
	if(!$db->query($sql))
	{
		msg::msge('清空tag表失败！','xycms_tag.php');
	}
	//自动tags
	$siteurl   = "http://".$config['siteurl'].'/';
	$urlpath   = PATH_URL;
    $keyword   = array();
    $keyword_f = array();
	$category  = array();
	$tag       = array();
	$product   = array();
	
	//主关键词
    $word = explode(',',$config['metakeyword']);
    if(!empty($word))
	{
    	foreach ($word as $key=>$val)
		{
    		if(empty($val))
			{
    			unset($word[$key]);
    		}
    	}
    	if(!empty($word))
		{
    		$f_len  = count($word) - 3;
    		$key1 = array_slice($word,0,3);
    		$key2 = array_slice($word,3,$f_len);
    	}
    }
    if(!empty($key1))
	{
    	$length = count($key1);
    	for($i=0;$i<$length;$i++)
		{
    		$keyword[$i]["tag"] = $key1[$i];
    		$keyword[$i]["url"] = $urlpath;
			$keyword[$i]["enabled"] = 1;
    	}
    }
   //副关键词
	if(!empty($key2))
	{
		foreach($key2 as $key=>$val)
		{
			$keyword_f[$key]["tag"] = $val;
			$keyword_f[$key]["url"] = $urlpath;
			$keyword_f[$key]["enabled"] = 1;
		}
	}
	//批量更新产品后缀长尾词
	$tailword =$config['tailword'];
	$array_p  =array('nagao' =>$tailword , );
	$result_p =$db->update(DB_PREFIX."product",$array_p,"post=2");

	//批量更新产品前缀区域词
	$sql_r="SELECT `name` FROM ".DB_PREFIX."region ORDER BY id DESC";
	$city =$db->getall($sql_r);
	$citynew='';
	foreach ($city as $key => $zhi) 
	{
		foreach ($zhi as $key => $value) 
		{
			$citynew.=$value.',';
		}
	}
	$cityword=trim($citynew,',');
	$array_t =array('nagao' =>$cityword , );
    $result_t=$db->update(DB_PREFIX."product",$array_t,"post=1");
	

    //产品分类
    $sql  = "SELECT cname,word,taggu FROM ".DB_PREFIX."productcate WHERE flag=1";
    $cate = $db->getall($sql);
    $count1 = count($cate);
    if(!empty($count1))
	{
    	for($i=0;$i<$count1;$i++)
		{
    		$category[$i]['tag'] = $cate[$i]['cname'];
    		$category[$i]['url'] = $urlpath.'product/'.$cate[$i]['word'].'/';
			$category[$i]['enabled'] = $cate[$i]['taggu'];
    	}
    	// print_r($category);exit;
    	foreach ($category as $cates => $cat) {
			if(mb_strlen($cat['tag']) < 3 || mb_strlen($cat['tag']) > 10)
			{
				unset($category[$cates]);
			}
    	}
    }

    //产品列表
    $sql      = "select title,id,taggu from ".DB_PREFIX."product where flag=1";
    $p_list   = $db->getall($sql);
    foreach ($p_list as $kts => $tis) {
		if(mb_strlen($tis['title']) < 3 || mb_strlen($tis['title']) > 10)
		{
			unset($p_list[$kts]);
		}
    }
    $p_list   = array_values($p_list);
    $count2   = count($p_list);
    if($count2)
	{
    	for($i=0;$i<$count2;$i++)
		{
    		$product[$i]['tag']     = $p_list[$i]['title'];
    		$product[$i]['url']     = $urlpath.'product/'.$p_list[$i]['id'].'.html';
			$product[$i]['enabled'] = $p_list[$i]['taggu'];
    	}
    }

    $tag  = array_merge($keyword,$category,$product,$keyword_f);
    $data = array();
    $k    = array();
    $temp = array();
    foreach($tag as $key=>$list)
	{
      $data[] = $list['tag'];
    }
    foreach($data as $key=>$list)
	{
        if(in_array($list,$temp))
		{
          $k[] = $key;
        }
    	$temp[] = $list;
    }
    
    foreach($k as $data)
	{
    	 unset($tag[$data]);
    }
    $tag = array_values($tag);
    rank($tag);
    foreach($tag as $data)
	{
      $result = $db->insert(DB_PREFIX."tag",$data);
      if(!$result)
	  {
      	if($place == 1)
		{
      	  echo 0;
      	  exit; 
      	}
     	msg::msge('更新排序失败！','xycms_tag.php');
      }
    }
    if($place == 1)
	{
    	echo 1;
    	exit;
    }
    msg::msge('更新tag成功！','xycms_tag.php');
}

function savecolor()
{
    global $tpl,$db;
    $color      = strtolower(Core_Fun::rec_post("color",1));
    $color      = str_replace(' ', '', $color);
    $length     = strlen($color); 
    $colorAllow = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');
    if(strlen($color) !=3 && strlen($color) != 6 ){
    	msg::msge('颜色值错误，请输入正确颜色值！必须为3位或者6为16进制数！');
    }else{
    	for($i=0;$i<$length;$i++){
    		if(! in_array($color[$i], $colorAllow)){
    			msg::msge('颜色值错误，请输入正确颜色值！必须为3位或者6为16进制数！');
    			break;
    		  }
    	}   	
    }
	$result = $db->update(DB_PREFIX."config",array('tagcolor'=>$color,),"");
	$tpl->assign("color",$result);
    msg::msge('保存颜色成功','xycms_tag.php');
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."tag.tpl");
$tpl->assign("copyright",$libadmin->copyright());

function updateajax($_id,$_action)
{
	Core_Auth::checkauth("tagvolist");
    if(Core_Fun::isnumber($_id))
	{
		global $db;
		switch($_action)
		{
			case 'enabledopen':
			{
			  	$db->query("UPDATE ".DB_PREFIX."tag SET enabled=1 WHERE tagid=$_id");
				$db->query("UPDATE ".DB_PREFIX."product SET taggu=1 WHERE title=(SELECT tag FROM ".DB_PREFIX."tag WHERE tagid=$_id)");
				$db->query("UPDATE ".DB_PREFIX."productcate SET taggu=1 WHERE cname=(SELECT tag FROM ".DB_PREFIX."tag WHERE tagid=$_id)");
			   	break;
			}
			case 'enabledclose':
			   	$db->query("UPDATE ".DB_PREFIX."tag SET enabled=0 WHERE tagid=$_id");
				$db->query("UPDATE ".DB_PREFIX."product SET taggu=0 WHERE title=(SELECT tag FROM ".DB_PREFIX."tag WHERE tagid=$_id)");
				$db->query("UPDATE ".DB_PREFIX."productcate SET taggu=0 WHERE cname=(SELECT tag FROM ".DB_PREFIX."tag WHERE tagid=$_id)");
			   	break;
			default:
			   break;
		}
	}
}

?>
