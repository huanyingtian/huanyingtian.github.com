<?php

/**------碎片管理
 * spname        碎片标签 
 * splabel       调用标签 
 * np            产品或新闻 
 * recommend     是否推荐
 * isnew         是否最新
 * cateid        分类id
 * order         排序
 * num           条数
 * intro         碎片介绍
 **/

require_once '../source/core/run.php';
require_once 'admin.inc.php';

$action	 = Core_Fun::rec_post("action");
$allowAction = array('volist','add','saveadd','saveedit','del','edit');
if(!in_array($action, $allowAction) and !empty($action)){
	echo '不允许此操作';
	die();
}
switch($action){
	case 'add':
		add();
		break;
	case 'saveadd':
		saveadd();
		break;
	case 'del':
		del();
		break;
	case 'edit':
		edit();
		break;
	case 'saveedit':
		saveedit();
		break;
	default:
		volist();
		break;
}

//显示默认碎片列表
function volist()
{
	global $db,$tpl;
	$countsql = "Select COUNT(id) From ".DB_PREFIX."sp";
	$total	  = $db->fetch_count($countsql);

	$sql    = "Select * From .".DB_PREFIX."sp";
	$splist = $db->getall($sql);
	if(!$splist)
	{
		$splist = array();
	}
	else
	{
		foreach($splist as $key=>$list)
		{
			$splist[$key]['intro'] = stripslashes($list['intro']);
			$cid = $list['cateid'];
			if ($list['np'] == 1)
			{
				$splist[$key]['np'] = '产品中心';	
				if($cid)
				{
					$sql = "Select `cname` From ".DB_PREFIX."productcate Where `cid`='".$cid."' Limit 1";
					$result = $db->fetch_first($sql);
				$splist[$key][sp_cate] = $result['cname'];
				}
				else
				{
				$splist[$key][sp_cate] = '全部分类';
				}	 	
			}
			else if ($list['np'] == 2)
			{
				$splist[$key]['np'] = '新闻中心';
				if($cid)
				{
					$sql = "Select `cname` From ".DB_PREFIX."infocate Where `cid`='".$cid."' Limit 1";
					$result = $db->fetch_first($sql);
					$splist[$key][sp_cate] = $result['cname'];
				}
				else
				{
					$splist[$key][sp_cate] = '全部分类';
				}  	 	
			}
			else
			{
				$splist[$key]['np'] = '案例中心';
				if($cid)
				{
					$sql = "Select `cname` From ".DB_PREFIX."casecate Where `cid`='".$cid."' Limit 1";
					$result = $db->fetch_first($sql);
					$splist[$key][sp_cate] = $result['cname'];
				}
				else
				{
					$splist[$key][sp_cate] = '全部分类';
				}
			}
			if($list['recommend'])
			{
				$splist[$key]['recommend'] = '是';
			}
			else
			{
				$splist[$key]['recommend'] = '否';
			}
			if($list['isnew'])
			{
				$splist[$key]['isnew'] = '是';
			}
			else
			{
				$splist[$key]['isnew'] = '否';
			}
			if($list['orders'])
			{
				$splist[$key]['orders'] = '降序';
			}
			else
			{
				$splist[$key]['orders'] = '默认';
			}	  	 
		}
	}
	$tpl->assign("total",$total);
	$tpl->assign('splist',$splist);  
}

//添加碎片界面
function add(){
	global $tpl;
	$product = Core_Mod::tree_select("productcate",$cid,"cid");
	$news    = Core_Mod::tree_select("infocate",$cid,"cid");
	$case    = Core_Mod::tree_select("casecate",$cid,"cid");
	$np      = $_GET['np'];
	if(isset($np) && !empty($np))
	{
		if ($np == 1)
		{
			echo  $product;
		}
		else if ($np == 2)
		{
			echo $news;
		}
		else
		{
			echo $case;
		}
		die();
	}
	else
	{
		$tpl->assign("cate_select_p",$product);
		$tpl->assign("cate_select_n",$news);
		$tpl->assign("cate_select_a",$case);
	}
}
//保存碎片
function saveadd(){
	global $db;
	$spname   	= Core_Fun::rec_post('spname',1);
	$splabel 	= Core_Fun::rec_post('splabel',1);
	$np         = Core_Fun::rec_post('np',1);
	$npcate     = Core_Fun::rec_post('cid',1); //产品或者新闻分类id
	$recommend  = Core_Fun::rec_post('recommend',1);
	$isnew  	= Core_Fun::rec_post('isnew',1);
	$orders  	= Core_Fun::rec_post('orders',1);
	$num  		= Core_Fun::rec_post('num',1);
	$intro  	= Core_Fun::rec_post('intro',1);
	if(!$spname || empty($spname)){
		msg::msge('碎片名称不能为空！');
	}
	if(!preg_match("/^[0-9a-zA-Z\_]{2,30}$/",$splabel)){
		msg::msge('标签必须是3-30位的字母、数字和下划线组合!');
	}
	if(isset($recommend) && !in_array($isnew, array(0,1))){
		msg::msge('推荐栏目必须数字');
	}
	if(isset($isnew) && !in_array($isnew, array(0,1))){
		msg::msge('是否为最新产品有错误！');
	}
	if(isset($orders) && !in_array($orders, array(0,1))){
		msg::msge('排序错误！');
	}
	if(isset($num) && !is_numeric($num)){
		msg::msge('数目必须为数字！');
	}
	$intro = mysql_real_escape_string($intro);
	$array = array(
			'spname'=>$spname,
			'splabel'=>$splabel,
			'np'=>$np,
			'cateid'=>$npcate,
			'recommend'=>$recommend,
			'isnew'=>$isnew,
			'orders'=>$orders,
			'num'=>$num,
			'intro'=>$intro,	
			);
	$result = $db->insert(DB_PREFIX."sp",$array);
	if($result){
		msg::msge('添加碎片成功','listsp.php');
	}else{
		msg::msge('添加碎片失败');
	}	
}

//删除碎片
function del(){
	global $db;
	$arrid  = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
	if($arrid=="" || is_null($arrid)){
		msg::msge('请选择要删除的碎片');
	}
	foreach($arrid as $id){
		if(is_numeric($id)){
			$result = $db->query("Delete FROM ".DB_PREFIX."sp Where `id`=$id");
			if(!$result){
				echo '删除失败！id='.$id;
				die();
			}
		}else{
			echo '删除的id必须为数字!';
			die();
		}
	}
	msg::msge('碎片删除成功','listsp.php');
}

//编辑碎片
function edit(){
	global $db,$tpl;
	$id = $_GET['id'];
	if(!is_numeric($id)){
		msg::msge('编辑的碎片id格式错误！');
	}
	$sql = "Select * From ".DB_PREFIX."sp Where `id`='".$id."' Limit 1";
	$sp_edit = $db->fetch_first($sql);
	if(!$sp_edit){
		msg::msge('要编辑的数据不存在','listsp.php');
	}
	if($sp_edit['np'] == 1)
	{
		$cate_select = Core_Mod::tree_select("productcate",$sp_edit['cateid'],"cid");
	}
	elseif($sp_edit['np'] == 2)
	{
		$cate_select = Core_Mod::tree_select("infocate", $sp_edit['cateid'],"cid");
	}
	else
	{
		$cate_select = Core_Mod::tree_select("casecate", $sp_edit['cateid'],"cid");
	}
	
	$tpl->assign("cate_select",$cate_select);
	$tpl->assign('id',$id);
	$tpl->assign('sp_edit',$sp_edit);
}

//保存编辑碎片
function saveedit(){
	global $db;
	$id         = Core_Fun::rec_post('id');
	$spname   	= Core_Fun::rec_post('spname',1);
	$splabel 	= Core_Fun::rec_post('splabel',1);
	$np         = Core_Fun::rec_post('np',1);
	$npcate     = Core_Fun::rec_post('cid',1); //产品或者新闻分类id
	$recommend  = Core_Fun::rec_post('recommend',1);
	$isnew  	= Core_Fun::rec_post('isnew',1);
	$orders  	= Core_Fun::rec_post('orders',1);
	$num  		= $_POST['num'];
	$intro  	= Core_Fun::rec_post('intro',1);
	if(!$spname || empty($spname)){
		msg::msge('碎片名称不能为空！');
	}
	if(!preg_match("/^[0-9a-zA-Z\_]{2,30}$/",$splabel)){
		msg::msge('标签必须是3-30位的字母、数字和下划线组合!');
	}
	if(isset($recommend) && !in_array($isnew, array(0,1))){
		msg::msge('推荐栏目必须数字');
	}
	if(isset($isnew) && !in_array($isnew, array(0,1))){
		msg::msge('是否为最新产品有错误！');
	}
	if(isset($orders) && !in_array($orders, array(0,1))){
		msg::msge('排序错误！');
	}
	if(isset($num) && !is_numeric($num)){
		msg::msge('数目必须为数字！');
	}
	$intro = mysql_real_escape_string($intro);
	$array = array(
			'spname'=>$spname,
			'splabel'=>$splabel,
			'np'=>$np,
			'cateid'=>$npcate,
			'recommend'=>$recommend,
			'isnew'=>$isnew,
			'orders'=>$orders,
			'num'=>$num,
			'intro'=>$intro,
	);
	$result = $db->update(DB_PREFIX."sp",$array,'id='.$id);
	if($result){
		msg::msge('更新碎片成功','listsp.php');
	}else{
		msg::msge('更新碎片失败');
	}
	
} 
$tpl->assign('action',$action);
$tpl->display(ADMIN_TEMPLATE."listsp.tpl");