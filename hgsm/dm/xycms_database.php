<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.26
**/
require '../source/core/run.php';
require 'admin.inc.php';
$action		= Core_Fun::rec_post("action");
if (!file_exists('../data/sqlbackup')){
	@mkdir('../data/sqlbackup', 0777);
	@chmod('../data/sqlbackup', 0777);
}

if($action == 'backup'){
	Core_Auth::checkauth("databasebackup");
	// print_r($_POST);exit;
	/* 分卷大小 */
	$sizelimit = Core_Fun::detect_number(Core_Fun::rec_post('sizelimit'));
	/* 表名 */
	$tabledb = isset($_REQUEST['tabledb']) ? $_REQUEST['tabledb'] : "";
	/* 表名组合 以“|”分开 */
	$tablesel = isset($_REQUEST['tablesel']) ? $_REQUEST['tablesel'] : "";
	/* 当前表名下标 */
	$tableid = Core_Fun::request('tableid');
	// echo($tableid);exit;
	/* 数据开始ID */
	$start = Core_Fun::request('start');
	/* 分卷备份阶梯 */
	$step = Core_Fun::request('step');
	/* 表数据的记录总数 */
	$rows = Core_Fun::request('rows');
	/* 备份文件名 */
	$pre = isset($_REQUEST['pre']) ? $_REQUEST['pre'] : "";
	/* 是否分卷由db_backupdata控制 */
	$fenjuan = 0;
	/* 分卷开始数据记录 由db_backupdata控制 */
	$startfrom = 0;
    /* 当前时间戳 */
	$time = time();
	/* 列出数据表 */
	$db->query("SET SQL_QUOTE_SHOW_CREATE = 0");
	$start = intval($start);
	!$tabledb && !$tablesel && msg::msge('请选择要备份的数据表！');
	!$tabledb && $tabledb = explode("|",$tablesel);
	//!$step && $sizelimit/=2;
	if($sizelimit<200){
		$sizelimit = 200;
	}
	/* 备份表数据 */
	$bakupdata = db_bakupdata($tabledb,$start);
    /* 备份表结构 */
	if(!$step){
		!$tabledb && msg::msge('请选择要备份的数据表！');
		$tablesel = implode("|",$tabledb);
		$step = 1;
		$start = 0;
		$pre = 'xycms_'.date('md',$time).'_'.Core_Fun::get_rndchar(10).'_';
		$bakuptable = db_bakuptable($tabledb);
	}

	/* 备份文件数 */
	$f_num = ceil($step/2);
	/* 备份文件名 */
	$filename = $pre.$f_num.'.sql';
	$step++;

    /* 文件内容组合先执行表结构再执行数据 */
	$writedata = $bakuptable ? $bakuptable.$bakupdata : $bakupdata;
    /* 当前表名 分卷用 */
	$current_table = $tabledb[$tableid-1];
	/* 当前记录数 分卷用 */
    $current_rows = $startfrom;
    
	if($fenjuan==1){
		/* 执行分卷备份 */
		$files = $step-1;
		if(Core_Fun::ischar($writedata)){
			sql_createfile(CHENCY_ROOT.'data/sqlbackup/'.$filename,$writedata,'ab');
		}
		$jumpurl = "xycms_database.php?action=backup&start=$startfrom&tableid=$tableid&sizelimit=$sizelimit&step=$step&pre=$pre&tablesel=$tablesel&rows=$rows";
        
		/* 跳转分卷及其提示 */
		$backup_info = "<meta http-equiv='refresh' content='2; url=$jumpurl'><br />正在备份数据库表[$current_table]，共[$rows]条记录，已经备份至[$current_rows]条记录<br><br>已生成[<b>$f_num</b>]个备份文件，程序将自动备份余下部分。";
		$tpl->assign("jumpurl",$jumpurl);
		$tpl->assign("backup_info",$backup_info);
	} else{

		if(Core_Fun::ischar($writedata)){
			sql_createfile(CHENCY_ROOT.'data/sqlbackup/'.$filename,$writedata,'ab');
		}
		if($step>1){
			for($i=1;$i<=$f_num;$i++){
				$bakfile.='<a href="../data/sqlbackup/'.$pre.$i.'.sql">'.$pre.$i.'.sql</a><br>';
			}
		}
		$backup_info = "恭喜你，数据已全部备份完毕，保存在data/sqlbackup目录下，备份文件为：<br />$bakfile<br /><a href='xycms_database.php'>返回数据备份首页</a>";
		$tpl->assign("backup_info",$backup_info);
		Core_Command::runlog("","备份数据库成功");
	}

} elseif($action=='restore'){
	/* 数据恢复列表 */
	restore_volist();

} elseif($action=='import'){
	Core_Auth::checkauth("databaseimport");
	/* 导入数据 */
	$sqlfile= isset($_GET['sqlfile']) ? trim($_GET['sqlfile']) : "";
	$step   = isset($_GET['step']) ? trim($_GET['step']) : "";
	$count	= isset($_GET['count']) ? trim($_GET['count']) : "";
	if(!Core_Fun::ischar($sqlfile)){
		msg::msge('请选择要导入的SQL文件');
	}
	if(!$count){
		$count = 0;
		$handle = opendir(CHENCY_ROOT.'data/sqlbackup');
		while($file = readdir($handle)){
			if(preg_match("/^$sqlfile/i", $file) && preg_match("/\.sql$/i", $file)){
				$count++;
			}
		}
	}
	!$step && $step=1;
	/* 执行导入 */
	db_importdata(CHENCY_ROOT.'data/sqlbackup/'.$sqlfile.$step.'.sql');

	$i = $step;
	$step++;
	if($count > 1 && $step <= $count){
		$jumpurl = "xycms_database.php?action=import&step=$step&count=$count&sqlfile=$sqlfile";
		$import_info = "分卷：".$sqlfile.$i."导入成功，正准备导入下一卷：".$sqlfile.$i."<br /><meta http-equiv='refresh' content='2; url=$jumpurl'>";
		$tpl->assign("jumpurl",$jumpurl);
		$tpl->assign("import_info",$import_info);
	}else{
		$import_info = "恭喜你，".$sqlfile."相关备份卷导入成功。";
		// Core_Fun::halt($import_info,"xycms_database.php?action=restore",0);
		msg::msge($import_info,'xycms_database.php?action=restore');
	}

} elseif($action=='del'){
	Core_Auth::checkauth("databasedel");
	/* 删除备份文件 */
	$sqlfile = isset($_GET['sqlfile']) ? trim($_GET['sqlfile']) : "";
	if(!Core_Fun::ischar($sqlfile)){
		msg::msge('请选择要删除的备份文件');
	}
	Core_Fun::deletefile("../data/sqlbackup/".$sqlfile);
	Core_Command::runlog("","删除SQL备份文件成功[$sqlfile]");
	msg::msge('备份文件删除成功','xycms_database.php?action=restore');

} else{
	db_volist();
}

/* 显示数据表 */
function db_volist(){
	Core_Auth::checkauth("databasevolist");
	global $db,$tpl;
	$tabledb = array();
	$dbsize = 0;
	$dbnum = 0;
	$i = 1;
	$rs = $db->query("SHOW TABLE STATUS LIKE '".DB_PREFIX."%'");
	while ($dbList = $db->fetch_assoc($rs)) {
		// print_r($dbList);exit;
		$dbres = $db->getRow('CHECK TABLE ' .$dbList['Name']);
		$dbsize += $dbList['Data_length'];
		$tabledb[] = array(
			'i' => $i,
			'table' => $dbList['Name'],
			'type' => $dbList['Engine'],
			'dbnum' => $dbList['Rows'],
			'dbsize' => Core_Fun::format_size($dbList['Data_length']),
			'dbchip' => Core_Fun::format_size($dbList['Data_free']),
			'status' => $dbres['Msg_text'],
			'charset' => $dbList['Collation']
		);
		$i = $i+1;
		$dbnum++;
	}
	unset($rs);
	// print_r($tabledb);exit;
	$upload_max_filesize = intval(@ini_get('upload_max_filesize'));
	$tpl->assign('maxfilesize', $upload_max_filesize * 1024);
	$tpl->assign('dbsize',Core_Fun::format_size($dbsize));
	$tpl->assign("dbnum",$dbnum);
    $tpl->assign("tabledb",$tabledb);
}

/* 数据恢复列表 */
function restore_volist(){
	Core_Auth::checkauth("databaseimport");
	global $tpl;
	$dbtablepre = DB_PREFIX;
	$filedb = array();
	$handle = opendir(CHENCY_ROOT.'data/sqlbackup');
	while($file = readdir($handle)){
		if ((!$dbtablepre || preg_match('/^xycms_/i', $file) || preg_match("/^$dbtablepre/i", $file)) && preg_match('/\.sql$/i', $file)) {
			$strlen = preg_match("/^$dbtablepre/i", $file) ? 16 + strlen($dbtablepre) : 19;
			$fp = fopen(CHENCY_ROOT."data/sqlbackup/" . $file, 'rb');
			$bakinfo = fread($fp, 200);
			fclose($fp);
			$detail = explode("\n", $bakinfo);
			$bk['filename'] = $file;
			$bk['timeline'] = get_filetime(CHENCY_ROOT."data/sqlbackup/".$file);
			$bk['size'] = Core_Fun::format_size(get_filesize(CHENCY_ROOT."data/sqlbackup/".$file));
			//$bk['pre'] = substr($file, 0, $strlen);
			$bk['pre'] = get_filepre($file);
			//$bk['num'] = substr($file, $strlen, strrpos($file, '.') - $strlen);
			$bk['num'] = get_subnum($file);
			$bk['type'] = 'SQL备份文件';
			$filedb[] = $bk;
		}
	}
	$tpl->assign("filedb",$filedb);
}


/* 分卷备份表数据 */
function db_bakupdata($tabledb,$start=0){
	global $db,$sizelimit,$tableid,$startfrom,$fenjuan,$rows;
	$tableid = $tableid ? $tableid-1 : 0;
	$fenjuan = 0;
	$t_count = count($tabledb);
	for($i=$tableid;$i<$t_count;$i++){
		if(!Core_Fun::check_table($tabledb[$i])){
			die("Table[".$tabledb[$i]."] forbid! ");
		}
	    if(!$rows){
			$ts	= $db->get_one("SHOW TABLE STATUS LIKE '$tabledb[$i]'");
			$rows = $ts['Rows'];
        }
		$limitadd = "LIMIT $start,100000";
		$query = $db->query("SELECT * FROM $tabledb[$i] $limitadd");
		$num_F = mysql_num_fields($query);
		// echo($num_F);exit;
		while ($datadb = mysql_fetch_row($query)){
			// print_r($datadb);exit;
			$start++;
			$bakupdata .= "INSERT INTO $tabledb[$i] VALUES("."'".mysql_real_escape_string($datadb[0])."'";
			$tempdb = '';
			for($j=1;$j<$num_F;$j++){
				$tempdb.=",'".mysql_real_escape_string($datadb[$j])."'";
			}
			$bakupdata .=$tempdb. ");\n";
			if($sizelimit && strlen($bakupdata)>$sizelimit*1000){
				$bakupdata .="\n";
				break;
			}
		}
		$db->free_result($query);
		if($start>=$rows){
			$start = 0;
			$rows = 0;
		}
		$bakupdata .="\n";
		// echo($bakupdata);exit;
		if($sizelimit && strlen($bakupdata)>$sizelimit*1000){
			$start == 0 && $i++;
			$fenjuan = 1;
			break;
		}
		$start = 0;
	}
	if($fenjuan == 1){
		$i++;
		$tableid = $i;
		$startfrom = $start;
		$start = 0;
	}
	return $bakupdata;
}

/* 备份全部表信息 */
function db_bakuptable($tabledb){
	global $db;
	foreach($tabledb as $key=>$table){
		if(!Core_Fun::check_table($table)){
			die("Table[".$table."] forbid! ");
		}
		$creattable.= "DROP TABLE IF EXISTS $table;\n";
		$CreatTable = $db->get_one("SHOW CREATE TABLE $table");
		$CreatTable['Create Table']=str_replace($CreatTable['Table'],$table,$CreatTable['Create Table']);
		$creattable.=$CreatTable['Create Table'].";\n\n";
	}
	// echo($creattable);exit;
	return $creattable;
}

/* 导入SQL卷 */
function db_importdata($filename) {
	global $db;
	if(Core_Fun::fileexists($filename)){
		/* 文件存在才执行 */
		$sql = file($filename);
		$query = '';
		$num = 0;
		foreach($sql as $key => $value){
			$value = trim($value);
			if(!$value || $value[0]=='#') continue;
			if(preg_match("/\;$/i", $value)){
				$query .= $value;
				if(preg_match("/^CREATE/i", $query)){
					$extra = substr(strrchr($query,')'),1);
					// echo($extra);
					$query = str_replace($extra,'',$query);
					if($db->version() > '4.1'){
						$extra = DB_CHARSET ? "ENGINE=MyISAM DEFAULT CHARSET=".DB_CHARSET.";" : "ENGINE=MyISAM;";
					}else{
						$extra = "TYPE=MyISAM;";
					}
					$query .= $extra;
					// echo($query);exit;
				}elseif(preg_match("/^INSERT/i", $query)){
					$query = 'REPLACE '.substr($query,6);
					// echo($query);exit;
				}

				$db->query($query);
				$query='';
			} else{
				$query.=$value;
			}
		}
	}
}

/* 创建文件 */
function sql_createfile($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	touch($filename);
	$handle=fopen($filename,$method);
	if($iflock){
		flock($handle,LOCK_EX);
	}
	fwrite($handle,$data);
	if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
}

/* 获取文件大小 */
function get_filesize($a){
	if(file_exists($a)){
		return abs(filesize($a));
	}
}

/* 获取修改时间 */
function get_filetime($a){
	if(file_exists($a)){
		return filemTime($a);
	}
}

/* 
  获取SQL文件名PRE 
  $filename 格式 xxx_xxxx_xxxxxxxxxx_x.sql
*/
function get_filepre($filename){
	if(Core_Fun::ischar($filename)){
		$arr_t = explode("_",$filename);
		$remainlen = strlen($arr_t[max(array_flip($arr_t))]);
		return substr($filename,0,(strlen($filename)-$remainlen));
	}else{
		return "";
	}
}

/* 
  获取分卷号 
  $filename 格式 xxx_xxxx_xxxxxxxxxx_x.sql
*/
function get_subnum($filename){
	if(Core_Fun::ischar($filename)){
		$arr_t = explode("_",$filename);
		$numstring = $arr_t[max(array_flip($arr_t))];
		$numarray  = explode(".",$numstring);
		return $numarray[0];
	}else{
		return "";
	}
}

$tpl->assign("action",$action);
$tpl->display(ADMIN_TEMPLATE."database.tpl");
$tpl->assign("runtime",runtime());
$tpl->assign("copyright",$libadmin->copyright());
?>