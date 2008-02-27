<?
$tt=strlen($c);
$ct="";
for($i=$tt;$i<=5;$i++){
  $ct=$ct."0";
}
$ct=$ct.$c; 
$a1=substr($ct, 1, 1);
$a2=substr($ct, 2, 1);
$a3=substr($ct, 3, 1);
$a4=substr($ct, 4, 1);
$a5=substr($ct, 5, 1);
header("Content-type: image/png");
$img=imagecreatefrompng("!.png");
$d=array();
for ($i=0;$i<=9;$i++){
  $d[$i]= imagecreatefrompng($i.".png");
}

imagecopy($img, $d[$a1],  0, 0, 0, 0, 13, 23);
imagecopy($img, $d[$a2], 13, 0, 0, 0, 13, 23);
imagecopy($img, $d[$a3], 26, 0, 0, 0, 13, 23);
imagecopy($img, $d[$a4], 39, 0, 0, 0, 13, 23);
imagecopy($img, $d[$a5], 52, 0, 0, 0, 13, 23);
imagepng($img);
imagedestroy($img);
for ($i=0;$i<=9;$i++){
  imagedestroy($d[$i]);
}
?>
