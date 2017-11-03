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
$scateid    = Core_Fun::detect_number(Core_Fun::rec_post("scateid"));
$sname      = Core_Fun::rec_post("sname",1);
if($page<1){$page=1;}
$comeurl	= "page=$page&scateid=$scateid&sname=".urlencode($sname)."";

if(Core_Fun::rec_post('act')=='update')
{
    updateajax(Core_Fun::rec_post('id'),Core_Fun::rec_post('action'));
    die();
}

switch($action){
    case 'add':
	    add();
		break;
	case 'saveadd':
	    saveadd();
		break;
	case 'edit':
	    edit();
		break;
	case 'saveedit':
	    saveedit();
		break;
	case 'del':
	    del();
		break;
	case 'orders':
	    product_orders();
		break;
	case 'move':
	    product_move();
		break;
	case 'copys':
	    copys();
		break;
	case 'recommend':
		recommend();
		break;
	case 'remove_r':
		remove_r();
		break;
	case 'orders_r':
		orders_r();
		break;
	case 'isnew':
		isnew();
		break;	
	default:
	    volist();
		break;
}

function volist(){
	Core_Auth::checkauth("productvolist");
	global $db,$tpl,$page,$scateid,$sname;
    $pagesize	= 15;
	$searchsql	= " WHERE 1=1";
	if($scateid>0){
		$childs_sql = Core_Mod::build_childsql("productcate","a",$scateid,"");
		if(Core_Fun::ischar($childs_sql)){
			$searchsql .= " AND (a.cid=$scateid".$childs_sql.")";
		}else{
			$searchsql .= " AND a.cid=$scateid";
		}
	}
	if(Core_Fun::ischar($sname)){
		$searchsql .= " AND a.title LIKE '%".$sname."%'";
	}
	$countsql	= "SELECT COUNT(a.id) FROM ".DB_PREFIX."product AS a".$searchsql;
    $total		= $db->fetch_count($countsql);
    $pagecount	= ceil($total/$pagesize);
	$nextpage	= $page+1;
	$prepage	= $page-1;
	$start		= ($page-1)*$pagesize;
	$sql		= "SELECT a.*,c.cname".
		          " FROM ".DB_PREFIX."product AS a".
		          " LEFT JOIN ".DB_PREFIX."productcate AS c ON a.cid=c.cid".
		          $searchsql." ORDER BY a.orders DESC LIMIT $start, $pagesize";
	$product	= $db->getall($sql);
	$url		= $_SERVER['PHP_SELF'];
	$urlitem	= "scateid=$scateid&sname=".urlencode($sname)."";
	$url	   .= "?".$urlitem;
	$showpage	= Core_Page::adminpage($total,$pagesize,$page,$url,10);
	$tpl->assign("total",$total);
	$tpl->assign("pagecount",$pagecount);
	$tpl->assign("page",$page);
	$tpl->assign("showpage",$showpage);
	$tpl->assign("product",$product);
	$tpl->assign("urlitem",$urlitem);
	$tpl->assign("cate_search",Core_Mod::tree_select("productcate",$scateid,"scateid"));
    $tpl->assign("cate_select",Core_Mod::tree_select("productcate","","cid"));
    $tpl->assign("copy_select",Core_Mod::tree_select("productcate","","fid"));
	$tpl->assign("sname",$sname);
}

function add(){
	Core_Auth::checkauth("productadd");
	global $tpl,$db,$config;
	$cid    =  Core_Fun::detect_number(Core_Fun::rec_post("cid"));
	$orders	= $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."product",1);
	$tags = explode(',',$config['metakeyword']);
	$sql_c= "SELECT `name` FROM ".DB_PREFIX."region ORDER BY id ASC LIMIT 3";
	$city=$db->getall($sql_c);
	$citynew='';
	foreach ($city as $key => $zhi) {
		foreach ($zhi as $key => $value) {
			$citynew.=$value.',';
		}
	}
	$size="(图片大小：".$config['uploadwidth']."*".$config['uploadheight'].")";
	$cityword=trim($citynew,',');
	$tailword=$config["tailword"];
	$cid  = $cid ? $cid:''; 
	$tpl->assign("size",$size);
	$tpl->assign("flag_checkbox",Core_Mod::checkbox("1","flag","审核"));
	$tpl->assign("elite_checkbox",Core_Mod::checkbox("","elite","推荐"));
	$tpl->assign("isnew_checkbox",Core_Mod::checkbox("","isnew","新品"));
	$tpl->assign("cate_select",Core_Mod::tree_select("productcate",$cid,"cid"));
	// print_r(Core_Mod::tree_select("productcate",$cid,"cid"));die();
	$tpl->assign("tags",$tags);
	$tpl->assign("cid",$cid);
	$tpl->assign("orders",$orders);
	$tpl->assign("cityword",$cityword);
	$tpl->assign("tailword",$tailword);
}

function edit(){
	Core_Auth::checkauth("productedit");
	global $db,$tpl,$config;
    $id = Core_Fun::rec_post('id');
	if(!Core_Fun::isnumber($id)){
		msg::msge('ID丢失');
	}
	$sql		= "SELECT * FROM ".DB_PREFIX."product WHERE id=$id LIMIT 1";
	$product	= $db->fetch_first($sql);
	$sql_c= "SELECT `name` FROM ".DB_PREFIX."region ORDER BY id ASC LIMIT 3";
	$city=$db->getall($sql_c);
	$citynew='';
	foreach ($city as $key => $zhi) {
		foreach ($zhi as $key => $value) {
			$citynew.=$value.',';
		}
	}
	$cityword=trim($citynew,',');
	$tailword=$config["tailword"];
	if(!$product){
		msg::msge('数据不存在');
	}else{
		$tags  = array();
		$f_tag = explode(',',$config['metakeyword']);
		$p     = explode(',',$product['tag']);
		foreach($f_tag as $key => $f){
          $tags[$key]['name'] = $f;
          $tags[$key]['mark'] = 0;
          foreach($p as $pp){
            if($f == $pp){
             $tags[$key]['mark'] = 1;
             }
          }
		}
		$post    =$product['post'];
		$taggu   =$product['taggu'];
		$size="(图片大小：".$config['uploadwidth']."*".$config['uploadheight'].")";
		$product['uploadpicname'] = Core_Mod::getpicname($product['uploadfiles']);
		$product['thumbpicname'] = Core_Mod::getpicname($product['thumbfiles']);
		$tpl->assign("size",$size);
		$tpl->assign("flag_checkbox",Core_Mod::checkbox($product['flag'],"flag","审核"));
		$tpl->assign("elite_checkbox",Core_Mod::checkbox($product['elite'],"elite","推荐"));
		$tpl->assign("isnew_checkbox",Core_Mod::checkbox($product['isnew'],"isnew","新品"));
		$tpl->assign("cate_select",Core_Mod::tree_select("productcate",$product['cid'],"cid"));
		$tpl->assign("id",$id);
		$tpl->assign("page",$GLOBALS['page']);
		$tpl->assign("comeurl",$GLOBALS['comeurl']);
		$arr = array();
		$array =explode('#', $product['img_input']);
		foreach($array as $value){
		  if(!empty($value)){
			$arr[] = array(
               'name' => $value,
               'img'  => PATH_URL.'data/images/product/thumb_'.$value
			);
		  }	
		}
		$tpl->assign("arr",$arr);
		$tpl->assign("rand",time().rand(10,100000).rand(1,1000));
	    $tpl->assign("product",$product);
	    $tpl->assign("tags",$tags);
	    $tpl->assign("post",$post);
	    $tpl->assign("taggu",$taggu);
	    $tpl->assign("cityword",$cityword);
	    $tpl->assign("tailword",$tailword);
	}
}

function saveadd(){
	Core_Auth::checkauth("productadd");
	global $db;
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$productnum		= Core_Fun::rec_post('productnum',1);
	$title      	= Core_Fun::rec_post('title',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$img_input		= Core_Fun::strip_post('img_input',1);
	$content		= Core_Fun::strip_post('content',1);
	$extend1		= Core_Fun::strip_post('extend1',1);
	$extend2		= Core_Fun::strip_post('extend2',1);
	$extend3		= Core_Fun::strip_post('extend3',1);
	$wrext1		= Core_Fun::rec_post('wrext1',1);
	$wrext2 	= Core_Fun::rec_post('wrext2',1);
	$wrext3		= Core_Fun::rec_post('wrext3',1);
	$nagao		= Core_Fun::rec_post('nagao',1);
	$post		= Core_Fun::rec_post('post',1);
	$ptitle		= Core_Fun::rec_post('ptitle',1);
	$pkeywords	= Core_Fun::rec_post('pkeywords',1);
	$pdescription	= Core_Fun::rec_post('pdescription',1);
	$price			= Core_Fun::detect_number(Core_Fun::rec_post('price',1));
	$hits			= Core_Fun::detect_number(Core_Fun::rec_post('hits',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$isnew			= Core_Fun::detect_number(Core_Fun::rec_post('isnew',1));
	$tag			= Core_Fun::rec_post('tag',1);	
	$taggu			= Core_Fun::rec_post('taggu',1);	
	$tag = str_replace('，', ',', $tag);
	$tag = str_replace(' ', '', $tag);
	$tag_array = explode(',', $tag);
	$tag_array = array_unique($tag_array);
	$tag = implode(',',$tag_array);
	$founderr		= false;
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="产品名称不能为空";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(Core_Fun::ischar($thumbfiles)){
		if(!file_exists("../".$thumbfiles)){
			$thumbfiles = $uploadfiles;
		}
	}
	if(!Core_Fun::ischar($productnum)){
		$productnum = time();
	}
	$orders	= $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."product",1);
	$array	= array(
		'cid'=>$cid,
		'productnum'=>$productnum,
		'title'=>$title,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'img_input'=>$img_input,
		'content'=>$content,
		'extend1' => $extend1,
		'extend2' => $extend2,
		'extend3' => $extend3,
		'wrext1' => $wrext1,
		'wrext2' => $wrext2,
		'wrext3' => $wrext3,
		'nagao' => $nagao,
		'post' => $post,
		'ptitle' => $ptitle,
		'pkeywords' => $pkeywords,
		'pdescription' => $pdescription,
		'price'=>$price,
		'timeline'=>time(),
		'elite'=>$elite,
		'flag'=>$flag,
		'isnew'=>$isnew,
		'tag'=>$tag,
		'taggu'=>$taggu,
		'orders'=>$orders,
		'hits'=>$hits,
	);
	$result = $db->insert(DB_PREFIX."product",$array);
	if($result){
		Core_Command::runlog("","发布产品成功[$title]",1);
		msg::msge('保存成功',"xycms_product.php?action=add&cid=$cid");
	}else{
		msg::msge('保存失败');
	}
}

function saveedit(){
	Core_Auth::checkauth("productedit");
	global $db;
	$id				= Core_Fun::rec_post('id',1);
	$cid			= Core_Fun::detect_number(Core_Fun::rec_post('cid',1));
	$productnum		= Core_Fun::rec_post('productnum',1);
	$title      	= Core_Fun::rec_post('title',1);
	$thumbfiles		= Core_Fun::strip_post('thumbfiles',1);
	$uploadfiles	= Core_Fun::strip_post('uploadfiles',1);
	$img_input		= Core_Fun::strip_post('img_input',1);
	$content		= Core_Fun::strip_post('content',1);
	$extend1		= Core_Fun::strip_post('extend1',1);
	$extend2		= Core_Fun::strip_post('extend2',1);
	$extend3		= Core_Fun::strip_post('extend3',1);
	$wrext1		= Core_Fun::rec_post('wrext1',1);
	$wrext2 	= Core_Fun::rec_post('wrext2',1);
	$wrext3		= Core_Fun::rec_post('wrext3',1);
	$nagao		= Core_Fun::rec_post('nagao',1);
	$post		= Core_Fun::rec_post('post',1);
	$ptitle		= Core_Fun::rec_post('ptitle',1);
	$pkeywords	= Core_Fun::rec_post('pkeywords',1);
	$pdescription	= Core_Fun::rec_post('pdescription',1);
	$price			= Core_Fun::detect_number(Core_Fun::rec_post('price',1));
	$hits			= Core_Fun::detect_number(Core_Fun::rec_post('hits',1));
	$flag			= Core_Fun::detect_number(Core_Fun::rec_post('flag',1));
	$elite			= Core_Fun::detect_number(Core_Fun::rec_post('elite',1));
	$isnew			= Core_Fun::detect_number(Core_Fun::rec_post('isnew',1));
	$tag			= Core_Fun::rec_post('tag',1);
	$taggu			= Core_Fun::rec_post('taggu',1);
	$tag = str_replace('，', ',', $tag);
	$tag = str_replace(' ', '', $tag);
	$tag_array = explode(',', $tag);
	$tag_array = array_unique($tag_array);
	$tag = implode(',',$tag_array);
	$founderr	= false;
	if(!Core_Fun::isnumber($id)){
	    $founderr	= true;
		$errmsg	   .= "ID丢失";
	}
	if(!Core_Fun::ischar($title)){
	    $founderr	= true;
		$errmsg	   .="产品名称不能为空";
	}
	if($founderr == true){
	    msg::msge($errmsg);
	}
	if(Core_Fun::ischar($thumbfiles)){
		if(!file_exists("../".$thumbfiles)){
			$thumbfiles = $uploadfiles;
		}
	}
	if(!Core_Fun::ischar($productnum)){
		$productnum = '';
	}
// 	$sql = "Select MAX(orders) From ".DB_PREFIX."product where `id` != '".$id."'";
// 	$orders	= $db->fetch_newid($sql,1);
	$array = array(
		'cid'=>$cid,
		'productnum'=>$productnum,
		'title'=>$title,
		'thumbfiles'=>$thumbfiles,
		'uploadfiles'=>$uploadfiles,
		'img_input'=>$img_input,
		'content'=>$content,
		'extend1' => $extend1,
		'extend2' => $extend2,
		'extend3' => $extend3,
		'wrext1' => $wrext1,
		'wrext2' => $wrext2,
		'wrext3' => $wrext3,
		'nagao' => $nagao,
		'post' => $post,
		'ptitle' => $ptitle,
		'pkeywords' => $pkeywords,
		'pdescription' => $pdescription,
		'price'=>$price,
		'timeline'=>time(),
		'elite'=>$elite,
		'flag'=>$flag,
		'isnew'=>$isnew,
		'tag'=>$tag,
		'taggu'=>$taggu,
		'hits'=>$hits,
	);
	$result = $db->update(DB_PREFIX."product",$array,"id=$id");
	if($result){
		Core_Command::runlog("","编辑产品成功[id=$id]");
		msg::msge("编辑成功","xycms_product.php?".$GLOBALS['comeurl']);
	}else{
		msg::msge('编辑失败');
	}
}

function del(){
	Core_Auth::checkauth("productdel");
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的数据');
	}
	global $db;
	for($ii=0;$ii<count($arrid);$ii++){
        $id = Core_Fun::replacebadchar(trim($arrid[$ii]));
		if(Core_Fun::isnumber($id)){
			$db->query("DELETE FROM ".DB_PREFIX."product WHERE id=$id");
		}
	}
	Core_Command::runlog("","删除产品成功[id=$arrid]");
	msg::msge('删除成功','xycms_product.php');
}

function product_orders(){
	global $db;
    $arrid      = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    // print_r($arrid);die();
    $forwardurl = "xycms_product.php";
	if($arrid=="" || is_null($arrid)){
		header("Content-type:text/html;charset=utf-8");
		echo "<script>alert('请选择要更新的产品')</script>";
		echo("<meta http-equiv='refresh' content='0;url='.$forwardurl>");
		die();
	}
    $arrorders  = isset($_POST['orders']) ? $_POST['orders'] : "";
   	$count  = count($arrid);
   	for($i=0;$i<$count;$i++){
   	 $array = array(
       'orders' => $arrorders[$i],
   	 );
   	 // print_r($array);die();
     $result = $db->update(DB_PREFIX."product",$array,"id=$arrid[$i]");
   	}
   	header("Content-type:text/html;charset=utf-8");
   	echo "<script>alert('更新排序成功！')</script>";
   	echo("<meta http-equiv='refresh' content='0;url='.$forwardurl>");
   	exit;
}

function copys(){
	global $db;
    $fid    = Core_Fun::detect_number(Core_Fun::rec_post("fid"),1);
    $forwardurl = "xycms_product.php";
    $arrid      = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    foreach($arrid as $info){
     $sql  ="SELECT * FROM ".DB_PREFIX."product WHERE id=$info";
     $arr = $db->fetch_first($sql);
     unset($arr['id']);
     $arr['cid'] = $fid;
     $arr['orders']	= $db->fetch_newid("SELECT MAX(orders) FROM ".DB_PREFIX."product",1);
     $result = $db->insert(DB_PREFIX."product",$arr);
     if(!$result){
     	msg::msge('复制失败！',$forwardurl);
     	break;
     }
    }
    msg::msge('复制成功！',$forwardurl);
}

function product_move(){
	global $db;
    $cid    = Core_Fun::detect_number(Core_Fun::rec_post("cid"),1);
    $forwardurl = "xycms_product.php";
    $arrid      = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
    foreach($arrid as $product){
    $array = array(
       'cid' => $cid,
   	 );
     $result = $db->update(DB_PREFIX."product",$array,"id=$product");
     if(!$result){
     	msg::msge('更新失败！',$forwardurl);
     	break;
     }
    }
    msg::msge('更新成功！',$forwardurl);
}

//推荐产品
function recommend(){
	global $db,$tpl;
	$sql = "Select * From ".DB_PREFIX."product Where `flag`=1 And `elite`=1 Order By `elite_orders`,`orders` Desc";
	$recommend = $db->getall($sql);
	foreach($recommend as $key=>$volist){
		if(empty($recommend[$key]['thumbfiles']) || $recommend[$key]['thumbfiles'] == ''){
			$recommend[$key]['thumbfiles'] = 'template/static/images/s_nopic.jpg';
		}		
	}
	$tpl->assign("recommend",$recommend);
}
//移除推荐和新品
function remove_r(){
	$id   = is_numeric($_GET['id']) ? $_GET['id']:0;
	$item = $_GET['item'];
	if(!isset($item) && empty($item)){
		$in = array('isnew','elite');
		if(!in_array($item, $in)){
			echo 0;
			die();
		}
	}
	if($id){
		global $db;
		$sql = "Update ".DB_PREFIX."product Set ".$item."=0 Where `id`='".$id."'";
		$db->query($sql);
		echo 1;
	}else{
		echo 0;
	}
	die();
}
//推荐排序
function orders_r(){
	$id = $_GET['id'];
	$orders = $_GET['orders'];
	$item   = $_GET['item'];
	if(!isset($item) && empty($item)){
		$in = array('isnew','elite');
		if(!in_array($item, $in)){
			echo 0;
			die();
		}
	} 
	if(count($id) == count($orders)){
		$count = count($id);
		global $db;
		for($i = 0;$i<$count;$i++){
			$array = array(
					$item.'_orders' => $orders[$i],
			);
			$result = $db->update(DB_PREFIX."product",$array,"id=$id[$i]");			
		}
	 echo 1;		
	}else{
		echo 0;
	}	
	die();
}
//新品
function isnew(){
	global $db,$tpl;
	$sql = "Select * From `".DB_PREFIX."product` Where `flag`=1 And `isnew`=1 Order By `isnew_orders`,`orders` Desc";
	$isnew= $db->getall($sql);
	foreach($isnew as $key=>$volist){
		if(empty($isnew[$key]['thumbfiles']) || $isnew[$key]['thumbfiles'] == '')
		{
			$isnew[$key]['thumbfiles'] = 'template/static/images/s_nopic.jpg';
		}		
	}
	$tpl->assign("isnew",$isnew);
}


function updateajax($_id,$_action){
	Core_Auth::checkauth("productedit");
    if(Core_Fun::isnumber($_id)){
		global $db;
		switch($_action){
			case 'flagopen':
			   $db->query("UPDATE ".DB_PREFIX."product SET flag=1 WHERE id=$_id");
			   break;
			case 'flagclose':
			   $db->query("UPDATE ".DB_PREFIX."product SET flag=0 WHERE id=$_id");
			   break;
			case 'eliteopen':
			   $db->query("UPDATE ".DB_PREFIX."product SET elite=1 WHERE id=$_id");
			   break;
			case 'eliteclose':
			   $db->query("UPDATE ".DB_PREFIX."product SET elite=0 WHERE id=$_id");
			   break;
			case 'isnewopen':
			  	$db->query("UPDATE ".DB_PREFIX."product SET isnew=1 WHERE id=$_id");
			   	break;
			case 'isnewclose':
			   	$db->query("UPDATE ".DB_PREFIX."product SET isnew=0 WHERE id=$_id");
			   	break;
			case 'frontopen':
			   $db->query("UPDATE ".DB_PREFIX."product SET front=1 WHERE id=$_id");
			   break;
			case 'frontclose':
			   $db->query("UPDATE ".DB_PREFIX."product SET front=0 WHERE id=$_id");
			   break;
			case 'tailopen':
			   $db->query("UPDATE ".DB_PREFIX."product SET tail=1 WHERE id=$_id");
			   break;
			case 'tailclose':
			   $db->query("UPDATE ".DB_PREFIX."product SET tail=0 WHERE id=$_id");
			   break;
			default:
			   break;
		}
	}
}

$tpl->assign("action",$action);
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
$tpl->display(ADMIN_TEMPLATE."product.tpl");

