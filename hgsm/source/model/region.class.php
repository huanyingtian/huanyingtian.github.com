<?php
class region{
	public function __construct(){
		
	}

	//所有区域
	public function allRegion(){
		$sql = 'SELECT * FROM '.DB_PREFIX.'region';
		$result = $GLOBALS['db']->getall($sql);
		return $result;
	}
	
	//更具en查找对应的区域
	public function regionEnSearch($en){
		$result = NULL;
		if($en){
			$en = addslashes($en);
			$sql = 'SELECT * FROM '.DB_PREFIX."region WHERE `en`='{$en}'";
			$result = $GLOBALS['db']->fetch_first($sql);
			if(!$result){
				$region =  require CHENCY_ROOT.'./source/conf/city.php';
				if (!empty($region)) {
					foreach ($region as $key => $value) {
						if (!empty($value['list'])) {
							foreach ($value['list'] as $k => $val) {
								if ($en == $k) {
									$result['name'] = $val;
									$result['en']   = $k;
								}
							}
						}
					}
				}
			}
		}
		return $result;
	}
}