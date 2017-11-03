<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         产品列表
**/
if(!defined('ALLOWGUEST')) {exit('Access Denied');}

$word		= Core_Fun::rec_post("word",2);
$page		= Core_Fun::detect_number(Core_Fun::rec_post("page"),1);
$pagesize	= $config['productpagesize'];
$searchsql	= " WHERE v.flag=1";
$custom_depth = '';
$pos = strpos($word, "_del");//判断word是否含有“_del”字符，如果有的话就过滤
if($pos !== false){
	$new_word = str_replace("_del", "", $word);
	$sql = "select cid from ".DB_PREFIX."productcate where word='".$new_word."'";
	$data = $db->fetch_first($sql);
	$cid = $data['cid'];
}else
{
	$sql  = "select cid from ".DB_PREFIX."productcate where word='".$word."'";
	$data = $db->fetch_first($sql);
	$cid  = $data['cid'];
	if($config['custom_tel'] == 1 && !isset($cid)){
		$custom_depth = 1;
		$sql_home  = "SELECT * FROM ".DB_PREFIX."productcate where flag=1 AND depth=0 ORDER BY orders ASC";
		$data_home = $db->getall($sql_home);
		foreach ($data_home as $k => &$val) {
			if(intval($val['linktype']) ==2){
				$val['url'] = $val['linkurl'];
			}else{
				$val['url'] = PATH_URL."product/".$val['word']."/";
			}
			$val['img'] = PATH_URL.$val['img'];
			if(is_array($GLOBALS['city_one'])){
				$val['cname'] = $GLOBALS['city_one']['name'].$val['cname'];
				$val['url']   = PATH_URL."product/{$GLOBALS['city_one']['en']}_{$parent_value['word']}/";
			}
			if($config['categorynumber'] > 0){
				$val['url'] = PATH_URL."product/".$val['word']."_del/";
				$childs_sql = Core_Mod::build_childsql("productcate","",intval($val['cid']),"");
				if(Core_Fun::ischar($childs_sql))
				{
					$searchsql_new = " flag=1 AND (cid='".intval($val['cid'])."'".$childs_sql.")";
				}
				else
				{
					$searchsql_new = " flag=1 AND cid='".intval($val['cid'])."'";
				}
				$sql_product = "SELECT * FROM ".DB_PREFIX."product where".$searchsql_new." ORDER BY orders DESC"." LIMIT ".$config['categorynumber'];
				$data_product = $db->getall($sql_product);
				Mod_Url::content_change($data_product,'product');
				$val['product'] = $data_product;
			}

		}
		// print_r($data_home);exit;
		$tpl->assign("data_home",$data_home);
	}
	if(isset($cid)){
		$sql = "SELECT * FROM ".DB_PREFIX."productcate where cid='".$cid."'";
		$cust_val = $db->fetch_first($sql);
		$custom = $cust_val['custom'];
		if($custom == 1){
			$cust_val['url'] =PATH_URL."product/".$cust_val['word']."_del/";
			$custom_depth = 2;
			if(intval($cust_val['linktype']) ==2){
				$cust_val['url'] = $cust_val['linkurl'];
			}else{
				$cust_val['url'] = PATH_URL."product/".$cust_val['word']."_del/";
			}
			// print_r($cust_val);die();
			if(isset($cust_val['target']) && $cust_val['target'] == 2)
			{
				$cust_val['target'] = "_blank";
				// echo $cust_val['target'];die();
			}
			if(is_array($GLOBALS['city_one'])){
				$cust_val['cname'] = $GLOBALS['city_one']['name'].$cust_val['cname'];
				$cust_val['url']   = PATH_URL."product/{$GLOBALS['city_one']['en']}_{$cust_val['word']}_del/";
			}
		}else{
			if(is_array($GLOBALS['city_one'])){
				$cust_val['cname'] = $GLOBALS['city_one']['name'].$cust_val['cname'];
				$cust_val['url']   = PATH_URL."product/{$GLOBALS['city_one']['en']}_{$cust_val['word']}/";
			}
		}
		$tpl->assign("cust_val",$cust_val);
	}
}
$tpl->assign("custom_depth",$custom_depth);

if($page<1){$page=1;}

/* volist */


if(intval($cid)>0)
{
	$childs_sql = Core_Mod::build_childsql("productcate","v",intval($cid),"");
	if(Core_Fun::ischar($childs_sql))
	{
		$searchsql .= " AND (v.cid='".intval($cid)."'".$childs_sql.")";
	}
	else
	{
		$searchsql .= " AND v.cid='".intval($cid)."'";
	}
}

$countsql	= "SELECT COUNT(v.id) FROM ".DB_PREFIX."product AS v".$searchsql;
$total		= $db->fetch_count($countsql);
$pagecount	= ceil($total/$pagesize);
$nextpage	= $page+1;
$prepage	= $page-1;
$start		= ($page-1)*$pagesize;


if (is_array($city_one))
{
	$searchsql .= " AND v.front=1 AND c.front=1 ";
}

$sql     = "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."product AS v"." LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cid=c.cid".$searchsql." ORDER BY v.orders DESC LIMIT $start, $pagesize";
$product = $db->getall($sql);


////在区域分站模式下，对产品列表进行变更
// if(is_array($city_one))
// {
	////首先排除不需要前置推广的tag
	// $sql = "SELECT tag FROM ".DB_PREFIX."tag WHERE front=0 AND enabled=1";
	// $noFrontTag = $db->getall($sql);
	
	// foreach ($product as $key=>$value)
	// {
		// foreach ($noFrontTag as $nIndex=>$nofrontValue)
		// {
			////echo("<pre>");
			////print_r($arrValue['tag']);
			////print_r($value['title']);
			////echo("</pre>");
			// if ($nofrontValue['tag'] == $value['title'])
			// {
				// unset($product[$key]);
			// }
		// }
	// }
	
	
	// if ($city_one['name'] == "　")
	// {
		////处理后置推广的tag
		// $sql = "SELECT tag FROM ".DB_PREFIX."tag WHERE tail=1 AND enabled=1";
		// $tailTag = $db->getall($sql);
		
		// $puff = array();
	
		// foreach ($product as $key=>$value)
		// {
			// foreach ($tailTag as $nIndex=>$tailValue)
			// {
				////echo("<pre>");
				////print_r($arrValue['tag']);
				////print_r($value['title']);
				////echo("</pre>");
				// if ($tailValue['tag'] == $value['title'])
				// {
					////echo("<pre>");
					////print_r($value);
					////echo("</pre>");
					// $tmp = $value;
					// $tmp['title'] = $tmp['title']."供应商";
					// $puff[] = $tmp;
					// $tmp = $value;
					// $tmp['title'] = $tmp['title']."厂家";
					// $puff[] = $tmp;
				// }
			// }
		// }
		// $product = array_merge($puff, $product);
	// }
// }

Mod_Url::content_change($product,'product');

$catename = array();

if($cid>0)
{
	$sql_cate   = "select * from ".DB_PREFIX."productcate "."where cid ='".$cid."' LIMIT 1";
    $catename   = $db->get_one($sql_cate);
}
else
{
   $catename['cname'] = $LANVAR['product'];
}

/* page */
$showpage	= Core_Page::volistpage("product",$word,$total,$pagesize,$page,10);

/* category */
$navigation = '<a href="'.PATH_URL.'product/">'.$LANVAR['product'].'</a>';
$navcatname	= $LANVAR['product'];
$navurl     = NULL;
$page_title = $LANVAR['product']."_".$config['sitetitle'];

/*查询区域*/
$sql_region = "SELECT * FROM ".DB_PREFIX."region where flag=1";
$rel_region = $db->getall($sql_region);
$region     = '';
foreach ($rel_region as $reg => &$names) {
	$region.= $names['name']."、";
}
$region     = rtrim($region,'、');
if($cid>0)
{
	$cate = $db->fetch_first("SELECT * FROM ".DB_PREFIX."productcate WHERE cid='".intval($cid)."' LIMIT 1");
	if($cate)
	{
		if(empty($cate['title'])){
			if(is_array($city_one))
			{
				$cate['cname'] = $city_one['name'].$cate['cname'];
				$page_title    = $cate['cname']."-".$config['webname'];
			}else{
				$nagao      = $cate['nagao'];
				$nagaoarr   = explode(',', $nagao);
				$page_title = '';
				if($cate['post'] == 1){
					foreach ($nagaoarr as $ks => $values) {
						if(($postsd = strpos($cate['cname'], $values)) !== false){
							$cate['cname'] = str_replace($values, '', $cate['cname']);
						}
						// $page_title.= $values.$cate['cname'].'_';
					}
					foreach ($nagaoarr as $ksr => $results) {
						$page_title.= $results.$cate['cname'].'_';
					}
					$page_title = rtrim($page_title, '_').'-'.$config['webname'];
				}elseif($cate['post'] == 2){
					foreach ($nagaoarr as $ks => $values) {
						$page_title.= $cate['cname'].$values.'_';
					}
					$page_title = rtrim($page_title, '_').'-'.$config['webname'];
				}else{
					$page_title = $cate['cname'].'-'.$config['webname'];
				}
			}
			
		}else{
			if(is_array($city_one))
			{
				$cate['title'] = $city_one['name'].$cate['title'];
			}
			$page_title = $cate['title'];
		}
		if(empty($cate['description'])){
			$page_description = $config['pcate_d'];
			$page_description = str_replace('{1}',$catename['cname'],$page_description);
			$page_description = str_replace('{2}',$config['sitename'],$page_description);
			$page_description = str_replace('{3}',$region,$page_description);
			$page_description = str_replace(' ','',$page_description);
		}else{
			$page_description = $cate['description'];
		}
		if(intval($cate['target'])==2)
		{
			$target = "_blank";
		}
		if(intval($cate['linktype'])==2)
		{
			$navurl = '<a href='.$cate['linkurl'].' target="'.$target.'">'.$cate['cname'].'</a>';
		}
		else
		{
			$navurl = '<a href="'.PATH_URL.'product/'.$cate['word'].'/">'.$cate['cname'].'</a>';
		}
		$navigation .= $LANVAR['arrow'].$navurl;
		$navcatname = $cate['cname'];
		// $page_keyword = empty($cate['keywords']) ? $cate['cname'] : $cate['keywords'];
		if(empty($cate['keywords'])){
			if($cate['post'] == 2){
				$page_keyword = '';
				$nagao      = $cate['nagao'];
				$nagaoarr   = explode(',', $nagao);
				foreach ($nagaoarr as $keys_page => $value_word) {
					$page_keyword.= $cate['cname'].$value_word.',';
				}
				$page_keyword = rtrim($page_keyword, ',');
			}else{
				$page_keyword = $cate['cname'];
			}
		}else{
			$page_keyword = $cate['keywords'];
		}
	}
}else{
	$page_description = $config['pcate_d'];
	$page_description = str_replace('{1}',$catename['cname'],$page_description);
	$page_description = str_replace('{2}',$config['sitename'],$page_description);
	$page_description = str_replace('{3}',$region,$page_description);
	$page_description = str_replace(' ','',$page_description);
	$page_keyword = $LANVAR['product'];
}

if($page>1)
{
	$page_title .= "_第".$page."页";
}
$prodescription = '';
if($cid > 0){
	$sql_text = "SELECT `intro` FROM ".DB_PREFIX."productcate where flag=1 and cid={$cid}";
	$result   = $db->fetch_first($sql_text);
	if(!empty($result['intro'])){
		$prodescription = $result['intro'];
	}else{
		$prodescription = $config['prodescription'];
	}
}else{
	$prodescription = $config['prodescription'];
}

$cate = isset($cate) ? $cate : '';
$tpl->assign("page_title",$page_title);
$tpl->assign("cid",$cid);
$tpl->assign("prodescription",$prodescription);
$tpl->assign("cate",$cate);
$tpl->assign("showpage",$showpage);
$tpl->assign("total",$total);
$tpl->assign("page",$page);
$tpl->assign("pagecount",$pagecount);
$tpl->assign("pagesize",$config['productpagesize']);
$tpl->assign("product",$product);
$tpl->assign("navurl",$navurl);
$tpl->assign("navigation",$navigation);
$tpl->assign("navcatname",$navcatname);
$tpl->assign("page_keyword",$page_keyword);
$tpl->assign("page_description",$page_description);
?>