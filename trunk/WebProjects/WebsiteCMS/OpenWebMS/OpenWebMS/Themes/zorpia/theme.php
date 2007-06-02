<?php
//theme path is already known!!
//$tpath=$this->themespath."Rigid-Blue/";
//echo $this->themespath.$this->selectedskin;
$tpath=$this->themespath.$this->selectedskin;
//include("module.php");
$this->addCSS($tpath."style.css");
$arr=explode("/",$this->selectedskin);
$this->addJS($this->themespath.$arr[0]."/theme.js");
$this->addPreloadImg(array(
	$tpath."Images/collapse.png",
	$tpath."Images/collapse_over.png",
	$tpath."Images/minimize_left.png",
	$tpath."Images/minimize_left_over.png",
	$tpath."Images/minimize_right.png",
	$tpath."Images/minimize_right_over.png"
));

$tpl=new TplFile(dirname(__FILE__)."/theme.tpl");
$this->moduleTpl=$tpl->get("module");
$this->pageTpl=$tpl->get("page");
if ($tpl->isPart("menu")){
	$this->menuTpl=$tpl->get("menu");
}

		
?>
