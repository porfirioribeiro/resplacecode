<?php
//theme path is already known!!
//$tpath=$this->themespath."Rigid-Blue/";
//echo $this->themespath.$this->selectedskin;
$tpath=$this->themespath.$this->selectedskin;
//include("module.php");
$this->addCSS($tpath."style.css");

$this->addJS("theme.js");

$this->addPreloadImg(array(
	$tpath."Images/collapse.png",
	$tpath."Images/uncollapse.png",
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
