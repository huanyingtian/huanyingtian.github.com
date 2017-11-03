<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
 * @Id         产品内容
**/
if(!defined('ALLOWGUEST')) {
	exit('Access Denied');
}
$id = Core_Fun::detect_number(Core_Fun::rec_post("id"));

//TempNum 显示临时记录数
$TempNum=5;  
//RecentlyGoods 最近商品RecentlyGoods临时变量
if (isset($_COOKIE['RecentlyGoods'])) 
{
	$RecentlyGoods=$_COOKIE['RecentlyGoods']; 
	$RecentlyGoodsArray=explode(",", $RecentlyGoods);
	$RecentlyGoodsNum=count($RecentlyGoodsArray); //RecentlyGoodsNum 当前存储的变量个数
}
if($_GET['id']!="")
{
	$Id=$_GET['id']; //ID 为得到请求的字符
	//如果存在了，则将之前的删除，用最新的在尾部追加
	if (strstr($RecentlyGoods, $Id)) 
	{
	  $tpl->assign('browse',$GLOBALS['LANVAR']['browse']);
	}
	else
	{
		if($RecentlyGoodsNum<$TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
		{
			if($RecentlyGoods=="")
			{
			    setcookie("RecentlyGoods",$Id,time()+86400);
			}
			else
			{
				$RecentlyGoodsNew=$RecentlyGoods.",".$Id;
				setcookie("RecentlyGoods", $RecentlyGoodsNew,time()+86400); 
			}
		}
		else //如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
		{
			$pos=strpos($RecentlyGoods,",")+1; //第一个参数的起始位置
			$FirstString=substr($RecentlyGoods,0,$pos); //取出第一个参数
			$RecentlyGoods=str_replace($FirstString,"",$RecentlyGoods); //将第一个参数删除
			$RecentlyGoodsNew=$RecentlyGoods.",".$Id; //在尾部加入最新的记录
			setcookie("RecentlyGoods", $RecentlyGoodsNew,time()+86400); 
		}
	}
}
$dir=$_COOKIE["RecentlyGoods"];

if(isset($dir)){
	$sql_b="SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."product AS v LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cid=c.cid".
	       " WHERE v.flag=1 AND v.id in ($dir) ORDER BY v.orders DESC";
	$productprow = $db->getall($sql_b);
	Mod_Url::content_change($productprow,'product');
	// foreach ($productprow as $key =>&$value) {
	// 	$value['url']  = PATH_URL."product/{$value['id']}.html";
	// 	$value['thumbfiles']=PATH_URL.$value['thumbfiles'];
	// }
	$tpl->assign("productprow",$productprow);
}

require CHENCY_ROOT."/source/conf/tail.php";
$svc = $_REQUEST['svc'];

if($id<1)
{
	header('Location: HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	exit;
}
$sql	 = "SELECT v.*,c.cname,c.word,c.img,c.target,c.linktype,c.linkurl FROM ".DB_PREFIX."product AS v".
           " LEFT JOIN ".DB_PREFIX."productcate AS c ON v.cid=c.cid".
	       " WHERE v.flag=1 AND v.id='".intval($id)."'";
$product = $db->fetch_first($sql);
if(!$product){
	header('Content-type:text/html;charset=utf-8');
	die(对不起，信息不存在或已删除！);
}else{
	/*查询区域*/
	$sql_region  = "SELECT * FROM ".DB_PREFIX."region where flag=1";
	$rel_region  = $db->getall($sql_region);
	$regions     = '';
	foreach ($rel_region as $reg => &$names) {
		$regions.= $names['name']."、";
	}
	$regions     = rtrim($regions,'、');
	/* url和导航 */
	$product['url']   = PATH_URL.'product/'.$product['id'].'.html';
	
	$cid  = $product['cid'];
	if(intval($product['linktype'])==2){
				$product['caturl'] = $product['linkurl'];
	}else{
		if(!empty($city_one)){
			$product['caturl'] = PATH_URL."product/{$city_one['en']}_{$product['word']}/";
		}else{
			$product['caturl'] = PATH_URL.'product/'.$product['word']."/";	
		}
	$navigation  = '<a href="'.PATH_URL.'product/">'.$LANVAR['product'].'</a>'.$LANVAR['arrow'];
    }
	if(intval($product['linktype'])==2){
		$navigation .= '<a href="'.$product['linkurl'].'">'.$product['cname'].'</a>'.$LANVAR['arrow'];
	}else{
		$navigation .= '<a href="'.PATH_URL.'product/'.$product['word'].'/">'.$product['cname'].'</a>';
		}
 	if(!Core_Fun::ischar($product['uploadfiles'])){
		$product['uploadfiles'] = PATH_URL.'/template/static/images/nopic.jpg';
	}else{
		$product['uploadfiles'] = PATH_URL.$product['uploadfiles'];
	}
	$product['price'] = Core_Fun::price_format($product['price']);
	$pro_catearr      = $db->fetch_first("SELECT `cname` FROM ".DB_PREFIX."productcate where flag=1 and cid=".$product['cid']);
	$catename         = $pro_catearr['cname'];
    $page_description = str_replace(' ','',str_replace('{1}',$product['title'],$config['plist_d']));
    $page_description = str_replace('{2}',$config['sitename'],$page_description);
    $page_description = str_replace('{3}',$regions,$page_description);
    $page_description = str_replace('{4}',$catename,$page_description);
    $product['m_detail'] = str_replace(' ','',str_replace('{1}',$product['title'],$config['pdetail_d']));
    $product['m_detail'] = str_replace('{2}',$config['sitename'],$product['m_detail']);
	$product['content']  = Core_Command::command_replacetag($product['content']);
	/* 给产品详细介绍添加分页 */
	$product['content'] = Core_Command::paging_num($product['content']);
}

if ($product['front'] == 1)
{
	$region_all = $region->allRegion();
	
	foreach($region_all as $key=>$val)
	{
		$region_all[$key]['title'] = $val['name'].$product['title'];
		$region_all[$key]['url']   = PATH_URL."product/{$val['en']}_{$id}.html";
	}
	$tpl->assign('have_region', 'true');
}


if(!empty($city_one))
{
	foreach ($region_all as $kes => $regs) {
		if(($pos = strpos($product['title'],$regs['name'])) !== false){
			$product['title'] = str_replace($regs['name'], '', $product['title']);
			break;
		}
	}
	$product['title'] = $city_one['name'].$product['title'];
	$product['cname'] = $city_one['name'].$product['cname'];
}
else if (empty($city_one) && (isset($svc)))
{
	$product['title'] = $product['title'].$tailWords[$svc];
	//$product['cname'] = $product['cname'].$tailWords[$svc];
}
else if (empty($city_one) && (!isset($svc)) && ($product['tail'] == 1))
{
	//print_r($tailWords);
	$relate_svc = array();
	foreach ($tailWords AS $tailKey => $tailValue)
	{
		$relate_svc[] = array(
								'title' => $product['title'].$tailValue,
								'url' => PATH_URL."product/".$id."_".$tailKey.".html"
							);
	}
	$tpl->assign('relate_service', $relate_svc);//相关服务
	$tpl->assign('have_relate', 'true');
}
/*增加了分类名称*/
// $page_title =$product['cname'].'_'.$product['title'];
$page_title = $product['title'];
$page_nagao =$product['nagao'];
// echo($product['title']);
// print_r($city_one);
if(!empty($city_one))
{
    $tpl->assign("page_title",$page_title."-".$config['sitename']);
}else if (empty($city_one)) 
{  
	if(!empty($page_nagao))
	{
		if($product['post'] == 1){
			$nagaoarr = explode(',', $page_nagao);
			$page_title_new = '';
			foreach ($nagaoarr as $kr => &$words) {
				if(($pos = strpos($page_title,$words)) !== false)
				{
					$page_title = str_replace($words, '', $page_title);
				}	
			}
			foreach ($nagaoarr as $ks => &$wordnow) {
				$page_title_new.=$wordnow.$page_title.'_';
			}
			$page_title_new = rtrim($page_title_new,'_');
		}elseif ($product['post'] == 2) {
			$nagaoarr = explode(',', $page_nagao);
			$page_title_new = '';
			foreach ($nagaoarr as $kr => &$words) {
				$page_title_new.=$page_title.$words.'_';
			}
			$page_title_new = rtrim($page_title_new,'_');
		}
	    $tpl->assign("page_title",$page_title.'_'.$page_title_new."-".$config['sitename']);
    }else{
     	$tpl->assign("page_title",$page_title."-".$config['sitename']);
    }
}

if(!empty($product['ptitle'])){
	$tpl->assign("page_title",$product['ptitle']);
}

if(!empty($product['pkeywords'])){
	$page_keyword = $product['pkeywords'];
}else{
    if($product['post'] == 1){
    	if($nagaoarr){
    		foreach ($nagaoarr as $key => &$kword) {
				$page_keyword .= $kword.$page_title.',';
		  }
		  $page_keyword = $page_title.','.rtrim($page_keyword,',');
    	}	
	}elseif($product['post'] == 2){
		if($nagaoarr){
			foreach ($nagaoarr as $keysword => $results) {
				$page_keyword.= $product['title'].$results.',';
			}
			$page_keyword = $page_title.','.rtrim($page_keyword,',');
		}else{
	     	$page_keyword = $product['title'];
	    }
	}else{
		$page_keyword = $product['title'];
	}
	
}
if(!empty($product['pdescription'])){
	$page_description = $product['pdescription'];
}

/*--多图展示--*/
$arr = explode('#', $product['img_input']);
$arrimg = array();
foreach($arr as $key=>&$value){
  if(!empty($value)){
     $arrimg[] = PATH_URL.'data/images/product/'.$value;
   }
}
$tpl->assign("arrimg",$arrimg);

/*--TAGS标签输出--*/
$tag_content = Mod_Product::v_tag($product['tag']);

/*--相关产品和新闻（通过TAG相似度判断）--*/
$relatedproduct = Mod_Product::relate($product['tag'],5,"product",$id);
$relatednew     = Mod_Product::relate($product['tag'],10,"info");
$tpl->assign('region_product',$region_all);
$tpl->assign("relatedproduct",$relatedproduct);
$tpl->assign("relatednew",$relatednew);
$tpl->assign("tag",$tag_content);
$tpl->assign("id",$id);
$tpl->assign("product",$product);
$tpl->assign("navigation",$navigation);
$tpl->assign("previous_item",Mod_Product::previousitem($id));
$tpl->assign("next_item",Mod_Product::nextitem($id));
$tpl->assign("page_description",$page_description);
$tpl->assign("page_keyword",$page_keyword);
?>