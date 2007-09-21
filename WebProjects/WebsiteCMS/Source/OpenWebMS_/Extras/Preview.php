<?php
//generate wallpaper image... you can set the parameters in several ways...
header("Content-type: image/png");

$file=$_REQUEST['file'];
$width=(int)$_REQUEST['width'];
$height=(int)$_REQUEST['height'];


$image = imagecreatefrompng($file); 
$imgsize = getimagesize ($file);

imagealphablending($image,true);

$crop = imagecreatetruecolor($width,$height);


imagecopyresampled($crop, $image, 0, 0, 0, 0, $width, $height, $imgsize[0], $imgsize[1]);

imagepng($crop);
imagedestroy($crop);
?>