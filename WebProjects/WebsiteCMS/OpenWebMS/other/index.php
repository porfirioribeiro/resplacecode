<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Other page");
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

class internalHtml extends Module {
	function internalHtml($page){
		parent::Module($page);
	}
	function content(){
		?>
		Welcome to my website,		
		<?php
	}
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::BOTTOM);
$page->add("Lfp");
$page->add("Box");

$page->create();
?>
