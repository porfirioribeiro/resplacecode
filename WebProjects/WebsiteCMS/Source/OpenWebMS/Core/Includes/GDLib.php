<?php
/**
* PHP GD Library
* A library for constructiong images with the GD library.
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 09-08-07
*/

//Independant script use variables.
//For using outside WebMS:
//$WebMS["WebMSPath"]	=	preg_replace("/\\\/","/",dirname(__FILE__));
//$WebMS["WebMSUrl"]	=	str_replace($_SERVER["DOCUMENT_ROOT"], "", $WebMS["RootPath"])."OpenWebMS/";
//$WebMS["CorePath"]	=	$WebMS["WebMSPath"]."Core/";
//$WebMS["imgNumb"]	=	0;

class GDLib {
	var $image;
	var $colors		=array();
	var $drawColor	=null;
	var $fillColor	=null;
	var $fontSize	=14;
	var $font		=null;
	var $cache		=false;
	var $width		=0;
	var $height		=0;

	function GDLib($width=1,$height=1,$cache=null) {
		global $WebMS;
		$this->width=$width;
		$this->height=$height;
		if ($cache==true) {
			$this->cache=true;
			$hash=hash('md5',dirname(__FILE__));
			$tempPath=$WebMS["WebMSPath"].'Temp/';
			$WebMS["imgNumb"]+=1;
			$imgNumb=$WebMS["imgNumb"];
			$fileName=$tempPath.$hash.$imgNumb.'.png';
			if (file_exists($fileName)) {
				$date =date('y-m-d', filemtime($fileName));
				$today=date('y-m-d');
				$diff =abs(strtotime($today)-strtotime($date)) / 86400;
				echo $diff;
				if ($diff>=7) {
					//remake the cache :)
					$this->MakeCanvas($width,$height);
				}
			} else {
				//remake the cache :)
				$this->MakeCanvas($width,$height);
			}
		} else {
			//no cache
			$this->MakeCanvas($width,$height);
		}
	}

	function CheckCache() {
		global $WebMS;

		if ($this->cache==true) {

			$hash=hash('md5',dirname(__FILE__));
			$tempPath=$WebMS["WebMSPath"].'Temp/';
			$WebMS["imgNumb"]+=1;
			$imgNumb=$WebMS["imgNumb"];
			$fileName=$tempPath.$hash.$imgNumb.'.png';
			echo '{'.$fileName.'}';
			if (file_exists($fileName)) {
				echo' CACHED ';
				$date =date('y-m-d', filemtime($fileName));
				$today=date('y-m-d');
				$diff =abs(strtotime($today)-strtotime($date)) / 86400;
				echo $diff;
				if ($diff>=7) {
					echo' RE-CACHED ';
				} else {
					echo' SEND-CACHED ';
					//do not procede with GD rendering, pass link to cached image
					return array($WebMS["WebMSUrl"].'Temp/'.$hash.$imgNumb.'.png',$diff);
					exit;
				}
			}
		}
	}

	function MakeCanvas($width=1,$height=1) {
		$this->image=imagecreatetruecolor($width,$height);
		$this->CreateStyle('Default','Eunjin',14,"0,0,0,0","0,0,0,127");
		imagefill($this->image, 0, 0, $this->colors[$this->fillColor]);
		imagealphablending($this->image,true);
		imagesavealpha($this->image, true);


	}

	function SetColor($c,$set=null) {
		//Attempt to understand the input
		//Accepts: RGB + RGBA + HEX (multi)
		if (0 === strpos($c, 'C_')) {
			$c = substr($c, 2);
		}

		$c=explode(',',$c);
		if (count($c)==3) {
			$mode='RGB';
		} else if (count($c)==4) {
			$mode='RGBA';
		} else if (count($c)==1) {
			$mode='HEX';
		} else {
			//default to black
			$c=array(0,0,0,0);
			$mode='RGBA';
		}

		//convert HEX to RGBA
		if ($mode=='HEX') {
			$hex = $c[0];
			if (0 === strpos($hex, '#')) {
				$hex = substr($hex, 1);
			} else if (0 === strpos($hex, '&H')) {
				$hex = substr($hex, 2);
			}
			if (strlen($hex)==3) {
				$cutpoint = 1;
			} else {
				$cutpoint = 2;
			}

			$c = explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 4);

			$c[0] = (isset($c[0]) ? hexdec($c[0]) : 0);
			$c[1] = (isset($c[1]) ? hexdec($c[1]) : 0);
			$c[2] = (isset($c[2]) ? hexdec($c[2]) : 0);
			if (!isset($c[3]) || $c[3]==0) {
				$mode='RGB';
			} else {
				$c[3] = (isset($c[3]) ? hexdec($c[3]) : 0);
				$mode='RGBA';
			}
		}

		//Create a color 'code':
		if ($mode=="RGBA") {
			$col="C_".$c[0].','.$c[1].','.$c[2].','.$c[3];
			if (!isset($this->colors[$col])) {
				$this->colors[$col]=imagecolorallocatealpha($this->image,$c[0],$c[1],$c[2],$c[3]);
			}
		} else if ($mode=="RGB") {
			$col="C_".$c[0].','.$c[1].','.$c[2];
			if (!isset($this->colors[$col])) {
				$this->colors[$col]=imagecolorallocate($this->image,$c[0],$c[1],$c[2]);
			}
		}

		if ($set=='draw') {
			$this->drawColor=$col;
		} else if ($set=='fill') {
			$this->fillColor=$col;
		} else if ($set=='none') {

		} else {
			$this->drawColor=$col;
			$this->fillColor=$col;
		}

		return $col;
	}

	function SetFont($font=null,$size=null) {
		global $WebMS;
		$font=$WebMS["CorePath"]."Fonts/".$font.'.ttf';

		if (!$size==null)
		$this->fontSize=(int)$size;

		if(!is_readable($font)) {
			$font=$WebMS["CorePath"]."Fonts/FreeSans.ttf";
			return false;
		} else {
			$this->font=$font;
			return true;
		}
	}

	function CreateStyle($stylename,$font,$fontSize,$drawColor,$fillColor) {
		global $WebMS;
		//Make a style that can be recalled as needed.
		eval('$this'."->style_$stylename=array('$font',$fontSize,'$drawColor','$fillColor');");

		//apply the style
		$this->SetFont($font,$fontSize);
		$this->SetColor($drawColor,"draw");
		$this->SetColor($fillColor,"fill");
	}

	function SetStyle($stylename) {
		//Recall a style.
		$style=eval('$this'."->style_$stylename;");
		$this->font=$WebMS["CorePath"]."Fonts/".$style[0].'.ttf';
		$this->fontSize=(int)$style[1];
		$this->setColor($style[2],"draw");
		$this->setColor($style[3],"fill");
	}

	function CreateText($angle,$xpos,$ypos,$text) {
		// check font availability
		$font_file=$this->font;
		//echo $font_file;
		if(!is_readable($font_file))
		{
			trigger_error("Invalid font resource supplied to GDLib, check directory or resource : Given:$font_file.", E_USER_ERROR);
			die(' ');
		}
		else
		{
			ImageTTFText($this->image,$this->fontSize,$angle,$xpos,$ypos,$this->colors[$this->drawColor],$font_file,$text);
		}
	}

	function GetTextSize($angle, $text) {
		// compute size with a zero angle
		$coords = imagettfbbox($this->fontSize, $angle, $this->font, $text);
		// convert angle to radians
		$a = deg2rad($angle);
		// compute some usefull values
		$ca = cos($a);
		$sa = sin($a);
		$ret = array();
		// perform transformations
		for($i = 2; $i < 9; $i += 2) {
			$ret[$i] = round($coords[$i-2] * $ca + $coords[$i-2+1] * $sa);
			$ret[$i+1] = round($coords[$i-2+1] * $ca - $coords[$i-2] * $sa);
		}
		$ret[0]=$ret[4]-$ret[2];
		$ret[1]=abs($ret[7])+$ret[3];
		return $ret;
	}

	//SET A BRUSH
	function setBrush($br) {
		if ($br instanceof GDLib) {
			$br=$br->image;
		}
		return imagesetbrush($this->image,$br);
	}


	//Draw functions
	function drawArc($cx, $cy, $width, $height, $start, $end,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->drawColor];
		return imagearc ( $this->image, $cx, $cy, $width, $height, $start, $end, $color);
	}
	function drawEllipse ( $cx, $cy, $width, $height,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->drawColor];
		return imageellipse($this->image, $cx, $cy, $width, $height, $color);
	}
	function drawRect ( $x1, $y1, $x2, $y2,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->drawColor];
		return imagerectangle ( $this->image, $x1, $y1, $x2, $y2, $color );
	}
	//Fill functions
	function fillArc($cx, $cy, $width, $height, $start, $end,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->fillColor];
		return imagefilledarc ( $this->image, $cx, $cy, $width, $height, $start, $end, $color ,IMG_ARC_PIE);
	}
	function fillEllipse ( $cx, $cy, $width, $height,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->fillColor];
		//die($color."");
		return imagefilledellipse ( $this->image, $cx, $cy, $width, $height, $color);
	}
	function fillRect ( $x1, $y1, $x2, $y2,$color=null) {
		$color=($color!=null)?$color:$this->colors[$this->fillColor];
		echo $color;
		return imagefilledrectangle ( $this->image, $x1, $y1, $x2, $y2, $color );
	}
	//Multy functions draw+fill
	function Arc($cx, $cy, $width, $height, $start, $end,$drawColor=null,$fillColor=null) {
		return $this->fillArc($cx, $cy, $width, $height, $start, $end, $fillColor) && $this->drawArc($cx, $cy, $width, $height, $start, $end, $drawColor);
	}
	function Ellipse ( $cx, $cy, $width, $height,$drawColor=null,$fillColor=null) {
		return $this->fillEllipse($cx,$cy,$width,$height,$fillColor) &&  $this->drawEllipse($cx,$cy,$width,$height,$drawColor);
	}
	function Rect ($x1, $y1, $x2, $y2,$drawColor=null,$fillColor=null) {
		return $this->fillRect($x1,$y1,$x2,$y2,$fillColor) && $this->drawRect($x1,$y1,$x2,$y2,$drawColor);
	}

	//Create captcha text
	function Captcha($fnts=null,$fntcols=null) {
		$rnd2=0;
		$step=0;

		//set img background to white
		imagefilledrectangle($this->image,0,0,$this->width,$this->height,$this->colors[$this->setColor("255,255,255","none")]);

		//Select a font to use
		if (is_array($fnts)) {
			$rnd=rand(0,count($fnts));
			$this->SetFont($fnts[$rnd]);
		}

		// generate a random string of 3 to 6 characters.
		$string = "";
		$letters = "ABDEFGHKLMNPRSTWX3456789";
		for ($i = 0; $i < rand(3,6); ++$i) {
			$string .= substr($letters, rand(0,strlen($letters)-1), 1);
		}

		// put the random string into the session
		$_SESSION['captcha_string'] = $string;

		// internal scale factor for antialias
		$scale = 1.1;
		$perturbation = 0.5; // bigger numbers give more distortion; 1 is standard
		$width=floor($this->width*$scale);
		$height=floor($this->height*$scale);

		// initialize temporary image
		$width2 = $width;
		$height2 = $height;
		$this->tmpimg = imagecreatetruecolor($width2, $height2);
		imagefill($this->tmpimg, 0, 0, $this->colors[$this->SetColor("0,0,0,127","fill")]);
		imagealphablending($this->tmpimg,true);
		imagesavealpha($this->tmpimg, true);

		// initialize temporary image 2
		$this->tmpimg2 = imagecreatetruecolor($width2, $height2);
		imagefill($this->tmpimg2, 0, 0, $this->colors[$this->SetColor("0,0,0,127","fill")]);
		imagealphablending($this->tmpimg2,true);
		imagesavealpha($this->tmpimg2, true);


		$cols=array("#FF8F8F","#FFB68F","#FFEB8F","#DEFF8F","#77EFCB","#868FEF","#E086EF","#0EEF17","#FFC62F","#2FC9FF");

		//background color

		//$this->fillrect(0,0,$this->width,$this->height);

		//fill part of the image
		$f=$width;
		while ($f>0) {
			//generate a number
			$gen=ceil(rand(3,5));
			$f=$f-$gen;

			//draw
			$this->SetColor($cols[floor(rand(0,5))],'fill');
			imagefilledrectangle($this->image,$f,0,$f+$gen,$this->height,$this->colors[$this->fillColor]);

		}

		$imagex = imagesx($this->image);
		$imagey = imagesy($this->image);

		for ($x = 0; $x < $imagex; ++$x) {
			for ($y = 0; $y < $imagey; ++$y) {
				$distx = rand(-4, 4);
				$disty = rand(-4, 4);

				if ($x + $distx >= $imagex) continue;
				if ($x + $distx < 0) continue;
				if ($y + $disty >= $imagey) continue;
				if ($y + $disty < 0) continue;

				$oldcol = imagecolorat($this->image, $x, $y);
				$newcol = imagecolorat($this->image, $x + $distx, $y + $disty);
				imagesetpixel($this->image, $x, $y, $newcol);
				imagesetpixel($this->image, $x + $distx, $y + $disty, $oldcol);
			}
		}

		// put straight text into $tmpimage
		$fsize = $height2*0.50;
		$bb = imageftbbox($fsize, 0, $this->font, $string);
		$tx = $bb[4]-$bb[0];
		$ty = $bb[5]-$bb[1];
		$x = floor($width2/2 - $tx/2 - $bb[0]);
		$y = round($height2/2 - $ty/2 - $bb[1]);
		imagettftext($this->tmpimg, $fsize, 0, $x, $y, $this->colors[$this->drawColor], $this->font, $string);
		//imagefill($this->tmpimg, 0, 0, $this->colors[$this->SetColor("255,255,255","fill")]);
		//FILTER
		//$sharpen = array(array(1, 1, 1), array(1, -7, 1), array(1, 1, 1));
		//imageconvolution($this->tmpimg, $sharpen, 1, 0);
		//$gaussian = array(array(1.0, 2.0, 1.0), array(2.0, 4.0, 2.0), array(1.0, 2.0, 1.0));
		//imageconvolution($this->tmpimg, $gaussian, 16, 0);
		//imagefilter($this->image, IMG_FILTER_NEGATE);
		//imagefilter($this->image, IMG_FILTER_GRAYSCALE);
		//imagefilter($this->image, IMG_FILTER_COLORIZE, 0, -255, -255);
		//imagefilter($this->tmpimg, IMG_FILTER_EDGEDETECT);

		// addgrid($this->tmpimg, $width2, $height2, $iscale, $this->colors[$this->drawColor]); // debug

		// warp text from $this->tmpimg into $img
		$numpoles = 2.5;

		// make an array of poles AKA attractor points
		for ($i = 0; $i < $numpoles; ++$i) {
			do {
				$px[$i] = rand(0, $width);
			} while ($px[$i] >= $width*0.3 && $px[$i] <= $width*0.7);
			do {
				$py[$i] = rand(0, $height);
			} while ($py[$i] >= $height*0.3 && $py[$i] <= $height*0.7);

			$rad[$i] = rand($width*0.4, $width*0.8);
			$tmp = -(0.0001*rand(0,9999))*0.15-0.15;
			$amp[$i] = $perturbation * $tmp;
		}

		// get img properties bgcolor
		$bgcol = imagecolorat($this->tmpimg, 1, 1);
		$width2 = $width;
		$height2 = $height;

		$c=0;
		// loop over $img pixels, take pixels from $tmpimg with distortion field
		for ($ix = 0; $ix < $width; ++$ix)
		for ($iy = 0; $iy < $height; ++$iy) {
			$step+=1;
			$x = $ix;
			$y = $iy;
			for ($i = 0; $i < $numpoles; ++$i) {
				$dx = $ix - $px[$i];
				$dy = $iy - $py[$i];
				if ($dx == 0 && $dy == 0)
				continue;
				$r = sqrt($dx*$dx + $dy*$dy);
				if ($r > $rad[$i])
				continue;
				$rscale = $amp[$i] * sin(3.14*$r/$rad[$i]);
				$x += $dx*$rscale;
				$y += $dy*$rscale;
			}

			if ($x >= 0 && $x < $width2 && $y >= 0 && $y < $height2)

			if (is_array($fntcols)) {
				if ($step==180) {
					$rnd2=floor(rand(0,count($fntcols)-1));
					$step=1;
				}
				$c=$this->colors[$this->setColor($fntcols[$rnd2],"none")];
			} else {
				$c = imagecolorat($this->tmpimg, $x, $y);
			}

			//if (!strcmp($c,$this->colors[$this->setColor('255,255,255',"none")])==0) {
			//
			//}
			if (strcmp(imagecolorat($this->tmpimg, $x, $y),$this->colors[$this->setColor("0,0,0,127","none")])==0) {
				$c = imagecolorat($this->tmpimg, $x, $y);
			}

			imagesetpixel($this->tmpimg2, $ix, $iy, $c);
			//if (!strcmp($c,$this->colors[$this->setColor('255,255,255',"none")])==0)
		}

		imagecopyresampled($this->image,$this->tmpimg2,0,0,0,0,$this->width,$this->height,$width,$height);

		//randomly select whether to apply an edge detect effect or not.
		if (rand(0,1)) {
			imagefilter($this->image, IMG_FILTER_EDGEDETECT);
		} else {
			imagefilter($this->image, IMG_FILTER_SMOOTH, 11);
		}

		//imagecopyresized($this->image,$this->tmpimg2,0,0,0,0,$this->width,$this->height,$width,$height);

		//$gaussian = array(array(1.0, 2.0, 1.0), array(2.0, 4.0, 2.0), array(1.0, 2.0, 1.0));
		//imageconvolution($this->image, $gaussian, 16, 0);
		//imagefilter($this->image, IMG_FILTER_NEGATE);
		//imagefilter($this->image, IMG_FILTER_GRAYSCALE);
		//imagefilter($this->image, IMG_FILTER_COLORIZE, 0, -255, -255);
		//imagefilter($this->image, IMG_FILTER_EDGEDETECT);
	}

	//OUTPUT THE GD
	function Out($file=null) {
		global $WebMS;

		$imgNumb=$WebMS["imgNumb"];

		if ($this->cache==true || $file==true) {
			$hash=hash('md5',dirname(__FILE__));
			$tempPath=$WebMS["WebMSPath"].'Temp/';
			$tempPathUrl=$WebMS["WebMSUrl"].'Temp/';
		}

		if ($this->cache==true) {
			$fileName=$tempPath.$hash.$imgNumb.'.png';
			$fileNameUrl=$tempPathUrl.$hash.$imgNumb.'.png';

			imagepng($this->image,$fileName);
			return $fileNameUrl;
		} else {
			if ($file==null) {
				header('Content-type: image/png');
				imagepng($this->image);
			} else if ($file===true) {
				$rand=floor(rand(21,33489));
				$fileName=$tempPath.'temp_'.$rand.$hash.$imgNumb.'.png';
				$fileNameUrl=$tempPathUrl.'temp_'.$rand.$hash.$imgNumb.'.png';

				imagepng($this->image,$fileName);
				return $fileNameUrl;
			} else {
				imagepng($this->image,$file);
			}
		}
	}

	//DESTRUCTION
	//function __destruct() {
	//	imagedestroy($this->image);
	//}

	function Destroy() {
		imagedestroy($this->image);
	}

}
?>