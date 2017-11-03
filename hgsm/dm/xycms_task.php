<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
require '../source/core/run.php';
require 'admin.inc.php';
setting();
function setting(){
	global $config,$tpl;
	$taskConfigFile = CHENCY_ROOT.'data/cache/task_config.php';
	if(!file_exists($taskConfigFile)){
		touch($taskConfigFile);
	}
	require CHENCY_ROOT.'source/module/mod.info.php';
	$cate = Mod_Info::category();
	$taskConfig = require $taskConfigFile;
	if(!isset($_POST['dosubmit'])){
		$cid_select = '';
		if(!empty($taskConfig)){
			$cid_select 			     = $taskConfig['cid'];
			$taskConfig['start_time']    = $taskConfig['start_time'] ? date("Y-m-d",$taskConfig['start_time']) : date("Y-m-d"); 
			$taskConfig['end_time']      = $taskConfig['end_time'] ? date("Y-m-d",$taskConfig['end_time']) : '';
			$taskConfig['interval_time'] = intval(intval($taskConfig['interval_time'])/3600);
			$taskConfig['rate_count'] 	 = $taskConfig['rate_count'];
			$taskConfig['flag']          = $taskConfig['flag'] ? ' checked="checked"' : '';
		}
		$taskConfig['cate_select'] = get_select($cate, $cid_select);
		$tpl->assign("cate_select",$cate_select);
		$tpl->assign("taskConfig",$taskConfig);
	}else{
		$data['title']	    = Core_Fun::safe_replace($_POST['title']);
		$data['start_time'] = intval(strtotime($_POST['start_time']));
		$data['end_time']   = intval(strtotime($_POST['end_time']));
		$data['lastUpdate']   = intval($_POST['lastUpdate']);
		$data['rate_count'] = intval($_POST['rate_count']);
		$data['flag']       = isset($_POST['flag']) ? intval($_POST['flag']) : 0;
		$data['cid']        = isset($_POST['cate']) ? Core_Fun::safe_replace($_POST['cate']) : '';
		$data['interval_time'] = intval($_POST['interval_time']) ? intval($_POST['interval_time'])*3600 : 0;
		
		if(empty($data['start_time'])){
			msg::msge('开始时间不能为空');
		}
		if(!empty($data['end_time']) && $data['start_time'] >= $data['end_time']){
			msg::msge('开始时间不能大于结束时间');
		}
		if(file_exists($taskConfigFile)){
			$configStr = "<?php \nreturn ".var_export($data,true).';';
			if(file_put_contents($taskConfigFile, $configStr)){
				msg::msge('保存成功');
			}
		}
		
	}
}
//获取分类的多选
function get_select($data,$cid_arr = array()){
	$cate_select = '';
	if(!empty($data)){
		$cate_select .= '<select multiple="multiple" name="cate[]">';
		foreach($data as $key=>$val){
			$seleced = !empty($cid_arr) && in_array($val['cid'], $cid_arr) ? " selected='selected'" : '';
			$cate_select .= "<option value='{$val['cid']}'{$seleced}>{$val['cname']}</option>";
		}
		$cate_select .= '</select>';
	}
	return $cate_select;
}
$tpl->display(ADMIN_TEMPLATE."task.tpl");