<?php
//异步信息类
class ajaxInfo{
	private $id = '';
	//构造函数
	public function __construct($id = ''){
		$this->id = $id;
	}
	public function build_childsql($s_table,$s_as="",$s_rootid,$s_sqlstr="")
	{
		global $db;
		if(Core_Fun::isnumber($s_rootid))
		{
			$child_sql = "SELECT cid FROM ".DB_PREFIX.$s_table." WHERE parentid=$s_rootid";
			$child_rows = $db->getall($child_sql);
			foreach($child_rows as $s_key => $s_value)
			{
				if($s_as!="")
				{
					$s_sqlstr = $s_sqlstr." OR ".$s_as.".cid=".$s_value['cid']."";
				}
				else
				{
					$s_sqlstr = $s_sqlstr." OR cid=".$s_value['cid']."";
				}
				$s_sqlstr = $this->build_childsql($s_table,$s_as,$s_value['cid'],$s_sqlstr);
			}
		}
		return $s_sqlstr;
	}
	public function home(){
		global $db;
		$sql = 'SELECT `uploadfiles`,`url` FROM '.DB_PREFIX."adsfigure WHERE `flag`=1 AND `zoneid`=4 ORDER BY adsid ASC";
		$banner = $db->getall($sql);
		if(!empty($banner)){
			foreach($banner as $key=>$val){
				$banner[$key]['src'] = PHPOE_ROOT.$val['uploadfiles'];
				unset($banner[$key]['uploadfiles']);
			}
		}
		$banner_json = json_encode($banner);
		$data = array();
		$data['html'] = '<div class="slide"></div>'.'<script>$(".slide").slider({data : '.$banner_json.'});</script>';
		return $data['html'];
	}
	
	public function get_page($parm,&$parm2)
	{
		  global $db, $tpl;
		  $sql  = "SELECT * FROM ".DB_PREFIX."page WHERE `word`='{$parm}' LIMIT 1";
		  $page = $db->fetch_first($sql);
		  $parm2=$page['content'];
		  $sql  = "SELECT * FROM ".DB_PREFIX."page WHERE `cid`='{$page['cid']}' ORDER BY orders ASC";
		  $result=$db->getall($sql);
		  
		 for($i=0;$i<count($result);$i++)
	     {
			 $result[$i]['word']=M_PATH_URL.'about_mobile/'.$result[$i]['word'].'.html';
		 }
		 return $result;
	}
	public function pagecate_child($title,&$par_title){
		global $db, $tpl;
		$sql = "SELECT `cid`,`cname` FROM ".DB_PREFIX."pagecate WHERE `catdir`='{$title}'";
		$cid_result = $db->fetch_first($sql);
		if(empty($cid_result)){
			$sql = "SELECT `id`,`title` FROM ".DB_PREFIX."page where word='{$title}'";
			$cid_result = $db->fetch_first($sql);
			$parentid = $cid_result['id'];
			$par_title = $cid_result['title'];
			$sql = "SELECT * FROM ".DB_PREFIX."page where `parentid`={$parentid} and `flag`=1 ORDER BY orders ASC";
			$result = $db->getall($sql);
		}else{
			$cid = $cid_result['cid'];
			$par_title = $cid_result['cname'];
			$sql = "SELECT * FROM ".DB_PREFIX."page WHERE `cid`='{$cid}' and `flag`=1 and `depth`=1 ORDER BY orders ASC";
			$result = $db->getall($sql);
		}
		foreach ($result as $key => $value) {
			if($value['linktype'] == 2 && $value['linkurl'] != ''){
				$result[$key]['url'] = $value['linkurl'];
			}else{
				$sql_chil    = "SELECT * FROM ".DB_PREFIX."page where flag=1 and parentid=".$value['id']." ORDER BY orders ASC";
				$result_chil = $db->getall($sql_chil);
				if(!empty($result_chil)){
					$result[$key]['url'] = M_PATH_URL.'about_'.$value['word'].'/';
				}else{
					$result[$key]['url'] = M_PATH_URL.'about_'.$title.'/'.$result[$key]['word'].'.html';
				}	
			}
		}
		// print_r($result);exit;
		return $result;
	}
	public function page_detail($word){
		global $db, $tpl;
		$sql = "SELECT * FROM ".DB_PREFIX."page WHERE `word`='{$word}'";
		$result = $db->fetch_first($sql);
		return $result;
	}
	public function pagecate(){
		global $db, $tpl;
		$sql = "SELECT * FROM ".DB_PREFIX."pagecate WHERE `flag`=1 order by orders ASC ";
		$cate = $db->getall($sql);
		foreach ($cate as $key => &$val) {
			$val['url'] = M_PATH_URL.'about_'.$val['catdir'].'/';
		}
		return $cate;
	}
	
	
	public function news_list($parm1,&$var)
	{
		 global $db, $tpl;
		 $sql  = "SELECT * FROM ".DB_PREFIX."infocate WHERE `word`='{$parm1}'";
		 $news = $db->fetch_first($sql);
		 $var =$news['cname'];
		 
		 $cid = $news['cid'];
		 
		if($cid)
		{
			$childsql = $this->build_childsql("infocate", "v", intval($cid), "");
			$where = " AND (v.cid='".$cid."'".$childsql.")";
		}
		$sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."info AS v WHERE `flag` = 1 " . $where .
		"ORDER BY id DESC {$limit}";
		$news = $db->getall($sql);
		for($i=0;$i<count($news);$i++)
	    {
			$news[$i]['url']=M_PATH_URL.'news/'.$news[$i]['id'].'.html';
		}
		return $news;
	}
	
	public function news_sort($word = '')
	{
		global $db;
		//判断$word是否为空，为空的话调取一级分类，不为空，如果有子级显示子级，没有的话显示相应的列表页
		if(empty($word)){
			$sql = 'SELECT * FROM '.DB_PREFIX."infocate WHERE `parentid`=0 and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			for($i=0;$i<count($cate);$i++)
			{
				$sql = "SELECT * FROM ".DB_PREFIX."infocate where `parentid`='".$cate[$i]['cid']."' and `flag`=1 ORDER BY orders";
				$result = $db->getall($sql);
				if(empty($result)){
					$cate[$i]['word']=M_PATH_URL.'news/'.$cate[$i]['word'].'/';
				}else{
					$cate[$i]['word']=M_PATH_URL.'news_'.$cate[$i]['word'].'/';
				}

			}

		}else{
			$sql  = "SELECT * FROM ".DB_PREFIX."infocate where `word`='".$word."' and `flag`=1";
			$result = $db->fetch_first($sql);
			$cid  = $result['cid'];
			$sql  = "SELECT * FROM ".DB_PREFIX."infocate where `parentid`=".$cid." and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			foreach ($cate as $key => &$val) {
				//判断二级是否有子集，有就显示新闻三级，没有就显示列表页
				$sql_chil = "SELECT * FROM ".DB_PREFIX."infocate where `parentid`=".$val['cid']." and `flag`=1";
				$result_chil = $db->getall($sql_chil);
				if(empty($result_chil)){
					$val['word'] = M_PATH_URL.'news/'.$val['word'].'/';
				}else{
					$val['word'] = M_PATH_URL.'news_'.$val['word'].'/';
				}
			}
		}
		return $cate;
	}
	
	//新闻列表
	public function news(){
		global $db;
		$cid = isset($_GET['id']) && $_GET['id'] ? intval($_GET['id']) : '';
		$pageIndex = isset($_GET['pageIndex']) && $_GET['pageIndex'] ? intval($_GET['pageIndex']) : 1;
		$limit = "LIMIT ".($pageIndex-1)*6 . ", 6";
		$where = '';
		if($cid){
			$where = "AND `cid`='{$cid}' ";
		}
		$sql = 'SELECT `id`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."info WHERE `flag` = 1 " . $where .
		"ORDER BY id DESC {$limit}";
		$news = $db->getall($sql);
		$html = '';
		$data = array();
		if(!empty($news)){
			foreach($news as $key=>$val){
				$html .= "<li><a data-type='news_detail' data-id='{$val['id']}'>{$val['title']}</a></li>";
			}
		}
		if($pageIndex == 1){
			$html = '<ul class="list news_list clearfix">'. $html . '</ul>'.
					'<a id="pullUp">点击查看更多</a>';
			if($cid){
				$total	= $db->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."info WHERE `cid`='{$cid}'");
			}else{
				$total	= $db->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."info");
			}
			$data['total'] = $total;
		}
		$data['html'] = $html;
		if(!$cid){
			$data['cate'] = $this->news_cate();
		}
		return $data;
	}
	
	//新闻详细
	public function news_detail($id){
		global $db;
		$sql  = 'SELECT * FROM '.DB_PREFIX."info WHERE `id`='{$id}' LIMIT 1";
		$news = $db->fetch_first($sql);
		return $news;	
	}
	//新闻分类
	public function news_cate(){
		global $db, $tpl;
		$sql = 'SELECT * FROM '.DB_PREFIX."infocate";
		$cate = $db->getall($sql);
		$html = '<select id="cate_select">';
		$cid = isset($_GET['cid']) ? intval($_GET['cid']) : '';
		if(!empty($cate)){
			foreach($cate as $key=>$val){
				$url = "news/{$val['cid']}/";
				$selected = '';
				if($cid == $val['cid']){
					$selected = ' selected="selected"';
				}
				$html .= "<option value='{$val['cid']}'{$selected}>{$val['cname']}</option>";
			}
		}
		$html .= '</select>';
		return $html;
	}
	//产品列表
	
	public function get_index_product()
	{
		global $db;
	    $sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."product WHERE `flag` = 1 AND elite = 1 " .
		"ORDER BY orders DESC {$limit}";
		$product = $db->getall($sql);
		if(empty($product)){
			$sqlnew = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."product WHERE `flag` = 1 " .
			"ORDER BY orders DESC {$limit}";
			$product = $db->getall($sqlnew);
		}
		for($i=0;$i<count($product);$i++)
		{
		   $product[$i]['thumbfiles']=PATH_URL.$product[$i]['thumbfiles'];
		   $product[$i]['url']='./product/'.$product[$i]['id'].'.html';
		}
		if(count($product) <= 6)
		{
			return $product;
		}
		return array_slice($product,0,6,true);
	}
	
	public function news_index(){
		 global $db;
		 $sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."info AS v WHERE `flag` = 1 AND elite = 1 " .
		"ORDER BY id DESC {$limit}";
		$news = $db->getall($sql);
		if(empty($news)){
			$sqlnew='SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."info AS v WHERE `flag` = 1 " .
		    "ORDER BY id DESC {$limit}";
		    $news = $db->getall($sqlnew);
		}
		for($i=0;$i<count($news);$i++)
	    {
			$news[$i]['url']=M_PATH_URL.'news/'.$news[$i]['id'].'.html';
		}
		return array_slice($news,0,6,true);
	}
	
	public function product(){
		global $db;
		$cid = isset($_GET['id']) && $_GET['id'] ? intval($_GET['id']) : '';
		$pageIndex = isset($_GET['pageIndex']) && $_GET['pageIndex'] ? $_GET['pageIndex'] : 1;;
		$limit = "LIMIT ".($pageIndex-1)*6 . ", 6";
		$where = '';
		if($cid){
			$where = "AND `cid`='{$cid}' ";
		}
		$sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."product WHERE `flag` = 1 " . $where .
		"ORDER BY orders DESC {$limit}";
		$product = $db->getall($sql);
		$html = '';
		$data = array();		
		if(!empty($product)){
			foreach($product as $key=>$val){
				$html .= "<li><a data-type='product_detail' data-id='{$val['id']}'><img class='lazy-load' src='".PATH_URL.'m/template/images/replace.png'."' lazy_src='".PATH_URL.$val['thumbfiles']."' /><span>".Core_Fun::cut_str($val['title'],7)."</span></a></li>";
			}
		}
		if($pageIndex == 1){
			$html = '<ul class="list product_list clearfix">'. $html . '</ul>'.
			'<div id="pullUp">点击查看更多</div>';
			if($cid){
				$total	= $db->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."product WHERE `cid`='{$cid}'");
			}else{
				$total	= $db->fetch_count('SELECT COUNT(*) FROM '.DB_PREFIX."product");
			}
			$data['total'] = $total;
		}
		$data['html'] = $html;
		$data['cate'] = $this->product_cate($cid);
		return $data;
	}
	//产品分类
	public function product_cate($word = '')
	{
		global $db;
		//判断$word是否为空，为空的话调取一级分类，不为空，如果有子级显示子级，没有的话显示相应的列表页
		if(empty($word)){
			$sql = 'SELECT * FROM '.DB_PREFIX."productcate WHERE `parentid`=0 and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			for($i=0;$i<count($cate);$i++)
			{
				if($cate[$i]['linktype'] == 2 && $cate[$i]['linkurl'] != ''){
					$cate[$i]['word'] = $cate[$i]['linkurl'];
				}else{
					$sql = "SELECT * FROM ".DB_PREFIX."productcate where `parentid`='".$cate[$i]['cid']."' and `flag`=1 ORDER BY orders";
					$result = $db->getall($sql);
					if(empty($result)){
						$cate[$i]['word'] = M_PATH_URL.'product/'.$cate[$i]['word'].'/';
					}else{
						$cate[$i]['word'] = M_PATH_URL.'product_'.$cate[$i]['word'].'/';
					}	
				}	
			}
		}else{
			$sql = "SELECT * FROM ".DB_PREFIX."productcate where `word`='".$word."' and `flag`=1";
			$result = $db->fetch_first($sql);
			$cid = $result['cid'];
			$sql = "SELECT * FROM ".DB_PREFIX."productcate where `parentid`=".$cid." and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			foreach ($cate as $key => &$val) {
				if($val['linktype'] == 2 && $val['linkurl'] != ''){
					$val['word'] = $val['linkurl'];
				}else{
					//判断二级是否有子集，有就显示产品三级，没有就显示列表页
					$sql_chil = "SELECT * FROM ".DB_PREFIX."productcate where `parentid`=".$val['cid']." and `flag`=1";
					$result_chil = $db->getall($sql_chil);
					if(empty($result_chil)){
						$val['word'] = M_PATH_URL.'product/'.$val['word'].'/';
					}else{
						$val['word'] = M_PATH_URL.'product_'.$val['word'].'/';
					}
				}
			}
		}
		return $cate;
	}

	//案例分类
	public function case_cate($word = ''){
		global $db;
		//判断$word是否为空，为空的话调取一级分类，不为空，如果有子级显示子级，没有的话显示相应的列表页
		if(empty($word)){
			$sql = 'SELECT * FROM '.DB_PREFIX."casecate WHERE `parentid`=0 and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			for($i=0;$i<count($cate);$i++)
			{
				if($cate[$i]['linktype'] == 2 && $cate[$i]['linkurl'] != ''){
					$cate[$i]['word'] = $cate[$i]['linkurl'];
				}else{
					$sql = "SELECT * FROM ".DB_PREFIX."casecate where `parentid`='".$cate[$i]['cid']."' and `flag`=1 ORDER BY orders";
					$result = $db->getall($sql);
					if(empty($result)){
						$cate[$i]['word']=M_PATH_URL.'case/'.$cate[$i]['word'].'/';
					}else{
						$cate[$i]['word']=M_PATH_URL.'case_'.$cate[$i]['word'].'/';
					}
				}
			}

		}else{
			// echo $word;exit;
			$sql = "SELECT * FROM ".DB_PREFIX."casecate where `word`='".$word."' and `flag`=1";
			$result = $db->fetch_first($sql);
			$cid = $result['cid'];
			$sql = "SELECT * FROM ".DB_PREFIX."casecate where `parentid`=".$cid." and `flag`=1 ORDER BY orders";
			$cate = $db->getall($sql);
			foreach ($cate as $key => &$val) {
				if($val['linktype'] == 2 && $val['linkurl'] != ''){
					$val['word'] = $val['linkurl'];
				}else{
					//判断二级是否有子集，有就显示产品三级，没有就显示列表页
					$sql_chil = "SELECT * FROM ".DB_PREFIX."casecate where `parentid`=".$val['cid']." and `flag`=1";
					$result_chil = $db->getall($sql_chil);
					if(empty($result_chil)){
						$val['word'] = M_PATH_URL.'case/'.$val['word'].'/';
					}else{
						$val['word'] = M_PATH_URL.'case_'.$val['word'].'/';
					}	
				}
			}
		}
		// var_dump($cate);
		return $cate;
	}

	//产品详细
	public function product_detail($id){
		global $db;
		$sql  = 'SELECT * FROM '.DB_PREFIX."product WHERE `id`='{$id}' LIMIT 1";
		$product = $db->fetch_first($sql);
		$product['uploadfiles'] = PATH_URL.$product['uploadfiles'];
		$arrimgs = explode('#', $product['img_input']);
		foreach($arrimgs as $key=>&$value){
			$value = PATH_URL.'data/images/product/'.$value;
		}
		$product['imgs'] = $arrimgs;
		return $product;
	}

	//案例详细
	public function case_detail($id)
	{
		global $db;
		$sql  = 'SELECT * FROM '.DB_PREFIX."case WHERE `id`='{$id}' LIMIT 1";
		$case = $db->fetch_first($sql);
		$case['uploadfiles']=PATH_URL.$case['uploadfiles'];
		return $case;
	}
	
	public function get_sort_list($aa)
	{
		global $db;
		$flag=0;
		$arrays=array();
		$sql  = 'SELECT * FROM '.DB_PREFIX."productcate WHERE `word`='{$aa}' LIMIT 1";  //一级列表
		$pro = $db->fetch_first($sql);
		$cid = $pro['cid'];
		if($cid)
		{   
			$childsql = $this->build_childsql("productcate", "v", intval($cid), "");
			$where = " AND (v.cid='".$cid."'".$childsql.")";
		}
		$sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."product AS v WHERE `flag` = 1 " . $where .
		"ORDER BY orders DESC {$limit}";
		$products = $db->getall($sql);
		
		for($i=0;$i<count($products);$i++)
		{
			$products[$i]['thumbfiles']=PATH_URL.$products[$i]['thumbfiles'];
			$products[$i]['url']=M_PATH_URL.'product/'.$products[$i]['id'].'.html';
		}
		
		return $products;
	}

    //案例分类列表页
	public function case_sort_list($aa)
	{
		global $db;
		$flag=0;
		$arrays=array();
		$sql  = 'SELECT * FROM '.DB_PREFIX."casecate WHERE `word`='{$aa}' LIMIT 1";  //一级列表
		$pro = $db->fetch_first($sql);
		$cid = $pro['cid'];
		if($cid)
		{   
			$childsql = $this->build_childsql("casecate", "v", intval($cid), "");
			$where = " AND (v.cid='".$cid."'".$childsql.")";
		}
		$sql = 'SELECT `id`,`thumbfiles`,`title`,`content`,`timeline`,`flag` FROM '.DB_PREFIX."case AS v WHERE `flag` = 1 " . $where .
		"ORDER BY orders DESC {$limit}";
		$cases = $db->getall($sql);
		
		for($i=0;$i<count($cases);$i++)
		{
			$cases[$i]['thumbfiles']=PATH_URL.$cases[$i]['thumbfiles'];
			$cases[$i]['url']=M_PATH_URL.'case/'.$cases[$i]['id'].'.html';
		}
		
		return $cases;
	}


	//招聘
	public function job_cate()
	{
		global $db;
		$sql = 'SELECT * FROM '.DB_PREFIX."jobcate WHERE `parentid`=0 and `flag`=1 ORDER BY orders ASC";
		$cate = $db->getall($sql);
		for($i=0;$i<count($cate);$i++){
		   if($cate[$i]['linktype'] == 2 && $cate[$i]['linkurl'] != ''){
				$cate[$i]['url'] = $cate[$i]['linkurl'];
			}else{
					$cate[$i]['url'] = M_PATH_URL.'job/'.$cate[$i]['cid'].'/';
			}	
		}
		return $cate;
	}

	public function job_sort_list($aa)
	{
		global $db;
		$sql = 'SELECT `id`,`uploadfiles`,`title`,`number`,`jobdescription`,`jobrequest`,`jobotherrequest`,`jobcontact`,`timeline`,`flag` FROM '.DB_PREFIX."job AS v WHERE `flag` = 1 and `cid`='{$aa}'  ORDER BY id DESC {$limit}";
		$jobs = $db->getall($sql);
		for($i=0;$i<count($jobs);$i++)
		{
			$jobs[$i]['uploadfiles']=PATH_URL.$jobs[$i]['uploadfiles'];
			$jobs[$i]['url']=M_PATH_URL.'job/'.$jobs[$i]['id'].'.html';
		}
		
		return $jobs;
	}

	public function job_detail($id)
	{
		global $db;
		$sql  = 'SELECT * FROM '.DB_PREFIX."job WHERE `id`='{$id}' LIMIT 1";
		$job = $db->fetch_first($sql);
		$job['thumbfiles']=PATH_URL.$job['thumbfiles'];
		return $job;
	}

	public function job_name($aa)
	{
		global $db;
		$flag=0;
		$arrays=array();
		$sql  = 'SELECT * FROM '.DB_PREFIX."jobcate WHERE `cid`='{$aa}' LIMIT 1";
		$pro = $db->fetch_first($sql);
		return $pro['cname'];
	}

	public function shang_job()
	{
		global $db;
		$id   = intval($_GET['id']);
		$sql  = 'SELECT * FROM '.DB_PREFIX."job WHERE `id`='{$id}' LIMIT 1";
		$job = $db->fetch_first($sql);
		$data = array();
		$html = '';
		if($job){
			$html .= "<div class='pn'>".$this->prev('job', $job['cid'], $id).$this->next('job', $job['cid'], $id);
		}
		$data['html'] = $html.'</div>';
		// print_r($data['html']);die();
		return $data['html'];
	}
	
	
	public function get_name($aa)
	{
		global $db;
		$flag=0;
		$arrays=array();
		$sql  = 'SELECT * FROM '.DB_PREFIX."productcate WHERE `word`='{$aa}' LIMIT 1";
		$pro = $db->fetch_first($sql);
		return $pro['cname'];
	}

	public function case_name($aa)
	{
		global $db;
		$flag=0;
		$arrays=array();
		$sql  = 'SELECT * FROM '.DB_PREFIX."casecate WHERE `word`='{$aa}' LIMIT 1";
		$pro = $db->fetch_first($sql);
		return $pro['cname'];
	}
	
	public function shang_pro()
	{
		global $db;
		$id   = intval($_GET['id']);
		$sql  = 'SELECT * FROM '.DB_PREFIX."product WHERE `id`='{$id}' LIMIT 1";
		$product = $db->fetch_first($sql);
		$data = array();
		$html = '';
		if($product){
			$html .= "<div class='pn'>".$this->prev('product', $product['cid'], $id).$this->next('product', $product['cid'], $id).'</div>';
		}
		$data['html'] = $html.'</div>';
		return $data['html'];
	}

    //案例上一篇
	public function shang_case()
	{
		global $db;
		$id   = intval($_GET['id']);
		$sql  = 'SELECT * FROM '.DB_PREFIX."case WHERE `id`='{$id}' LIMIT 1";
		$case = $db->fetch_first($sql);
		$data = array();
		$html = '';
		if($case){
			$html .= "<div class='pn'>".$this->prev('case', $case['cid'], $id).$this->next('case', $case['cid'], $id);
		}
		$data['html'] = $html.'</div>';
		// print_r($data['html']);die();
		return $data['html'];
	}
	
	
	public function shang_news()
	{
		global $db;
		$id   = intval($_GET['id']);
		$sql  = 'SELECT * FROM '.DB_PREFIX."info WHERE `id`='{$id}' LIMIT 1";
		$news = $db->fetch_first($sql);
		$data = array();
		$html = '';
		if($news){ 
			$html .= "<div class='pn'>".$this->prev('info', $news['cid'], $id).$this->next('news', $news['cid'], $id).'</div>';
		}
		$data['html'] = $html.'</div>';
		return $data['html'];
	}
	
	 
	private function prev($type , $cid , $id){
		global $db;
		$table = ($type == 'news') ? 'info' : $type;
		$where = '';
		 
		$where .= "id > '{$id}' ORDER BY id ASC LIMIT 1";
		 
		$sql = 'SELECT id,cid,title FROM '.DB_PREFIX."{$table} WHERE {$where}";
		$data = $db->fetch_first($sql);
		if($data){
			$data['title']=$this->get_word($data['title'],30);
			$html = "上一篇：<a href=./{$data['id']}.html>{$data['title']}</a><br />";
		}else{
			$html = "上一篇：<span>没有了</span><br />";
		}
		return $html;
	}
	
	 
	private function next($type, $cid, $id){
		global $db;
		$table = $type == 'news' ? 'info' : $type;
		$where = '';
		 
		$where .= "id < '{$id}' ORDER BY id DESC LIMIT 1";
		$sql = 'SELECT id,cid,title FROM '.DB_PREFIX."{$table} WHERE {$where}";
		 
		$data = $db->fetch_first($sql);
		if($data){
			$data['title']=$this->get_word($data['title'],30);
			$html = "下一篇：<a href=./{$data['id']}.html>{$data['title']}</a>";
		}else{
			$html = "下一篇：<span>没有了</span>";
		}
		return $html;	
	}	
	
	
	//关于我们
	public function page(){
		global $db;
		$id = isset($_GET['id']) && $_GET['id'] ? intval($_GET['id']) : '';
		if(! $id){
			$sql = 'SELECT a.* FROM '.DB_PREFIX."page AS a LEFT JOIN " . DB_PREFIX."pagecate AS b ON a.cid = b.cid WHERE b.`catdir`='mobile' ORDER BY a.`orders` ASC LIMIT 1";
		}else{
			$sql	= "SELECT a.*,b.cname,b.catdir FROM ".DB_PREFIX."page AS a LEFT JOIN ".DB_PREFIX."pagecate as b ON a.cid=b.cid WHERE a.flag=1 AND a.id='".$id."' LIMIT 1";
		}
		$page = $db->fetch_first($sql);
		$data['html'] = $page['content'];
		$data['cate'] = $this->page_cate($id);
		return $data;
	}
	
	//关于我们分类
	public function page_cate($id = ''){
		require CHENCY_ROOT.'source/module/mod.page.php';
		$cate = Mod_Page::volist("AND `catdir`='mobile'",'ORDER BY c.cid,v.orders');
		$html = '<select id="cate_select">';
		if(!empty($cate)){
			foreach($cate as $key=>$val){
				$selected = '';
				if($id == $val['id']){
					$selected = ' selected="selected"';
				}
				$html .= "<option value='{$val['id']}'{$selected}>{$val['title']}</option>";
			}
			$html .= '</option>';
		}
		return $html;
	}
	
	//在线留言
	public function message(){
		ob_start();
		$this->load_template('message');
		$data = array();
		$data['html'] = ob_get_clean();
		return $data;
	}
	
	//
	private function load_template($file_name){
		$file = M_TEMPLATE.$file_name.'.php';
		if(is_file($file)){
			require $file;
		}else{
			exit('file is not exists');
		}
	}
	
	private function get_word($string, $length, $dot = '...',$charset='utf-8') { 
		if(strlen($string) <= $length) { 
		return $string; 
		} 
		$string = str_replace(array('　',' ', '&', '"', '<', '>'), array('','','&', '"', '<', '>'), $string); 
		$strcut = ''; 
		if(strtolower($charset) == 'utf-8') { 
		$n = $tn = $noc = 0; 
		while($n < strlen($string)) { 
		$t = ord($string[$n]); 
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) { 
		$tn = 1; $n++; $noc++; 
		} elseif(194 <= $t && $t <= 223) { 
		$tn = 2; $n += 2; $noc += 2; 
		} elseif(224 <= $t && $t < 239) { 
		$tn = 3; $n += 3; $noc += 2; 
		} elseif(240 <= $t && $t <= 247) { 
		$tn = 4; $n += 4; $noc += 2; 
		} elseif(248 <= $t && $t <= 251) { 
		$tn = 5; $n += 5; $noc += 2; 
		} elseif($t == 252 || $t == 253) { 
		$tn = 6; $n += 6; $noc += 2; 
		} else { 
		$n++; 
		} 
		if($noc >= $length) { 
		break; 
		} 
		} 
		if($noc > $length) { 
		$n -= $tn; 
		} 
		$strcut = substr($string, 0, $n); 
		} else { 
		for($i = 0; $i < $length; $i++) { 
		$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i]; 
		} 
		} 
		return $strcut.$dot; 
		} 
	
}