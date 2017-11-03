<?php
	class Image {
		private $path;
		//构造方法用来对图片所在位置进行初使化
		function __construct($path="./"){
			$this->path=rtrim($path, "/")."/";
		}
		/* 对图片进行缩放
		 *
		 * 参数$name: 是需要处理的图片名称
		 * 参数$width:是缩放后的宽度
		 * 参数$height:是缩放后的高度
		 * 参数$qz: 是新图片的名称前缀
		 * 返回值:就是缩放后的图片名称，失败则返回false
		 *
		 */
		function thumb($name, $width, $height, $qz="thumb_"){
			//获取图片信息
			$imgInfo=$this->getInfo($name); //图片的宽度，高度，类型
			//获取图片资源, 各种类型的图片都可以创建资源 jpg, gif, png
			$srcImg=$this->getImg($name, $imgInfo);
			//获取计算图片等比例之后的大小, $size["width"], $size["height"]
			$size=$this->getNewSize($name, $width, $height, $imgInfo);
			//获取新的图片资源, 处理一下gif透明背景
			$newImg=$this->kidOfImage($srcImg, $size, $imgInfo);
			//另存为一个新的图片，返回新的缩放后的图片名称	
			return $this->createNewImage($newImg, $qz.$name, $imgInfo);	
		}

		private function createNewImage($newImg, $newName, $imgInfo){
			switch($imgInfo["type"]){
				case 1://gif
					$result=imagegif($newImg, $this->path.$newName);
					break;
				case 2://jpg
					$result=imagejpeg($newImg, $this->path.$newName,100);
					break;
				case 3://png
					$return=imagepng($newImg, $this->path.$newName);
					break;
			}
			imagedestroy($newImg);
			return $newName;
		}

		private function kidOfImage($srcImg, $size, $imgInfo){
			$newImg=imagecreatetruecolor($size["width"], $size["height"]);
			$color = imagecolorallocatealpha($srcImg,255,255,255,127); 
			$otsc=imagecolortransparent($srcImg,$color); 
			if($otsc >=0 && $otsc <= imagecolorstotal($srcImg)){
				$tran=imagecolorsforindex($srcImg, $otsc);
				$newt=imagecolorallocate($newImg, $tran["red"], $tran["green"], $tran["blue"]);
				imagefill($newImg, 0, 0, $newt);

				imagecolortransparent($newImg, $newt);
			}
			imagealphablending($newImg, false);//解决png背景黑色问题
			imagesavealpha($newImg, true);
	    	imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $size["width"], $size["height"], $imgInfo["width"], $imgInfo["height"]);
			imagedestroy($srcImg);
			return $newImg;
		}

		private function getNewSize($name, $width, $height, $imgInfo){
			$size["width"]=$imgInfo["width"];
			$size["height"]=$imgInfo["height"];

			//缩放的宽度如果比原图小才重新设置宽度
			if($width < $imgInfo["width"]){
				$size["width"]=$width;
			}
			//缩放的高度如果比原图小才重新设置高度
			if($height < $imgInfo["height"]){
				$size["height"]=$height;
			}

			//图片等比例缩放的算法
			if($imgInfo["width"]*$size["width"] > $imgInfo["height"] * $size["height"]){
				$size["height"]=round($imgInfo["height"]*$size["width"]/$imgInfo["width"]);
			}else{
				$size["width"]=round($imgInfo["width"]*$size["height"]/$imgInfo["height"]);
			}
			return $size;

		}

		private function getInfo($name){
			$data=getImageSize($this->path.$name);

			$imageInfo["width"]=$data[0];
			$imageInfo["height"]=$data[1];
			$imageInfo["type"]=$data[2];

			return $imageInfo;
		}

		private function getImg($name, $imgInfo,$water = ''){
			$srcPic=$this->path.$name;
			switch($imgInfo["type"]){
				case 1: //gif
					$img=imagecreatefromgif($srcPic);
					break;
				case 2: //jpg
					$img=imageCreatefromjpeg($srcPic);
					break;
				case 3: //png
					$img=imageCreatefrompng($srcPic);
					break;
				default:
					return false;
				
			}

			return $img;
		}


		/* 功能：为图片加水印图片
		 * 参数$groundName: 背景图片，即需要加水印的图片
		 * 参数$pathurl: 图片保存路径，默认与原图所在路径一致。
		 * 参数$qz: 水印图片前缀名称
		*/

		function waterMark($groundName,$pathurl = ''){
			if(empty($pathurl)){
				$pathurl = $this->path;
			}
			$source    = $this->path.$groundName;
			$config    = $GLOBALS['config'];
			$watertext = json_decode($config['watertext'],true);
			if(file_exists($source)){
				$watermark_font = CHENCY_ROOT.'dm/font/'.$watertext['fontfamily']; //水印字体
				if(!file_exists($watermark_font)){
					echo '字体文件不存在';
					return false;
				}
				$source_info = getimagesize($source);
				$source_w    = $source_info[0];
				$source_h    = $source_info[1];
				switch($source_info[2]) {
					case 1 :
						$source_img = imagecreatefromgif($source);
						break;
					case 2 :
						$source_img = imagecreatefromjpeg($source);
						break;
					case 3 :
						$source_img = imagecreatefrompng($source);
						break;
					default :
						return false;
				}

				$temp   = imagettfbbox($watertext['fontsize'], 0, $watermark_font,$watertext['fonttext']);
				$width  = $temp[2] - $temp[1];
				$height = $temp[1] - $temp[7];
				unset($temp);
				$fontpot = $watertext['fontpot'];
				if(empty($fontpot)){
					$fontpot = 0;
				}
				if(($source_w < $width) ||($source_h < $height)){
				    $watertext['fonttext'] = '';
				}
				switch($fontpot) {
					case 1:
						$wx = 5;
						$wy = 5;
						break;
					case 2:
						$wx = floor(($source_w - $width) / 2);
						$wy = 5;
						break;
					case 3:
						$wx = $source_w - $width -15;
						$wy = 5;
						break;
					case 4:
						$wx = 0;
						$wy = ($source_h - $height) / 2;
						break;
					case 5:
						$wx = ($source_w - $width) / 2;
						$wy = ($source_h - $height) / 2;
						break;
					case 6:
						$wx = $source_w - $width -15;
						$wy = ($source_h - $height) / 2;
						break;
					case 7:
						$wx = 0;
						$wy = $source_h - $height -10;
						break;
					case 8:
						$wx = ($source_w - $width) / 2;
						$wy = $source_h - $height -10;
						break;
					case 9:
						$wx = $source_w - $width -15;
						$wy = $source_h - $height -10;
						break;
					default:
						$wx = rand(0,($source_w - $width));
						$wy = rand(0,($source_h - $height));
						break;
				}
				$wy += $height;

				$watermark_trans  = ceil(127 - 127*$watertext['fontopa']); //水印透明度
				$rgb = $this->HexToRGB($watertext['fontcolor']);  //水印颜色
				
				$color  = imagecolorallocatealpha($source_img,$rgb['red'],$rgb['green'],$rgb['blue'], $watermark_trans);
				imagettftext($source_img, $watertext['fontsize'], 0, $wx, $wy, $color, $watermark_font,$watertext['fonttext']);
           		$colors = imagecolorallocatealpha($source_img,255,255,255,127);
				$otsc   = imagecolortransparent($source_img,$colors); 
				if($otsc >=0 && $otsc <= imagecolorstotal($source_img)){
					$tran = imagecolorsforindex($source_img, $otsc);
					$newt = imagecolorallocate($source_img, $tran["red"], $tran["green"], $tran["blue"]);
					imagefill($source_img, 0, 0, $newt);
					imagecolortransparent($source_img, $newt);
				}
				imagealphablending($source_img, false);//解决png背景黑色问题
				imagesavealpha($source_img, true);

				switch($source_info[2]) {
					case 1 :
						imagegif($source_img, $pathurl.$groundName);
						break;
					case 2 :
						imagejpeg($source_img, $pathurl.$groundName,100);
						break;
					case 3 :
						imagepng($source_img, $pathurl.$groundName);
						break;
					default :
						return;
				}
				unset($source_info);
				imagedestroy($source_img);
				return '处理成功';
			}else{
				return '处理失败';
			}
		}


		/* 色值转换为rgb */
		private function HexToRGB($colour){
		    if ($colour [0] == '#') {
		        $colour = substr ($colour, 1);
		    }
		    if (strlen ( $colour ) == 6) {
		        list ( $r, $g, $b ) = array (
		                $colour [0] . $colour [1],
		                $colour [2] . $colour [3],
		                $colour [4] . $colour [5] 
		        );
		    } elseif (strlen ( $colour ) == 3) {
		        list ( $r, $g, $b ) = array (
		                $colour [0] . $colour [0],
		                $colour [1] . $colour [1],
		                $colour [2] . $colour [2] 
		        );
		    }else {
		        return false;
		    }
		    return array (
		        'red'   => hexdec ($r),
		        'green' => hexdec ($g),
		        'blue'  => hexdec ($b)
		    );
		}

		
	


	}
