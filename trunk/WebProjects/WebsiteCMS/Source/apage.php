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
	this is a module, with a <a href='#'>link</a>.<br /><br />
	<table border='1' cellpadding="3" cellspacing="0">
		<tr>
			<td colspan="2" class="main">Main Table Title</td>
		</tr>
		<tr>
			<td class="sub">Sub Table Title #1</td>
			<td class="sub">Sub Table Title #2</td>
		</tr>
		<tr>
			<td>Content #1</td>
			<td>Content #2</td>
		</tr>
	</table>
	<?php
}
$page->add("internalHtml");
$page->add("SkinChanger",Module::RIGHT);
$page->add("Lfp");
$page->add("Box");
//o.O a bug!! NOTE: look at output title?!?!
$page->addF("someContent","Create function method");
$page->addS("This is just a module added by a string ;)","With string method");
$page->create();
?>