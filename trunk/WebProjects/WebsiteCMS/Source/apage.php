<?php
//Set path to the data/ directory FIRST:
$path="data/";
include_once $path.'site.php';
$page=new WebMS($path,"Main Site");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

class internalHtml extends Module {
	function internalHtml($page){
		$this->title="Class method";
		parent::Module($page);
	}
	function content(){
		?>
		Testing the creation of a module using the more complicated class method.		
		<?php
	}
}

function someContent($mod){
	?>
	Testing the creation of a module using the create function method.
	<?php
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::RIGHT);
$page->add("Lfp");
$page->add("Box");
//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"Create function method");
$page->create();
?>
