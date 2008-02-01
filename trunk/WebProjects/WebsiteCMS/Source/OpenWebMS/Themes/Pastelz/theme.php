<?php
//theme path is already known!!
//$tpath=$this->themespath."Rigid-Blue/";
//echo $this->themespath.$this->selectedskin;
$tpath=$WebMS["ThemesUrl"].$this->selectedskin;
//include("module.php");
$this->addCSS($tpath."style.css");
//Include a custom theme.js (from our theme directory)
	//$arr=explode("/",$this->selectedskin);
	//$this->addJS($this->themespath.$arr[0]."/theme.js");
//** We can now use the "default" one from Core/JS **
$this->addJS("theme.js");

$this->addPreloadImg(array(
	$tpath."Images/collapse.png",
	$tpath."Images/collapse_over.png",
	$tpath."Images/close.png",
	$tpath."Images/close_over.png"
));

$tpl=new TplFile(dirname(__FILE__)."/theme.tpl");
$this->moduleTpl=$tpl->get("module");
$this->pageTpl=$tpl->get("page");
if ($tpl->isPart("menu")){
	$this->menuTpl=$tpl->get("menu");
}

		
?>
