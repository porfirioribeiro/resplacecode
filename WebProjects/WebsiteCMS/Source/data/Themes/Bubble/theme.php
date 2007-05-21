<?php
//theme path is already known!!
//$tpath=$this->themespath."Rigid-Blue/";
//echo $this->themespath.$this->selectedskin;
$tpath=$this->themespath.$this->selectedskin;
//include("module.php");
$this->addCSS($tpath."style.css");
$this->addPreloadImg(array(
	$tpath."Images/collapse.png",
	$tpath."Images/collapse_over.png",
	$tpath."Images/minimize_left.png",
	$tpath."Images/minimize_left_over.png",
	$tpath."Images/minimize_right.png",
	$tpath."Images/minimize_right_over.png"
));

$tpl=new TplFile(dirname(__FILE__)."/theme.tpl");
$modTpl=$tpl->get("module");
$this->module_main=$modTpl->get("main");
$this->module_left=$modTpl->get("left");
$this->module_right=$modTpl->get("right");
$this->module_center=$modTpl->get("center");
$this->module_top=$modTpl->get("top");
$this->module_bottom=$modTpl->get("bottom");
$pageTpl=$tpl->get("page");
$this->page_title=$pageTpl->get("title");
$this->page_content=$pageTpl->get("content");
		
?>
