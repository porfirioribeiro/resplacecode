<?PHP 
include 'core/f_e_m.php';
   if (isset($name)) 
    $filename=$name;
   else
    $filename = "My emote.png";
    
    if (!isset($format))$format="png";
   
   if (strpos($filename,".")===false)
      $filename=$filename.".".$format;
   $files=$filename;
   $filename="core/".$filename;
    
   $im= @imagecreate($pw,$ph)
     or die("Cannot Initialize new GD image stream, therefore there is an error or you dont have GD!");
	 
	 //get color
	 $rgb=imagecolorat ($im, 0, $ph);
	 $r = ($rgb >> 16) & 0xFF;
	$g = ($rgb >> 8) & 0xFF;
	$b = $rgb & 0xFF;
	
	imagecolortransparent($im,imagecolorallocate($im,$r,$g,$b));

   $faceim= imagecreatefrompng("emfaces/".$fi.".png");
   $eyeim = imagecreatefrompng("emeyes/".$ei.".png");
   $mouthim = imagecreatefrompng("emmouth/".$mi.".png");
   imagecopy($im, $faceim, $fx, $fy, 0,0 , 20, 20);
   imagecopy($im, $eyeim, $ex, $ey, 0,0 , 20, 20);
   imagecopy($im, $mouthim, $mx, $my, 0,0 , 20, 20);
   switch ($format) {
     case "png":
        imagepng($im,$filename);
     break;  
     case "jpg":
        imagejpeg($im,$filename);
     break;      
     case "gif":
        imagegif($im,$filename);
     break; 
   } 
   imagedestroy($im);
   imagedestroy($faceim);
   imagedestroy($eyeim);
   imagedestroy($mouthim);


if (is_file($filename)) {
	header("Content-type: application/octet-stream");
	header("Content-Length: ".filesize($filename));
	header("Content-Disposition: attachment; filename=\"".$files."\"");
	
	$fp = fopen($filename, 'rb');
	fpassthru($fp);
	fclose($fp);
	unlink($filename);
}
else {
	echo "File not available.";
}

?>
