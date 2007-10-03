<?php
/**
* Standalone page test
* Standalone page test
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 06-06-07
*/
//Set path then include the system into the page.
$path="OpenWebMS/";
include_once $path.'WebMS.php';

//Setup the WebMS class
$page=new WebMS($path,"Main Site");
//add some meta keywords
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
//add defaults
$page->addDefaults();

//begin adding modules...
$page->add("Menu");
$page->add("PageRate");

class internalHtml extends Module {
	function internalHtml($page){
		$this->title="Class method";
		parent::Module($page);
	}
	function content(){
		echo $lol;
		?>
		Testing the creation of a module using the more complicated class method.		
		<?php
	}
}

function someContent($mod){
	?>
	this is a module, with a <a href='#'>link</a>.<br><br>
	<table border='1' cellpadding="3" cellspacing="0" class="tbl">
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

	$b=new GDLib(100,60);
		$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
		$b->Captcha();
		$file=$b->out(true);
		?>
		<img src='<?=$file; ?>' border='0' alt='test' title='test' />
		<?php
}
function top($mod){
	?>
	Some content on top ;)
	<?php
}
function bop($mod){
	?>
	Some content on bottom ;)
	<?php
}
$page->add("internalHtml");
$page->addF("top","on da top",Module::TOP);
$page->addF("bop","on da bott",Module::BOTTOM);
$page->add("SkinChanger",Module::RIGHT);
$page->add("Lfp");
//$page->add("Box");
$page->addF("someContent","Create function method");


$AbsRootPath=preg_replace("/\\\/","/",dirname(__FILE__));
$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);
$page->addS($_SERVER['SERVER_ADMIN'].$_SERVER['HTTP_HOST'],"With string method");
$page->create();
?>
