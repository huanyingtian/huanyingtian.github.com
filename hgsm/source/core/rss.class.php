<?php
class rss
{
    protected $channel_title = ''; //RSS频道名
    protected $channel_link = '';  //RSS频道链接
    protected $channel_description = '';  //RSS频道描述
    protected $channel_imgurl = '';  //RSS频道使用的小图标的URL
    protected $language = 'zh_CN';  //RSS频道所使用的语言
    protected $pubDate = '';  //RSS文档创建日期，默认为今天
    protected $lastBuildDate = '';
    protected $generator = 'YBlog RSS Generator';
   //RSS息的数组
    protected $item1 = array();
    protected $item2 = array();
    /**
     * 构造函数
     * @access public
     * @param string $title  RSS频道名
     * @param string $link  RSS频道链接
     * @param string $description  RSS频道描述
     * @param string $imgurl  RSS频道图标
     */
    public function __construct($summary, $product, $info, $imgurl = '')
    {
        $this->channel_title = $summary['title'];
        $this->channel_link = $summary['link'];
        $this->channel_description = $summary['description'];
        $this->pubDate = Date('Y-m-d H:i:s', time());
        $this->lastBuildDate = Date('Y-m-d H:i:s', time());
        $this->item1 = $product;
        $this->item2 = $info;
    }
    /**
     * 设置私有变量
     * @access public
     * @param string $key  变量名
     * @param string $value  变量的值
     */
    /**
     * 添加RSS项
     * @access public
     * @param string $title  日志的标题
     * @param string $link  日志的链接
     * @param string $description  日志的摘要
     * @param string $pubDate  日志的发布日期
     */
     /**
     * 输出RSS的XML为字符串
     * @access public
     * @return string
     */
    public function Fetch()
    {
        $rss = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
        $rss .= "<rss version=\"2.0\">\r\n";
        $rss .= "<channel>\r\n";
        $rss .= "<title><![CDATA[{$this->channel_title}]]></title>\r\n";
        $rss .= "<category><![CDATA[{$this->channel_title}]]></category>\r\n";
        $rss .= "<description><![CDATA[{$this->channel_description}]]></description>\r\n";
        $rss .= "<link><![CDATA[{$this->channel_link}]]></link>\r\n";
        $rss .= "<language>{$this->language}</language>\r\n";

        if (!empty($this->pubDate))
            $rss .= "<pubDate>{$this->pubDate}</pubDate>\r\n";
        if (!empty($this->lastBuildDate))
            $rss .= "<lastBuildDate>{$this->lastBuildDate}</lastBuildDate>\r\n";
        if (!empty($this->generator))
            $rss .= "<generator>{$this->generator}</generator>\r\n";
        $rss .= "<ttl>5</ttl>\r\n";

        //输出产品信息
          foreach($this->item1 as $key=>$value){
          	$value['timeline'] = date('Y-m-d',$value['timeline']);
          	//$value['content']  = strip_tags($value['content']);
            $rss .= "<item>\r\n";
            $rss .= "<title><![CDATA[{$value['name']}]]></title>\r\n";
            $rss .= "<description><![CDATA[{$value['intro']}]]></description>\r\n";
            $rss .= "<link><![CDATA[{$value['url']}]]></link>\r\n";
            $rss .= "<author><![CDATA[{$this->channel_title}]]></author>";
            $rss .= "<pubDate><![CDATA[{$value['timeline']}]]></pubDate>\r\n";
            $rss .= "<category><![CDATA[{$value['catename']}]]></category>\r\n";
            $rss .= "</item>\r\n";
        }
        //输出新闻信息
          foreach($this->item2 as $key=>$value){
          	$value['timeline'] = date('Y-m-d',$value['timeline']);
          	//$value['content']  = strip_tags($value['content']);
            $rss .= "<item>\r\n";
            $rss .= "<title><![CDATA[{$value['name']}]]></title>\r\n";
            $rss .= "<description><![CDATA[{$value['summary']}]]></description>\r\n";
            $rss .= "<link><![CDATA[{$value['url']}]]></link>\r\n";
            $rss .= "<author><![CDATA[{$this->channel_title}]]></author>";
            $rss .= "<pubDate><![CDATA[{$value['timeline']}]]></pubDate>\r\n";
            $rss .= "<category><![CDATA[{$value['catename']}]]></category>\r\n";
            $rss .= "</item>\r\n";
        }
        $rss .= "</channel>\r\n</rss>";
        return $rss;
    }
    /**
     * 输出RSS的XML到浏览器
     * @access public
     * @return void
     */
    public function Display()
    {
       // header("Content-Type: text/xml; charset=utf-8");
        $fileName = "rss.xml";
        $rss_content = $this->Fetch();
        if(!@touch($fileName)){
        	echo "创建xml文件失败";
        	exit;
        }
        $handle = fopen($fileName, "wb+");
       // flock($handle, LOCK_EX);
        if(! @fwrite($handle, $rss_content)){
           echo "xml文件写入失败！";
           exit;
        };
        fclose($handle);
        $cp= copy("rss.xml","../rss.xml");
        if($cp){
        	echo "<script>"."alert('生成RSS成功');"."</script>";
            echo("<meta http-equiv=\"refresh\" content=\"0;url="."xycms_tag.php"."\">");
        }
        exit;
    }
}
?>