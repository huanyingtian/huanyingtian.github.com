<?php
	class Image {
		private $path;
		public $fontfamily = 'msyh.ttc';
		public $fontsize = 20;
		public $fonttext = '文字水印';
		public $fontpot = 0;
		public $fontopa = '0.7';
		public $fontcolor = '#000';


		//构造方法用来对图片所在位置进行初使化
		function __construct($path="./"){
			$this->path=rtrim($path, "/")."/";
		}

		/* 功能：为图片加水印图片
		 * 参数$groundName: 背景图片，即需要加水印的图片
		 * 参数$qz: 水印图片前缀名称
		*/

		function waterMark($groundName,$qz='wark_'){
			$source = $this->path.$groundName;
			if(file_exists($source)){
				$watermark_font = CHENCY_ROOT.'dm/font/'.$this->fontfamily; //水印字体

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

				$temp = imagettfbbox($this->fontsize, 0, $watermark_font,$this->fonttext);
				$width = $temp[2] - $temp[1];
				$height = $temp[1] - $temp[7];
				unset($temp);

				switch($this->fontpot) {
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

				$watermark_trans  = ceil(127 - 127*$this->fontopa); //水印透明度
				$rgb = $this->HexToRGB($this->fontcolor);  //水印颜色
				
				$color  = imagecolorallocatealpha($source_img,$rgb['red'],$rgb['green'],$rgb['blue'], $watermark_trans);
				imagettftext($source_img,$this->fontsize, 0, $wx, $wy, $color, $watermark_font,$this->fonttext);
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
						imagegif($source_img, $this->path.$qz.$groundName);
						break;
					case 2 :
						imagejpeg($source_img, $this->path.$qz.$groundName,100);
						break;
					case 3 :
						imagepng($source_img, $this->path.$qz.$groundName);
						break;
					default :
						return;
				}
				unset($source_info);
				imagedestroy($source_img);
				return $qz.$groundName;
			}else{
				echo "需要加水印图片不存在";
				return false;
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
