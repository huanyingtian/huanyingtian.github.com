<?php
class sms{
  private   $enCode    = "C50225";
  private   $enPass    = "4041hM";
  protected $url    = "http://www3.mob800.com/interface/Send.aspx";
	protected $msg    = "";
	protected $mobile = "";	
	public function __construct($mobile1, $msg1){
      $this->mobile = $mobile1;
      $this->msg    = iconv("utf-8", "gb2312//IGNORE", '【祥云平台】'.$msg1 );
	}
	public function send(){
      $data = array(
        "enCode" => $this->enCode,
        "enPass" => $this->enPass,
      	'userName' => 'sys',
      	'mob' => $this->mobile,
        "msg" => $this->msg,
         );
     $this->Get($this->url, $data);
  }
  
  public function Get($url, $data) {
  	$ch = curl_init();
  	$timeout = 5;
  	curl_setopt ($ch, CURLOPT_URL, $url);
  	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  	$file_contents = curl_exec($ch);
  	curl_close($ch);
  	return $file_contents;
  }  
  
  public function curl_data($url, $post_data = array(), $timeout = 5){
  	$curl = curl_init();
  	curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);		 //超时处理
  	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
  	curl_setopt($curl, CURLOPT_URL, $url);
  	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($curl, CURLOPT_POST, 1);				 //post提交方式
  	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
  	$data 	  = curl_exec($curl);   					 //结果
  	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // 返回http状态
  	$errno    = curl_errno($curl);   					 //返回错误状态码
  	$result   = array(
  		'httpCode' => $httpCode,
  		'errno' => $errno,
  		'data' => $data
  	);
  	curl_close($curl);
  	return $result;
  }
  
  
  

  
}