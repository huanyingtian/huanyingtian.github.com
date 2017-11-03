<?php
class model{
	protected $config = NULL;
	protected $obj    = NULL;
	protected $table  = 'product'; 
	public function __construct(){
		$this->obj    = $GLOBALS['db'];		
		$this->config = $GLOBALS['config'];
	}
	public function setTable($table){
		$this->table = $table;
	}	
	public function content_change(&$content){
		if($this->table == 'info'){
			$this->table = 'news';
		} 
		if($this->table == "product"){
			foreach($content as $key=>$value){
				$content[$key]['url']      = M_PATH_URL."{$this->table}/{$value['id']}.html";
				$content[$key]['caturl']   = M_PATH_URL."product/{$value['word']}/";
				$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 80,'...');
				if(isset($value['target']) && $value['target'] == 2){
					$content[$key]['target'] = "_blank";
				}
				if($value['thumbfiles'] == ''){
					$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
				}else{
					$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				}
			}
		}elseif($this->table == "news"){
			foreach($content as $key=>$value){
				$content[$key]['url']   	  = M_PATH_URL."{$this->table}/{$value['id']}.html";
				$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 36,'...');
				if(isset($value['target']) && $value['target'] == 2){
					$content[$key]['target'] = "_blank";
				}
				if($value['thumbfiles'] == ''){
					$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
				}else{
					$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				}
			}
		}else{
			foreach($content as $key=>$value){
				$content[$key]['url']   	  = M_PATH_URL."{$this->table}/{$value['id']}.html";
				$content[$key]['summary']  = Core_Fun::de_cut($value['content'], 36,'...');
				if(isset($value['target']) && $value['target'] == 2){
					$content[$key]['target'] = "_blank";
				}
				if($value['thumbfiles'] == ''){
					$content[$key]['thumbfiles'] = PATH_URL."template/static/images/nopic.jpg";
				}else{
					$content[$key]['thumbfiles'] = PATH_URL.$value['thumbfiles'];
				}
			}
		}
		
	}
	
}