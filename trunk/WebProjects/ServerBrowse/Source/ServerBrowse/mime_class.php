<?php
$TYPE_TEXT=0;
$TYPE_IMAGE=1;
$TYPE_BIN=2;
$TYPE_FOL=3;
function findInArray($array,$find){
	return (array_search($find,$array)===false)?false:true;
}
class Mime{
	var $file;
	var $text;
	var $exts;
	var $sizes;
	function Mime($file="unknown.png",$type=2,$exts="",$sizes="16x16,22x22,32x32,48x48,64x64,128x128"){
		$this->file=$file;
		$this->type=$type;
		$this->exts=$exts;
		$this->sizes=$sizes;
	}
	function addExt($ext){
		$this->exts.=",".$ext;
	}
	function addSize($size){
		$this->sizes.=",".$size;
	}
}
class Mimes{
	var $mimes=array();
	function addMime($file="unknown.png",$type=2,$exts="",$sizes="16x16,22x22,32x32,48x48,64x64,128x128"){
		$this->mimes[]=new Mime($file,$type,$exts,$sizes);
	}
	function add($mime){
		$this->mimes[]=$mime;
	}
	function getFileByExt($ext,$size){
		$file="unknown.png";
		foreach($this->mimes as $ind=>$mime){
			$oArray = explode ( ",",$mime->exts);
			if (findInArray($oArray,$ext)!=false){
				$file=$mime->file;
				continue;
			}
		}
		if ($size!="16x16" and $size!="22x22" and $size!="32x32" and $size!="48x48" and $size!="64x64" and $size!="128x128"){
			$size="22x22";
		}
		return $size."/".$file;
	}
}
?>
