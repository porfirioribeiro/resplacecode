<?php
global $WebMS;
$tpath=$WebMS["ThemesUrl"].$this->selectedskin;
$this->addCSS($tpath."style.css");
$this->addJS("theme.js");

//$this->addPreloadImg(array());

$tpl=new TplFile(dirname(__FILE__)."/theme.tpl");
$this->moduleTpl=$tpl->get("module");
$this->pageTpl=$tpl->get("page");
if ($tpl->isPart("menu")){
	$this->menuTpl=$tpl->get("menu");
}

		
?>
