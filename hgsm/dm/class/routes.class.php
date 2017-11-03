<?php
	class routes{
		
		public function __construct(){
			
		}
		
		public function region_routes($arr){
			if(!empty($arr) && is_array($arr)){
				$action = $arr[0];
				require './class/region.class.php';
				$region = region::getInstance();
				unset($arr[0]);
// 				print_r($arr);
// 				exit;
			}
		}
		
		//URL路由,转为PATHINFO的格式
		public static function parseUrl($model){
			if(!empty($model)){
				if(isset($_SERVER['PATH_INFO'])){
					//获取 pathinfo
					$pathinfo = explode('/', trim($_SERVER['PATH_INFO'], "/"));
					$action   = $pathinfo[0] ? $pathinfo[0] : 'index';
					array_shift($pathinfo);
					$segment   = $pathinfo;
					$arguments = NULL;
					if(!empty($segment) && is_array($segment)){
						foreach($segment as $key=>$val){
							$arguments .= "{$val},";
						}
						if(! empty($arguments)){
							$arguments = substr($arguments,0,-1);
						}
					}
					$modelFile = "./class/{$model}.class.php";
					if(file_exists($modelFile)){
						require $modelFile;
					}else{
						exit("$modelFile dont't exists!");
					}
					$obj = new $model($segment);
					if(method_exists($obj,$action)){
						$obj->$action($arguments);
					}else{
						exit("$model dont't have $action function!");
					}
				}	
			}
		}
	}