<?php
	class matchregion{
		private static $ins = NULL;
		private $max_count = 10;//运行添加的最大区域个数
		private $segment = NULL;
		
		public function __construct($segment){
			$this->segment = $segment;
		}
		//单例模式--让外部可以生成对象
		// public function getInstance($segment = NULL){
		// 		if(self::$ins instanceof self){
		// 			return self::$ins;
		// 		}
		// 	self::$ins = new self($segment);
		// 	return self::$ins;
		// }
		//区域列表
		public function index(){
			$sql	= "SELECT COUNT(*) FROM ".DB_PREFIX."matchregion WHERE `flag`=1";
			$total  = $GLOBALS['db']->fetch_count($sql);
			$sql = 'SELECT * FROM '.DB_PREFIX.'matchregion';
			$region = $GLOBALS['db']->getall($sql);	
			$GLOBALS[tpl]->assign("count",$total);			
			$GLOBALS[tpl]->assign("region",$region);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."matchregion.tpl");
		}
		//编辑区域列表
		public function edit()
		{
			if(isset($_POST['btn_save']) && !empty($_POST['btn_save']))
			{
				$id   = intval($_POST['id']);
				$name = trim($_POST['name']);				
				$en   = str_replace(' ', '', $_POST['en']);
				require CHENCY_ROOT."dm/class/spell.class.php";
				$pinyin = new spell();
				$en = empty($en) ? $pinyin->pinyin($name) : $en;
				$array = array(
					'name'=>$name,
					'en'=>$en	
				);
				$result = $GLOBALS['db']->update(DB_PREFIX."matchregion",$array,"id={$id}");
				if($result){
					msg::msge('更新成功');
				}else{
					msg::msge('更新失败');
				}
				exit;
			}
			$id  = intval($this->segment[0]);
			if(!$id){
				exit('Region Id Error!');
			}
			$sql = 'SELECT * FROM '.DB_PREFIX."matchregion WHERE `id`='{$id}'";
			$region = $GLOBALS['db']->fetch_first($sql);
			
			$GLOBALS[tpl]->assign("region",$region);
			$GLOBALS[tpl]->assign("action",__FUNCTION__);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."matchregion.tpl");
		}
		//删除列表(ajax删除)
		public function del()
		{
			$id = intval($_GET['id']);
			if($id && is_numeric($id))
			{
				if($GLOBALS['db']->query('DELETE FROM '.DB_PREFIX."matchregion WHERE id={$id}"))
				{
					echo 1;
					exit;
				}
			}
			echo 0;
		}
		//添加区域
		public function add($action = ''){
			if($action == 'saveadd'){
				$name   = trim($_POST['name']);
				$sql	= "SELECT * FROM ".DB_PREFIX."region WHERE name='{$name}' and flag=1";
				$rels   = $GLOBALS['db']->fetch_first($sql);
				if($rels){
					msg::msge('主营区域已经有该区域,请不要重复填写！');
				}
				$sql_m  = "SELECT * FROM ".DB_PREFIX."matchregion WHERE name='{$name}' and flag=1";
				$result = $GLOBALS['db']->fetch_first($sql_m);
				if($result){
					msg::msge('匹配区域已经有该区域,请不要重复填写！');
				}
				
				if(empty($name)){
					msg::msge('城市不可以为空');
				}
				if(isset($_POST['en']) && !empty($_POST['en'])){
					$en   = str_replace(' ', '', $_POST['en']);
					if(!empty($en)){
						if(!preg_match("/^[0-9a-zA-Z_]{4,20}$/",$en)){
							msg::msge('只能是英文字母,数字,_,且长度必须是4-20个字符!');
						}		
					}else{
						msg::msge('城市的英文不可以空');
					}
				}
				require CHENCY_ROOT."dm/class/spell.class.php";
				$pinyin = new spell();
				$en = empty($en) ? $pinyin->pinyin($name) : $en;
				$array = array(
					'name'=>$name,
					'en'=>$en,	
				);
				$result = $GLOBALS['db']->insert(DB_PREFIX.'matchregion',$array);
				if($result){
					msg::msge('添加成功！');
				}
			}
			$GLOBALS[tpl]->assign("action",__FUNCTION__);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."matchregion.tpl");	
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}