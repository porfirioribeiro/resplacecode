<?php
   header("Content-type: image/png");
   include 'core/f_e_m.php';
   $im= @imagecreate($pw,$ph)
     or die("Cannot Initialize new GD image stream, therefore there is an error or you dont have GD!");
	 
	 //get color
	 $rgb=imagecolorat ($im, 0, $ph);
	 $r = ($rgb >> 16) & 0xFF;
	$g = ($rgb >> 8) & 0xFF;
	$b = $rgb & 0xFF;
	
	imagecolortransparent($im,imagecolorallocate($im,$r,$g,$b));

   $faceim= imagecreatefrompng("emfaces/".$fi.".png");
   $size1=imagesx($faceim);
   $eyeim = imagecreatefrompng("emeyes/".$ei.".png");
   $size2=imagesx($eyeim);
   $mouthim = imagecreatefrompng("emmouth/".$mi.".png");
   $size3=imagesx($mouthim);
   
   imagecopy($im, $faceim, $fx, $fy, 0,0 , $size1, $size1);
   imagecopy($im, $eyeim, $ex, $ey, 0,0 , $size2, $size2);
   imagecopy($im, $mouthim, $mx, $my, 0,0 , $size3, $size3);
   imagepng($im);
   imagedestroy($im);
   imagedestroy($faceim);
   imagedestroy($eyeim);
   imagedestroy($mouthim);
?> 
