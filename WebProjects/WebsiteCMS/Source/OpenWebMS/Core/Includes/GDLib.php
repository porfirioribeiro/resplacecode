<?php

class GDLib {
	var $imagehash=null;
	var $image;
	var $colors=array();
	var $drawColor=null;
    var $fillColor=null;
	var $FontSize=14;
	var $Font=null;
	
	function GDLib($width=1,$height=1) {
	global $WebMS;
		$this->MakeCanvas($width,$height);
		$this->Font=$WebMS["CorePath"]."Fonts/Halo.ttf";
	}
	
	function MakeCanvas($width=1,$height=1){
		//append for unique code
		$this->imagehash=$this->imagehash.$width.$height;
		
        $this->image=imagecreatetruecolor($width,$height);
        $this->SetColor("0,0,0,127","fill");
        $this->SetColor("0,0,0,0","draw");
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
			if (!$c[3]) {
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
	
	function CreateStyle($stylename,$font,$fontsize,$drawcolor,$fillcolor) {
		global $WebMS;
		//Make a style that can be recalled as needed.
		eval('$this'."->style_$stylename=array('$font',$fontsize,'$drawcolor','$fillcolor');");
		
		//apply the style
		$this->SetFont($font,$fontsize);
		$this->SetColor($drawcolor,"draw");
		$this->SetColor($fillcolor,"fill");
	}
	
	function SetStyle($stylename) {
		//Recall a style.
		$style=eval('$this'."->style_$stylename;");
		$this->Font=$Font=$WebMS["CorePath"]."Fonts/".$style[0].'.ttf';
		$this->FontSize=(int)$style[1];
		$this->SetColor($style[2],"draw");
		$this->SetColor($style[3],"fill");
	}
	
	function CreateText($angle,$xpos,$ypos,$text){
		//append for unique code
		$txt= preg_replace('/[^a-zA-Z0-9]/i','',$text);
		$this->imagehash=$this->imagehash.$angle.$xpos.$ypos.strlen($txt).substr($txt,0,1).substr($txt,-1,1).substr($txt,(strlen($txt)/2),1);
		
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
			ImageTTFText($this->image,$this->FontSize,$angle,$xpos,$ypos,$this->colors[$this->DrawColor],$font_file,$text);
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
    //Draw functions
    function drawArc($cx, $cy, $width, $height, $start, $end,$color=null){
        $color=($color!=null)?$color:$this->drawColor;    
        return imagearc ( $this->image, $cx, $cy, $width, $height, $start, $end, $color ); 
    }
    function drawEllipse ( $cx, $cy, $width, $height,$color=null){
        $color=($color!=null)?$color:$this->drawColor;  
        return imageellipse($this->image, $cx, $cy, $width, $height, $color);  
    }
    function drawRect ( $x1, $y1, $x2, $y2,$color=null){
        $color=($color!=null)?$color:$this->drawColor;  
        return imagerectangle ( $this->image, $x1, $y1, $x2, $y2, $color );
    }
    //Fill functions
    function fillArc($cx, $cy, $width, $height, $start, $end,$color=null){
        $color=($color!=null)?$color:$this->fillColor;    
        return imagefilledarc ( $this->image, $cx, $cy, $width, $height, $start, $end, $color ,IMG_ARC_PIE); 
    }
    function fillEllipse ( $cx, $cy, $width, $height,$color=null){
        $color=($color!=null)?$color:$this->fillColor;
        //die($color."");
        return imagefilledellipse ( $this->image, $cx, $cy, $width, $height, $color);  
    }
    function fillRect ( $x1, $y1, $x2, $y2,$color=null){
        $color=($color!=null)?$color:$this->fillColor;  
        return imagefilledrectangle ( $this->image, $x1, $y1, $x2, $y2, $color );
    }
    //Multy functions draw+fill
    function Arc($cx, $cy, $width, $height, $start, $end,$drawColor=null,$fillColor=null){
        return $this->fillArc($cx, $cy, $width, $height, $start, $end, $fillColor) && $this->drawArc($cx, $cy, $width, $height, $start, $end, $drawColor);
    }    
    function Ellipse ( $cx, $cy, $width, $height,$drawColor=null,$fillColor=null){
        return $this->fillEllipse($cx,$cy,$width,$height,$fillColor) &&  $this->drawEllipse($cx,$cy,$width,$height,$drawColor);
    }
    function Rect ( $x1, $y1, $x2, $y2,$drawColor=null,$fillColor=null){
        return $this->fillRect($x1,$y1,$x2,$y2,$fillColor) && $this->drawRect($x1,$y1,$x2,$y2,$drawColor);
    }
	//we may have diferent outputs for png gif bmp etc.... but out will do png by default
	//Dont destroy the image here
    function outPng($file=null){
        if ($file==null){
            header('Content-type: image/png');
            imagepng($this->image);
        }else if ($file===true){
            $pt="Image__".rand(0,1000).".png";
            imagepng($this->image,Conf::get("TempPath").$pt);
            return Conf::get("TempUrl").$pt;
        }else{
            imagepng($this->image,$file);
        }
    }
    function out($file=null){
        return $this->outPng($file);
    }
	
	function Destroy() {
		imagedestroy($this->image);
	}
    //you know what is a destructor?????? This function is called when the object is destroyed for example if you have 
    //it inside a function it will be automatic destroyed on the end of the function
    //Its automatic
    function __destruct(){
        imagedestroy($this->image);
    }
	
}
?>