<?php
	class region{
		private static $ins = NULL;
		private $max_count = 1000;//运行添加的最大区域个数
		private $segment = NULL;
		
		public function __construct($segment){
			$this->segment = $segment;
		}
		//单例模式--让外部可以生成对象
// 		public function getInstance($segment = NULL){
// 			if(self::$ins instanceof self){
// 				return self::$ins;
// 			}
// 		self::$ins = new self($segment);
// 		return self::$ins;
// 	}
		//区域列表
		public function index()
		{
			require CHENCY_ROOT."source/conf/area.php";
			$sql	= "SELECT COUNT(*) FROM ".DB_PREFIX."region WHERE `flag`=1";
			$total  = $GLOBALS['db']->fetch_count($sql);
			$sql = 'SELECT * FROM '.DB_PREFIX.'region';
			$region = $GLOBALS['db']->getall($sql);
			$area = require CHENCY_ROOT."source/conf/city.php";
			$arealist = array();
			if (!empty($area)) {
				foreach ($area as $key => $value) {
					if (!empty($value['list'])) {
						foreach ($value['list'] as $k => $val) {
							$arealist[] .= $k;
						}
					}
				}
			}
			
			$total = 0;
			if (!empty($arealist)) {
				foreach ($city as $keys => &$value) {
					$num = 0;
					foreach ($value['city'] as $key => &$val) {
						if (in_array($val['en'], $arealist)) {
							$value['city'][$key]['type'] = 1;
						} else {
							$num = $num + 1;
						}
						if (!empty($val['child'])) {
							foreach ($val['child'] as $k => &$v) {
								if (in_array($v['en'], $arealist)) {
									$val['child'][$k]['type'] = 1 ;
								} else {
									$num = $num + 1;
								}
							} 
						}
					}
					if ($num == 0) {
						$city[$keys]['type'] = 1;
					} else {
						$total = $total + 1;
					}
				}
				if ($total == 0) {
					$selectall = 1;
				} else {
					$selectall = 0;
				}
			}

			$GLOBALS[tpl]->assign("city",$city);
			$GLOBALS[tpl]->assign("count",$total);			
			$GLOBALS[tpl]->assign("region",$region);
			$GLOBALS[tpl]->assign("selectall",$selectall);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."region.tpl");
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
				$result = $GLOBALS['db']->update(DB_PREFIX."region",$array,"id={$id}");
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
			$sql = 'SELECT * FROM '.DB_PREFIX."region WHERE `id`='{$id}'";
			$region = $GLOBALS['db']->fetch_first($sql);
			
			$GLOBALS[tpl]->assign("region",$region);
			$GLOBALS[tpl]->assign("action",__FUNCTION__);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."region.tpl");
		}
		//删除列表(ajax删除)
		public function del()
		{
			$id = intval($_GET['id']);
			if($id && is_numeric($id))
			{
				if($GLOBALS['db']->query('DELETE FROM '.DB_PREFIX."region WHERE id={$id}"))
				{
					echo 1;
					exit;
				}
			}
			echo 0;
		}
		//添加区域
		public function add($action = '')
		{
			if($action == 'saveadd'){
				$sql	= "SELECT COUNT(*) FROM ".DB_PREFIX."region WHERE `flag`=1";
				$total  = $GLOBALS['db']->fetch_count($sql);
				if($total >= $this->max_count)
				{
					msg::msge("您最多可以添加{$this->max_count}个区域！");
				}
				$name = trim($_POST['name']);
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
				$result = $GLOBALS['db']->insert(DB_PREFIX.'region',$array);
				if($result){
					msg::msge('添加成功！');
				}
			}
			$GLOBALS[tpl]->assign("action",__FUNCTION__);
			$GLOBALS[tpl]->display(ADMIN_TEMPLATE."region.tpl");	
		}
		
		//选择区域
		public function area()
		{
			$array = $_POST;
			$file = CHENCY_ROOT.'source/conf/city.php';
			$str = "<?php\nreturn ".var_export($array, true).';';
			if(file_put_contents($file, $str)){
				header("Content-type:text/html;charset=utf-8");
				echo '<script language=javascript>';
				echo 'alert("更新成功");';
				echo 'self.location=document.referrer;';
		        echo '</script>';
		        exit;
			}
		}
		
		
		
		
		
		
	}