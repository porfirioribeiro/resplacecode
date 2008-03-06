<?php
include "mime-type.php";

$mimes=new Mimes();
$mimes->addMime("txt.png",true,".txt","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("log.png",true,".log","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("binary.png",false,".bin","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("cdimage.png",false,".iso,.cdr","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("cdtrack.png",false,".???","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("database.png",true,".sql","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("deb.png",false,".deb","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("exec_wine.png",false,".exe,.dll","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("font_truetype.png",false,".ttf","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("font_type1.png",false,".fon","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("html.png",true,".html,.htm,.xhtml","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("image.png",false,".bmp,.png,.jpg,.jpeg","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("info.png",false,".nfo","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("midi.png",false,".midi","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("pdf.png",false,".pdf","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("postscript.png",false,".ps","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("quicktime.png",false,".mov","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("rpm.png",false,".rpm","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("rtf.png",false,".rtf","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("shellscript.png",true,".sh,.bat","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("sound.png",false,".wav,.ogg,.mp3,.wma","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("source_c.png",true,".c","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("source_cpp.png",true,".c++,.cpp,.cxx","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("source_f.png",true,".f","16x16,22x22,32x32,48x48,64x64,128x128");
$mimes->addMime("source_h.png",true,".h,.bi","16x16,22x22,32x32,48x48,64x64,128x128");

$ext=".h";
?>
16  <img src="<?=$mimes->getFileByExt($ext,'16x16')?>"><br>
22  <img src="<?=$mimes->getFileByExt($ext,'22x22')?>"><br>
32  <img src="<?=$mimes->getFileByExt($ext,'32x32')?>"><br>
48  <img src="<?=$mimes->getFileByExt($ext,'48x48')?>"><br>
64  <img src="<?=$mimes->getFileByExt($ext,'64x64')?>"><br>
128 <img src="<?=$mimes->getFileByExt($ext,'128x128')?>"><br>


<br>
