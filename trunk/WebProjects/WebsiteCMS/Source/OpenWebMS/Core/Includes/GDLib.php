<?php
class GDLib {
	var $image;
	var $colors		=array();
	var $drawColor	=null;
    var $fillColor	=null;
	var $fontSize	=14;
	var $font		=null;
	var $cache		=false;
	
	function GDLib($width=1,$height=1,$cache=null) {
	global $WebMS;
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
	
	function MakeCanvas($width=1,$height=1){
        $this->image=imagecreatetruecolor($width,$height);
		$this->CreateStyle('Default','Eunjin',14,"0,0,0,0","0,0,0,127");
        imagefill($this->image, 0, 0, $this->colors[$this->fillColor]);       
        imagesavealpha($this->image, true);
        imageantialias($this->image,true);
        imagealphablending($this->image,true);
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
			if (!isset($this->colors[$col])){
				$this->colors[$col]=imagecolorallocatealpha($this->image,$c[0],$c[1],$c[2],$c[3]);
			}
		} else if ($mode=="RGB") {
			$col="C_".$c[0].','.$c[1].','.$c[2];
			if (!isset($this->colors[$col])){
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
	
	function SetFont($font,$size){
	global $WebMS;
	$font=$WebMS["CorePath"]."Fonts/".$font.'.ttf';
	
		if(!is_readable($font))
		{
			$font=$WebMS["CorePath"]."Fonts/FreeSerif.ttf";
		}
		$this->Font=$font;
		$this->FontSize=(int)$size;
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
		$this->Font=$font=$WebMS["CorePath"]."Fonts/".$style[0].'.ttf';
		$this->FontSize=(int)$style[1];
		$this->SetColor($style[2],"draw");
		$this->SetColor($style[3],"fill");
	}
	
	function CreateText($angle,$xpos,$ypos,$text){
		// check font availability
		$font_file=$this->Font;
		//echo $font_file;
		if(!is_readable($font_file))
		{
			trigger_error("Invalid font resource supplied to GDLib, check directory or resource : Given:$font_file.", E_USER_ERROR);
			die(' ');
		}
		else
		{
			ImageTTFText($this->image,$this->FontSize,$angle,$xpos,$ypos,$this->colors[$this->drawColor],$font_file,$text);
		}
	}
	
	function GetTextSize($angle, $text){
		// compute size with a zero angle
		$coords = imagettfbbox($this->FontSize, $angle, $this->Font, $text);
		// convert angle to radians
		$a = deg2rad($angle);
		// compute some usefull values
		$ca = cos($a);
		$sa = sin($a);
		$ret = array();
		// perform transformations
		for($i = 2; $i < 9; $i += 2){
			$ret[$i] = round($coords[$i-2] * $ca + $coords[$i-2+1] * $sa);
			$ret[$i+1] = round($coords[$i-2+1] * $ca - $coords[$i-2] * $sa);
		}
		$ret[0]=$ret[4]-$ret[2];
		$ret[1]=abs($ret[7])+$ret[3];
		return $ret;
	}
	
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
			} else if ($file==true) {
				$fileName=$tempPath.$hash.'_temp_'.$imgNumb.'.png';
				$fileNameUrl=$tempPathUrl.$hash.'_temp_'.$imgNumb.'.png';
				
				imagepng($this->image,$fileName);
				return $fileNameUrl;
			} else {
				imagepng($this->image,$file);
			}
		}
	
	
	
		
		//imagedestroy($this->image);
	}
	
	function __destruct() {
		imagedestroy($this->image);
	}
	
	function Destroy() {
		imagedestroy($this->image);
	}
	
}
?>