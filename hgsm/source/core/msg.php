<?php
class msg{
	//弹出消息
	public static function alert($message = ''){
		header("Content-type:text/html;charset=utf-8");
		echo '<script language=javascript>';
		echo 'alert("'.$message.'");';
		echo '</script>';
		exit;
	}
	
	//弹出消息后，返回之前页面或跳转到指定网页	
	public static function msge($message,$url='')
	{
		header("Content-type:text/html;charset=utf-8");
		echo '<script language=javascript>';
		echo 'alert("'.$message.'");';
		if(!empty($url)){
		    echo 'location="'.$url.'";';
		}else{
			echo 'history.go(-1);';
		}
        echo '</script>';
        exit;
	}

	//登陆失败提示框	
	public static function msgerror($url='')
	{
		header("Content-type:text/html;charset=utf-8");
		echo '<script language=javascript>';
		if(!empty($url)){
    		echo 'window.location="'.$url.'";';
    	}else{
    		echo 'history.go(-1);';
    	}
		// echo '$(".login-error").fadeIn(300).delay(2000).fadeOut(500);';
        echo '</script>';
        exit;
	}

    //弹出框信息
    public static function masge($message,$url='')
    {
    	header("Content-type:text/html;charset=utf-8");
    	echo '<script language=javascript>';
    	echo 'alert("'.$message.'");';
    	if(!empty($url)){
    		echo 'window.location="'.$url.'";';
    	}else{
    		echo 'history.go(-1);';
    	}
    	echo '</script>';
    	exit;
    }

	public static function msgeHome($message,$url){
		header("Content-type:text/html;charset=utf-8");
		echo '<script language=javascript>';
		echo 'alert("'.$message.'");';
		echo 'top.location="'.PHPOE_ROOT.'dm/'.$url.'";';
		echo '</script>';
		exit;
	}
	
	//延迟指定秒数后跳转到指定网页
	public static function goto_url($time,$url)
	{
		header("Content-type:text/html;charset=utf-8");
		echo '<meta http-equiv="Refresh" content='.$time.';URL='.$url.'>';
		exit;
	}
}
/* End of file msg.php */