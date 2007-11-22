<?php
$file = $_SERVER["PATH_TRANSLATED"];
$exts = split("[/\\.]", strtolower($file)) ;
$ext = $exts[count($exts)-1];

if ($ext=="js" || $ext=="css"){
  //ob_start ("ob_gzhandler");
}


$ext = substr($file,strrpos($file, ".")+1,strlen($file));
ob_start ("ob_gzhandler");
if($ext=="js") $ext="javascript";
header("Content-type: text/".$ext."; charset: UTF-8");
header("Content-Encoding: gzip,deflate");
header("Expires: ".gmdate("D, d M Y H:i:s", time() + (24 * 60 * 60 * 60)) . " GMT");//adiciona 1 dia ao tempo de expiraчуo
header( "ETag: ".dechex( $file_last_modified ) );
header( "Cache-Control: must-revalidate, proxy-revalidate, max-age=" . $max_age . ", s-maxage=" . $max_age );

readfile($file);
?>