<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XYCMS v1.0
 * @Update     2011.09.23
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Core_Fun{

    protected static $obj = NULL;
    
	public static function replacebadchar($str){
		if(empty($str)) return;
		if($str=="") return;
		$str = trim($str);
		$str = str_replace("'","",$str);
// 		$str = str_replace("=","",$str);
		$str = str_replace("#","",$str);
		$str = str_replace("$","",$str);
		$str = str_replace(">","",$str);
		$str = str_replace("<","",$str);
		$str = str_replace("\\","",$str);
		$str = str_replace("*","",$str);
	//	$str = str_replace("%","",$str);
		return $str;
	}
	
	/**
	 * @ 获取分类配置关键词
	 * @ param $dbtable 表名
	 * @ param $dbkeywords 表字段
	 * @ return string  
	 */
	
	public static function keyword($dbtable,$dbkeywords){
		self::$obj	= $GLOBALS['db'];
		$word_string = '';
		$sql  = "SELECT $dbkeywords FROM ".DB_PREFIX.$dbtable." WHERE flag=1";
		$arr_word = self::$obj->getall($sql);  
			foreach($arr_word as $key => $val){
			   $word_val = $val["".$dbkeywords.""];
			   $word_val  = str_replace(" ", "",$word_val);
				if(!empty($word_val)){
				   $word_val  = str_replace("，", ",",$word_val);
				   $word_val  =  rtrim($word_val, ',');
		           $word_string .= $word_val.',';
			   }
		}
	    return $word_string;
	}

	/**
	 * 判断自定义p页面是否存在
	 * @param $string
	 */
    public static function dir_word($_word){
        $file = CHENCY_ROOT.'template/default/p/'.$_word.'.tpl';
		if(file_exists($file)){ 
	      return false;
	    }else{ 
		  return true;
		} 
	}

	/* count */
	public static function counts($dbtable){
		self::$obj = $GLOBALS['db'];
		return self::$obj->fetch_count("SELECT COUNT(id) FROM ".DB_PREFIX.$dbtable." WHERE flag=1");
	}

    /**
	 * 判断pagecate是否有子级
	 *
	 * @param $string
	 * @return string
	 */
	
	public static function exist_child($id,$dbtable){
		self::$obj		= $GLOBALS['db'];
		$child_counts	= self::$obj->fetch_count("SELECT COUNT(cid) FROM ".DB_PREFIX.$dbtable." WHERE cid=$id");
		if($child_counts>0){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 安全过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	public static function safe_replace($string) {
		if(!empty($string) && is_array($string)){
			foreach($string as $key => $val){
				$string[$key] = self::safe_replace($val);
			}
		}else{
			$string = str_replace('%20','',$string);
			$string = str_replace('%27','',$string);
			$string = str_replace('%2527','',$string);
			$string = str_replace('*','',$string);
			$string = str_replace('"','&quot;',$string);
			$string = str_replace("'",'',$string);
			$string = str_replace('"','',$string);
			$string = str_replace(';','',$string);
			$string = str_replace('<','&lt;',$string);
			$string = str_replace('>','&gt;',$string);
			$string = str_replace("{",'',$string);
			$string = str_replace('}','',$string);
			$string = str_replace('\\','',$string);
			$string = trim($string);
	
		}
		return $string;
	
	}
	
	/*  增加反斜杠  */
	public static function daddslashes($string, $force = 0) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = self::daddslashes($val, $force);
				}
			} else {
				$string = addslashes($string);
			}
		}
		return $string;
	}
	/*  去掉反斜杠  */
	public static function strip_array(&$_data){
		if (is_array($_data)){
			foreach ($_data as $_key => $_value){
				$_data[$_key] = trim(strip_array($_value));
			}
			return $_data;
		}else{
			return stripslashes(trim($_data));
		}
	}
	public static function isemail($email)
	{
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}
	
	public static function ischar($_string)
	{
		if(empty($_string) || $_string == '')
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public static function isnumber($_string)
	{
		if(is_numeric($_string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function writelog($file, $log) {
		$yearmonth = gmdate('Ym', time());
		$logdir    = CHENCY_ROOT.'./data/logs/';
		$logfile = $logdir.$yearmonth.'_'.$file.'.php';
		if(@filesize($logfile) > 2048000) {
			$dir = opendir($logdir);
			$length = strlen($file);
			$maxid = $id = 0;
			while($entry = readdir($dir)) {
				if(strexists($entry, $yearmonth.'_'.$file)) {
					$id = intval(substr($entry, $length + 8, -4));
					$id > $maxid && $maxid = $id;
				}
			}
			closedir($dir);

			$logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.php';
			@rename($logfile, $logfilebak);
		}
		if($fp = @fopen($logfile, 'a')) {
			@flock($fp, 2);
			$log = is_array($log) ? $log : array($log);
			foreach($log as $tmp) {
				fwrite($fp, "<?PHP exit;?>\t".str_replace(array('<?', '?>'), '', $tmp)."\n");
			}
			fclose($fp);
		}
	}
	public static function wipespecial($str) {
		return str_replace(array( "\n", "\r", '..'), array('', '', ''), $str);
	}
	public static function request($name,$posttype=0,$recbad=0,$strip=0){
		if($posttype==1){
			$post = isset($_POST[$name]) ? $_POST[$name] : '';
		}elseif($posttype==2){
			$post = isset($_GET[$name]) ? $_GET[$name] : '';
		}else{
			$post = isset($_REQUEST[$name]) ? $_REQUEST[$name] : '';
		}
		if((int)$recbad==1){
			$post = self::replacebadchar($post);
		}
		if((int)$strip==1){
			$post = self::strip_array($post);
		}
		return trim($post);
	}
	public static function rec_post($name,$type=0){
		return self::request($name,$type,1,0);
	}
	public static function rec_get($name,$type=2){
		return self::request($name,$type,1,0);
	}
	public static function strip_post($name,$type=0){
		return self::request($name,$type,0,1);
	}
	public static function detect_number($item,$resetvalue=0){
		if(!self::isnumber($item)){
			$item = intval($resetvalue);
		}
		return intval($item);
	}
	public static function array_post($name){
		$temps = "";
		$array = isset($_POST[$name]) ? $_POST[$name] : '';
		for($ii=0;$ii<count($array);$ii++){
			$val = self::replacebadchar($array[$ii]);
			if(self::ischar($val)){
				if($ii==0){
					$temps = $val;
				}else{
					if($temps==""){
						$temps = $val;
					}else{
						$temps = $temps.",".$val;
					}
				}
			}
		}
		return $temps;
	}

	/* 2011.09.23 */

	public static function ltCode($string){
		if(self::ischar($string)){
			$string  = str_replace("<","&lt;",$string);
			$string  = str_replace(">","&gt;",$string);
			$string  = str_replace("\"","&quot;",$string);
			//$string  = str_replace("'","&#39;",$string);
		}
		return $string;
	}

	/* HTML DECODE */
	public static function htmlDecode($string){
		if(self::ischar($string)){
			$string  = str_replace("&lt;","<",$string);
			$string  = str_replace("&gt;",">",$string);
			$string  = str_replace("&quot;","\"",$string);
			//$string  = str_replace("&#39;","'",$string);
		}
		return $string;
	}

	/* HTML ENCODE 转换<>符号为 &lt;与&gt; 内容显示用 */
	public static function htmlEncode($str){
		$str = str_replace("<!--{","&lt;!--{",$str); //过滤系统特定起始标签
		$str = str_replace("}-->","}--&gt;",$str); //过滤系统特定结束标签
		$str = str_replace("<?","&lt;?",$str);
		$str = str_replace("?>","?&gt;",$str);
		$str = preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si","&lt;$1&gt;$2&lt;$3&gt;",$str); //过滤script标签
		$str = preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si","&lt;$1&gt;$2&lt;$3&gt;",$str); //过滤frame标签
		$str = preg_replace("/<\!--.*?-->/si","&lt;!--$1--&gt;",$str); //注释
		$str = preg_replace("/<(\/?html.*?)>/si","$1",$str); //过滤html标签
		$str = preg_replace("/<(\/?head.*?)>/si","$1",$str); //过滤head标签
		$str = preg_replace("/<(\/?meta.*?)>/si","$1",$str); //过滤meta标签
		$str = preg_replace("/<(\/?body.*?)>/si","$1",$str); //过滤body标签
		$str = preg_replace("/<(\/?link.*?)>/si","$1",$str); //过滤link标签
		$str = preg_replace("/<(\/?form.*?)>/si","$1",$str); //过滤form标签
		$str = preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si","&lt;$1&gt;$2&lt;$3&gt;",$str); //过滤style标签
		$str = preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si","&lt;$1&gt;$2&lt;$3&gt;",$str); //过滤title标签
		return $str;
	}
    /* 2011.09.23 */

	public static function get_rndchar($length,$type=0){
		switch($type){
			case 1:$pattern="1234567890";break;
			case 2:$pattern="abcdefghijklmnopqrstuvwxyz";break;
			case 3:$pattern="ABCDEFGHIJKLMNOPQRSTUVWXYZ";break;
			case 4:$pattern="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890~!@#$%^&*()_-+=";break;
			default:$pattern="1234567890abcdefghijklmnopqrstuvwxyz";
		}
		$size=strlen($pattern)-1;
		$key=$pattern{rand(0,$size)};
		for($i=1;$i<$length;$i++)
		{
			$key.= $pattern{rand(0,$size)};
		}
		return $key;
	}
	public static function getip(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		$one='([0-9]|[0-9]{2}|1\d\d|2[0-4]\d|25[0-5])';
		if(!@preg_match('/'.$one.'\.'.$one.'\.'.$one.'\.'.$one.'$/', $ip)){$ip='0.0.0.0';};
		return $ip;
	}
	public static function get_cookie($name){
		if(empty($_COOKIE[$name])){
			return "";
		}else{
			return self::replacebadchar($_COOKIE[$name]);
		}
	}
	public static function set_cookie($name,$val,$expire = 1) {
		setcookie($name, $val, (time() + $expire*3600),"/");
	}
	public static function dhtmlspecialchars($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = self::dhtmlspecialchars($val);
			}
		} else {
			$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		}
		return $string;
	}
	public static function check_strpos($s_str,$s_needlechar){
		if(!self::ischar($s_str)){return;}
		if(!self::ischar($s_needlechar)){return;}
		$s_temparray = explode($s_needlechar,$s_str);
		if(count($s_temparray)>0){
			return true;
		}else{
			return false;
		}
	}
	public static function htmdecode($s_content) {
		$s_content = str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $s_content));
		return $s_content;
	}
	public static function replacebr($s_content){
		$s_content = str_replace("\n", "<br />", $s_content);
		return $s_content;
	}
	public static function filterhtml($_obfuscate_R2_b,$_obfuscate_KT_ujQ = false){
		if($_obfuscate_KT_ujQ){
			$_obfuscate_dcwitxb = array( "/<img[^\\<\\>]+src=['\"]?([^\\<\\>'\"\\s]*)['\"]?/is", "/<a[^\\<\\>]+href=['\"]?([^\\<\\>'\"\\s]*)['\"]?/is", "/on[a-z]+[\\s]*=[\\s]*\"[^\"]*\"/is", "/on[a-z]+[\\s]*=[\\s]*'[^']*'/is" );
			$_obfuscate_77tGbWOiZg   = array( "\\1<br>\\0", "\\1<br>\\0", "", "" );
			$_obfuscate_R2_b = preg_replace( $_obfuscate_dcwitxb, $_obfuscate_77tGbWOiZg  , $_obfuscate_R2_b );
		}
		$_obfuscate_dcwitxb = array( "/([\r\n])[\\s]+/", "/\\<br[^\\>]*\\>/i", "/\\<[\\s]*\\/p[\\s]*\\>/i", "/\\<[\\s]*p[\\s]*\\>/i", "/\\<script[^\\>]*\\>.*\\<\\/script\\>/is", "/\\<[\\/\\!]*[^\\<\\>]*\\>/is", "/&(quot|#34);/i", "/&(amp|#38);/i", "/&(lt|#60);/i", "/&(gt|#62);/i", "/&(nbsp|#160);/i", "/&#(\\d+);/", "/&([a-z]+);/i" );
		$_obfuscate_77tGbWOiZg   = array( " ", "\r\n", "", "\r\n\r\n", "", "", "\"", "&", "<", ">", " ", "-", "" );
		$_obfuscate_R2_b = preg_replace( $_obfuscate_dcwitxb, $_obfuscate_77tGbWOiZg  , $_obfuscate_R2_b );
		$_obfuscate_R2_b = strip_tags( $_obfuscate_R2_b );
		return $_obfuscate_R2_b;
	}
	public static function cut_str($string,$sublen,$start=0,$code='UTF-8'){
		if($code == 'UTF-8' OR $code == 'utf-8'){
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)).""; return join('', array_slice($t_string[0], $start, $sublen));
		}else{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
			for($i=0; $i< $strlen; $i++){
				if($i>=$start && $i< ($start+$sublen)){
					if(ord(substr($string, $i, 1))>129){
						$tmpstr.= substr($string, $i, 2);
					}else{
						$tmpstr.= substr($string, $i, 1);
					}
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			return $tmpstr;
		}
	}
	public static function foundinarr($s_strarr,$s_tofind,$s_strsplit){
		$s_flag = false;
		if(!self::ischar($s_strarr) || !self::ischar($s_tofind)){
			$s_flag = false;
		}else{
			$arrtemp = explode($s_strsplit,$s_strarr);
			for($s_i=0;$s_i<sizeof($arrtemp);$s_i++){
				$s_value = trim($arrtemp[$s_i]);
				if($s_value==$s_tofind){
					$s_flag = true;
					break;
				}
			}
		}
		return $s_flag;
	}
	public static function utftogbk($value){
		return iconv("UTF-8","gbk",$value);
	}
	public static function gbktoutf($value){
		return iconv("gbk","UTF-8",$value);
	}
	public static function price_format($price,$pricetype=1,$change_price = true){
		if ($change_price){
			switch ($pricetype){
				case 0: //保留2位小数点
					$price = number_format($price, 2, '.', '');
					break;
				case 1: // 保留不为 0 的尾数
					$price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));
					if (substr($price, -1) == '.'){
						$price = substr($price, 0, -1);
					}
					break;
				case 2: // 不四舍五入，保留1位
					$price = substr(number_format($price, 2, '.', ''), 0, -1);
					break;
				case 3: // 直接取整
					$price = intval($price);
					break;
				case 4: // 四舍五入，保留 1 位
					$price = number_format($price, 1, '.', '');
					break;
				case 5: // 先四舍五入，不保留小数
					$price = round($price);
					break;
			}
		}else{
			$price = number_format($price, 2, '.', '');
		}
		return $price;
	}
	public static function getdatetime($_timer,$_type=0){
		if($_type==1){
			$_newtime = date('Y-m-d',$_timer);
		}else{
			$_newtime = date('Y-m-d H:i:s',$_timer);
		}
		return $_newtime;
	}
	public static function mb($_string,$_comurl,$_gotype){
		echo("<meta http-equiv='Content-Type' content='text/html; charset=".PHPOE_CHARSET."' />");
		echo"<script language=javascript>alert('".$_string."');";
		if($_gotype==1){
			echo"window.history.go(-1);";
		}else{
			echo"window.location.href='".$_comurl."';";
		}
		echo"</script>";
		die();
	}
// 	public static function halt($message,$forwardurl,$msgtype){
// 		require_once CHENCY_ROOT.'./source/core/func_haltmsg.php';
// 		die();
// 	}
	public static function formattime($_datetime,$_type){
		switch($_type){
			case 1;
			$_newtime = date('Y-m-d',strtotime($_datetime));
			break;

			case 2;
			$_newtime = substr($_datetime,5,5);
			$_newtime = str_replace("-","/",$_newtime);
			break;

			default;
			$_newtime = date('Y-m-d H:i:s',strtotime($_datetime));
			break;
		}
		return $_newtime;
	}
	public static function get_filecontent($s_url){
		if(!self::ischar($s_url)){
			return;
		}
		$s_content = file_get_contents($s_url);
		return $s_content;
	}
	public static function createfile($s_content,$s_filename){
		if(!self::ischar($s_filename)){
			return;
		}
		if(!self::ischar($s_content)){
			return;
		}
		$s_fso = fopen($s_filename,'w');
		if($s_fso){
			fwrite($s_fso,$s_content);
		}
		fclose($s_fso);
	}
	public static function deletefile($s_filename){
		if(!self::ischar($s_filename)){
			return;
		}
		@unlink($s_filename);
	}
	public static function deletefolder($dir) {
		if(file_exists($dir)){
			$dh=opendir($dir);
			while ($file=readdir($dh)) {
				if($file!="." && $file!="..") {
					$fullpath=$dir."/".$file;
					if(!is_dir($fullpath)) {
						unlink($fullpath);
					} else {
						deldir($fullpath);
					}
				}
			}
			closedir($dh);
			if(rmdir($dir)) {
				return true;
			} else {
				return false;
			}
		}
	}
	public static function check_email($s_email){
		$pattern="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";
		if(preg_match($pattern,$s_email,$matches)){
			return true;
		}else{
			return false;
		}
	}
	public static function check_userstr($s_str){
		if(preg_match("/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u",$s_str)){
			return true;
		}else {
			return false;
		}
	}
	/* 检测数据表 */
	public static function check_table($tablename){
		if(preg_match("/^[0-9a-zA-Z_]+$/u",$tablename)){
			return true;
		}else {
			return false;
		}
	}

	public static function check_userlen($str) {
		$str = strtolower($str);
		$name_len = strlen($str);
		$temp_len = 0;
		for($i=0;$i< $name_len;){
			if (strpos ('abcdefghijklmnopqrstvuwxyz0123456789_',$str[$i])==false){
				$i = $i + 3;
				$temp_len += 2;
			}else{
				$i = $i + 1;
				$temp_len += 1;
			}
		}
		return $temp_len;
	}
	/*
	 $Id 组合SQL OR 语句
	 $asname  -- MYSQL 表 别名
	 $field   -- 字段名
	 $sqlitem -- 值 格式 为单个数字或者 多个用逗号隔开的数字
	*/
	public static function combin_sqlor($asname,$field,$sqlitem){
		if(self::ischar($sqlitem)){
			if(self::isnumber($sqlitem)){
				if(self::ischar($asname)){
					$temp = " AND ".$asname.".".$field."=".intval($sqlitem)."";
				}else{
					$temp = " AND ".$field."=".intval($sqlitem)."";
				}
			}else{
				$splitarray = explode(",",$sqlitem);
				for($i=0;$i<sizeof($splitarray);$i++){
					if(self::ischar($asname)){
						$temp .= " ".$asname.".".$field."=".intval($splitarray[$i])." OR";
					}else{
						$temp .= " ".$field."=".intval($splitarray[$i])." OR";
					}
				}
				$temp = substr($temp,0,(strlen($temp)-3));
				$temp = " AND (".$temp." )";
			}
		}else{
			$temp = " ";
		}
		return $temp;
	}
	public static function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR"){
		if(!is_array($ArrayData)){
			return $ArrayData;
		}
		$ArgCount = func_num_args();
		for($I = 1;$I < $ArgCount;$I ++){
			$Arg = func_get_arg($I);
			if(!eregi("SORT",$Arg)){
				$KeyNameList[] = $Arg;
				$SortRule[]= '$'.$Arg;
			}else{
				$SortRule[]= $Arg;
			}
		}
		foreach($ArrayData AS $Key => $Info){
			foreach($KeyNameList AS $KeyName){
				${$KeyName}[$Key] = $Info[$KeyName];
			}
		}
		$EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
		eval ($EvalString);
		return $ArrayData;
	}

	/*
	  检测文件是否存在
	  @params::$fliename --文件_带路径
	  @update:: 2011.09.23
	*/
	public static function fileexists($fliename){
		if(file_exists($fliename)){
			return true;
		}else{
			return false;
		}
	}

	/* 过滤SQL语句
	   如果含有注入字符，则置为空
	   @update:: 2011.09.23
	*/
	public static function forbidchar($string){
		$forbidchar = array('select','update','delete','union','insert','load_file','outfile','where','char','concat');
		if(self::ischar($string)){
			foreach($forbidchar as $key){
				if(strpos(strtolower($string),$key)){
					$string = "";
				}
			}
		}
		return $string;
	}

	public static function format_size($size) {
		if ($size <1000) {
		$size_BKM = (string) $size .' B';
		}elseif ($size <(1000 * 1000)) {
		$size_BKM = number_format((double) ($size / 1000),1) .' KB';
		}else {
		$size_BKM = number_format((double) ($size / (1000 * 1000)),1) .' MB';
		}
		return $size_BKM;
	}

	/* 对二维数组进行排序 */

	function array_sort($arr,$keys,$type='asc'){
       $keysvalue = $new_array = array();
       foreach ($arr as $k=>$v){
       $keysvalue[$k] = $v[$keys];
        }
       if($type == 'asc'){
       asort($keysvalue);
       }else{
       arsort($keysvalue);
        }
       reset($keysvalue);
       foreach ($keysvalue as $k=>$v){
       $new_array[$k] = $arr[$k];
         }
       return $new_array;
     }

	/* 页面运行时间 */
	public static function runtime(){
		return "<font color='#999999'>Processed in ".Core_Timer::display()." second(s) , ".$GLOBALS['db']->querynum." queries<br /></font>";
	}

	/*截取字符串（包含中文）*/

   public static function utf8Substr($str,$from,$len)
{
  return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
  '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
  '$1',$str);
}
  //  对详细页面的页面描述进行过滤和截取
  public static function de_cut($content,$len,$etc = '...'){
    $str = $content;
    $str = preg_replace('#<script[^>]*?>.*?</script>#si','',$str);
    $str = preg_replace('#<style[^>]*?>.*?</style>#si','',$str);
    $str = str_replace(PHP_EOL,"",$str);
    $str = str_replace('&nbsp;',"",$str);
    $str = strip_tags($str);
    $str = self::str_cut($str,$len * 2,$etc);
    return $str;
  }
  //截取字符
public static function str_cut($string, $sublen = 80, $etc = '')
{
	$start=0;
	$code="UTF-8";
       if($code == 'UTF-8') 
   { 
       //如果有中文则减去中文的个数
       $cncount=self::cncount($string);
       if($cncount>($sublen/2)){
           $sublen=ceil($sublen/2);
       }else {
            $sublen=$sublen-$cncount;
        }
       $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
       preg_match_all($pa, $string, $t_string);
       if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)).$etc; 
       return join('', array_slice($t_string[0], $start, $sublen));
   }else{ 
       $start = $start*2; 
       $sublen = $sublen*2;
       $strlen = strlen($string); 
       $tmpstr = '';
       for($i=0; $i<$strlen; $i++) { 
           if($i>=$start && $i<($start+$sublen)) 
           { 
               if(ord(substr($string, $i, 1))>129) 
               { 
                   $tmpstr.= substr($string, $i, 2); 
               } 
               else 
               { 
                   $tmpstr.= substr($string, $i, 1); 
               } 
           } 
           if(ord(substr($string, $i, 1))>129) $i++;
       } 
       if(strlen($tmpstr)<$strlen ) $tmpstr.= $etc; 
       return $tmpstr;
   }
}

private static function cncount($str){
$len=strlen($str);
    $cncount=0;
    for($i=0;$i<$len;$i++){
      $temp_str=substr($str,$i,1);
      if(ord($temp_str) > 127)
      { $cncount++; }
     }
    return ceil($cncount/3);
}
  



}
?>