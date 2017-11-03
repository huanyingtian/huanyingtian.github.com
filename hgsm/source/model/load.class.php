<?php
class load{
	public function __construct(){
		
	}
	
	/**
	 * 加载类
	 */
	public static function load_class($classname, $path = '', $initialize = 1) {
		static $classes = array();
		if (empty($path)){
			$path = 'source/';
		}else{
			$path = "{$path}/";
		}
		$key = md5($path.$classname);
		if(isset($classes[$key])){
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
		if(file_exists(CHENCY_ROOT.$path.$classname.'.class.php')){
			require CHENCY_ROOT.$path.$classname.'.class.php';
			$name = $classname;
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			return $classes[$key];
		}else{
			return false;
		}		
	}
}