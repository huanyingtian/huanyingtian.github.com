<?php
/**
 * @CopyRight  (C)2000-2012 XiangYun Development team Inc.
 * @WebSite    www.cn86.cn
 * @Author     XiangYun
 * @Brief      XiangYun v1.0
 * @Update     2012.07.07
**/
if(!defined('IN_PHPOE')) {
	exit('Access Denied');
}
class Core_Page{
	public static $config = array();
	/**
		分页函数，使用样式表显示 第一页 [1][2][3]...[4] 最后一页 后台中心使用
		@param $num     -- 总数
		@param $perpage -- 每页显示数量
		@param $curpage -- 当前页
		@param $mpurl   -- URL地址
		@param $maxpage -- 最大页
	*/
	public static function adminpage($num,$perpage,$curr_page,$mpurl,$maxpage){
		$var = $GLOBALS['LANVAR'];
		$multipage ='';
		$pages = '';
		$tabdiv = '';
		$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
		if($num>$perpage){
			$page    = $maxpage;
			$offset  = floor($page * 0.5);
			$pages   = ceil($num/$perpage);
			$from    = $curr_page -$offset;
			$to      = $curr_page + $page - $offset - 1;
			if($page > $pages){
				$from = 1;
				$to   = $pages;
			}else{
				if($from<1){
					$to   = $curr_page + 1 - $from;
					$from =1;
					if(($to - $from)<$page && ($to - $from) < $pages){
						$to = $page;
					}
				}elseif($to>$pages){
					$from = $curr_page - $pages + $to;
					$to   = $pages;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$from = $pages - $page + 1;
					}
				}
			}
			$multipage .="<td align='center' class='page_redirect' style='cursor:pointer' onmouseover=\"this.className='on_page_redirect';\" onmouseout=\"this.className='page_redirect';\" onclick=\"window.location.href='".$mpurl."page=1';\" title='".$var['home']."'><img src='xycms/images/page_home.gif'></td>";
			for($i=$from;$i<=$to;$i++){
				if($i!=$curr_page){
					$multipage.="<td align='center' class='page_number' style='cursor:pointer' onmouseover=\"this.className='on_page_number';\" onmouseout=\"this.className='page_number';\" onclick=\"window.location.href='".$mpurl."page=".$i."';\" title='".$var['the'].$i.$var['page']."'>".$i."</td>";
				}else{
					$multipage.="<td align='center' class='page_curpage' title='".$var['the'].$i.$var['page']."'>".$i."</td>";
				}
			}
			$multipage.=$pages > $page ? "<td align='center' class='page_redirect' style='cursor:pointer' onmouseover=\"this.className='on_page_redirect';\" onmouseout=\"this.className='page_redirect';\" onclick=\"window.location.href='".$mpurl."page=".$pages."';\" title='".$var['last']."'><img src='xycms/images/page_end.gif'></td>":"<td align='center' class='page_redirect' style='cursor:pointer' onmouseover=\"this.className='on_page_redirect';\" onmouseout=\"this.className='page_redirect';\" onclick=\"window.location.href='".$mpurl."page=".$pages."';\" title='".$var['last']."'><img src='xycms/images/page_end.gif'></td>";

			$multipage .="<td align='center'><input name='page' title='".$var['enter']."' type='text'  class='page_input' onkeypress=\"if(event.keyCode==13) window.location.href='".$mpurl."page='+value\" /></td>";
		}
		if(!$pages){
			$recordnav = "<td align='center' class='page_total' title='".$var['total_p'].$perpage.$var['a']."'>&nbsp;".$num."&nbsp;</td>";
		}else{
			$recordnav = "<td align='center' class='page_total' title='".$var['total_p'].$perpage.$var['a']."'>&nbsp;".$num."&nbsp;</td>";
			$recordnav.= "<td align='center' class='page_pages' title='".$var['current']."'>&nbsp;".$curr_page."/".$pages."&nbsp;</td>";
		}
		$tabdiv.= "  <div style='float:center;'>";
		$tabdiv.= "    <table border='0' cellpadding='0' cellspacing='1'>";
		$tabdiv.= "      <tr>";
		$tabdiv = $tabdiv.$recordnav;
		$tabdiv = $tabdiv.$multipage;
		$tabdiv.= "      </tr>";
		$tabdiv.= "    </table>";
		$tabdiv.= "  </div>";

		return $tabdiv;
	}

	/**
		分页函数，前台通用分页 上一页 [1][2][3][4] 下一页
		@param $channel -- 频道 格式 product,info
		@param $cid     -- 分类ID
		@param $num     -- 总数
		@param $perpage -- 每页显示数量pagesize
		@param $curpage -- 当前页
		@param $mpurl   -- URL地址
		@param $maxpage -- 最大页
		$showphpurl -- 是否强制显示PHP URL格式 1--Y,0--N

				product/page-1.html
				product/cat-1-1.html
				product-page-1.html
				product-cat-1-1.html

	*/
	public static function volistpage($channel,$word,$num,$perpage,$curr_page,$maxpage){
		self::$config = $GLOBALS['config'];
		$var = $GLOBALS['LANVAR'];
		$multipage = '';
		$tippage   = '';
		$homepage  = '';
		$word = $word ? $word : '';
		if(isset($word) && $word != ''){
			$word .= '/';
		}
		$pagepath = PATH_URL.$channel.'/';
		if($num>$perpage){
			$page    = $maxpage;
			$pages   = ceil($num/$perpage);
			$offset  = floor($page * 0.5);
			$from    = $curr_page -$offset;
			$to      = $curr_page + $page - $offset - 1;
			if($page > $pages){
				$from = 1;
				$to   = $pages;
			}else{
				if($from<1){
					$to   = $curr_page + 1 - $from;
					$from =1;
					if(($to - $from)<$page && ($to - $from) < $pages){
						$to = $page;
					}
				}elseif($to>$pages){
					$from = $curr_page - $pages + $to;
					$to   = $pages;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$from = $pages - $page + 1;
					}
				}
			}
			if($curr_page>1){
				$tippage  = '<a href="'.$pagepath.$word.'p'.($curr_page-1).'.html">'.$var['previous'].'</a>';		
				$homepage = '<a href="'.$pagepath.$word.'">'.$var['home'].'</a>';
			}
			for($i=$from;$i<=$to;$i++){
				if($i!=$curr_page){
				  $multipage .= '<a href="'.$pagepath.$word.'p'.$i.'.html">'.$i.'</a>';
				}else{
				  $multipage .= "<span id='current'>{$i}</span>";
				}
			}
			$tippage = $tippage.$multipage;

			if($pages>1 && $pages!=$curr_page){
			  $tippage .= '<a href="'.$pagepath.$word.'p'.($curr_page+1).'.html">'.$var['next'].'</a>';
			}
			if($pages != $maxpage){
			  $endpage = '<a href="'.$pagepath.$word.'p'.$pages.'.html">'.$var['last'].'</a>';
		}
           $select = array();  
           $str = '';
		   for($i=1;$i<=$pages;$i++){
           $select[$i] = $pagepath.$word.'p'.$i.'.html';          
			}
		   foreach($select as $key => $data){
		   	$selected = $key == $curr_page ? ' selected = "selected"': '';
              $str .= "<option value='{$data}'{$selected}>".$var['the']."{$key}".$var['page']."</option>";
			}
            $opt ='<select onChange="window.location=this.options[this.selectedIndex].value">'.$str.'</select>';
            $t1 = '<div class="t1"><span>'.$var['total'].$num.$var['article'].'</span>'.'<sapn>'.$var['per_page'].$perpage.$var['article'].'</sapn><span>'.$var['page_s'].$curr_page.'/'.$pages.'</span>'.'</div>';
            $tippage = '<div class="t2">'.$homepage.$tippage.$endpage.$opt.'<div style="clear:both;"></div>'.'</div>'.'<div style="clear:both;"></div>';
            $tippage = $t1.$tippage;
			return $tippage;
		}else{
			return "";
		}
	}
}
?>