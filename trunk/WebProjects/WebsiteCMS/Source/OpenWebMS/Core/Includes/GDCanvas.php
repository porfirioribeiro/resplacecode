<?php
class GDCanvas{
    var $image;
    var $drawColor=null;
    var $fillColor=null;
    var $colors=array();
    //Create the canvas
    function GDCanvas($width,$height){
        $this->image=imagecreatetruecolor($width,$height);
        $this->fillColor=$this->RGBA(0,0,0,127);
        $this->drawColor=$this->RGBA();
        imagefill($this->image, 0, 0, $this->fillColor);       
        imagesavealpha($this->image, true);
        imageantialias($this->image,true);
        imagealphablending($this->image,true);
    }

    //Color functions
    function RGBA($red=0,$green=0,$blue=0,$alpha=0){
        $c="C_".$red.$green.$blue.$alpha;
        if (isset($this->colors[$c])){
            return $this->colors[$c];
        }else{
            $this->colors[$c]=imagecolorallocatealpha($this->image, $red,$green,$blue,$alpha);
            return $this->colors[$c];
        }
    }
    function colorHex($color){
        $int = hexdec(str_replace("#","",$color));
        $r=(255 & ($int >> 24));
        $g=(255 & ($int >> 16));
        $b=(255 & ($int >> 8) );
        $a=(127-(((255 & $int)/255)*127));
        return $this->RGBA($r,$g,$b,$a);
    }
    //Get Set Stuff
    function setBrush($br){
        if ($br instanceof GDCanvas){
            $br=$br->image;
        }
        return imagesetbrush($this->image,$br);
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
    //Output functions
    function outPng($file=null){
        if ($file==null){
            header('Content-type: image/png');
            imagepng($this->image);
        }else{
            imagepng($this->image,$file);
        }
    }
    function out($file=null){
        $this->outPng($file);
    }
    //Destructor, kill the resource
    function __destruct(){
        imagedestroy($this->image);
    }
	
	//Set the TTF font
	function SetFontTTF($font){
	$font=dirname(__FILE__)."\..\Fonts\\".$font;
		if(!is_readable($font))
		{
			$font=dirname(__FILE__)."\..\Fonts\default.ttf";
		}
		$this->FontTTF=$font;
	}
	
	//Set font size
	function SetFontSize($size){
		$this->FontSize=$size;
	}
	
	//Add TTF Text
	function AddTextTTF($angle,$xpos,$ypos,$font_color,$text){
		// check font availability
		$font_file=$this->FontTTF;
		//echo $font_file;
		if(!is_readable($font_file))
		{
			trigger_error("Invalid font resource supplied to GDCanvas->AddTextTTF([arg0]) - [arg0] no font with this name in WebMS fonts directory.", E_USER_ERROR);
			die(' ');
		}
		else
		{
			ImageTTFText($this->image,$this->FontSize,$angle,$xpos,$ypos,$this->HexToColor($font_color),$font_file,$text);
		}
	}
	
	//Fetch the width height and xy of each posiotion
	function TextTTFBox($angle, $text){
		// compute size with a zero angle
		$coords = imagettfbbox($this->FontSize, 0, $this->FontTTF, $text);
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
	
	//Convert hex to RGB
	function HexToColor($hex){
		// remove '#'
		if(substr($hex,0,1) == '#')
			$hex = substr($hex,1) ;
	
		// expand short form ('fff') color
		if(strlen($hex) == 3)
		{
			$hex = substr($hex,0,1) . substr($hex,0,1) .
				   substr($hex,1,1) . substr($hex,1,1) .
				   substr($hex,2,1) . substr($hex,2,1) ;
		}
	
		if(strlen($hex) != 6)
			trigger_error("Invalid color supplied to GDCanvas->HexToRGB([arg0]) - [arg0] is not 6 character long.", E_USER_ERROR);
	
		// convert
		$rgb['red'] = hexdec(substr($hex,0,2)) ;
		$rgb['green'] = hexdec(substr($hex,2,2)) ;
		$rgb['blue'] = hexdec(substr($hex,4,2)) ;
	
		//return $rgb ;
		$font_color = ImageColorAllocate($this->image,$rgb['red'],$rgb['green'],$rgb['blue']) ; 
		return $font_color;
	}
		
	
}
?>