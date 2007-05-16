<?php
$AbsRootPath=preg_replace("/data(\/|\\\)setup.php/","",__FILE__);
$AbsRootPath=preg_replace("/\\\/","/",$AbsRootPath);
$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);
$AbsDataPath=$AbsRootPath."data/";
$DataPath=$RootPath."data/";
$AbsUploadPath=$AbsDataPath."Files/";
$UploadPath=$DataPath."Files/";
if (isset($this)){
	$this->AbsRootPath=$AbsRootPath;
	$this->RootPath=$RootPath;
	$this->AbsDataPath=$AbsDataPath;
	$this->DataPath=$DataPath;
	$this->AbsUploadPath=$AbsUploadPath;
	$this->UploadPath=$UploadPath;
}
?>
