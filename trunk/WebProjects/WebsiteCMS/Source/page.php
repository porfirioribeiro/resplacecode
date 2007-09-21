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
		$this->title="A module!";
		parent::Module($page);
	}
	function content(){
		?>
		This is a module, a module is a function with some defined content and a defined title that is then applyed to the websites theme, all the module code is sorted out for you. All you need to worry about is the content.<br /><br />Modules can easily be hidden from view by a user, simply click the \/ and /\ (arrows) to hide and show a modules. Modules can also be set to be hidden on default, so the user only expands the module if he/she is interested.<br /><br />Modules can be created within the webpage code, or if the module is going to be quite big or you want it to appear in many pages, you can place it in an external file which is then called into the page(s) you desire it to appear in. This offers more flexibility to you, the web master!
		<?php
	}
}

function someContent($mod){
	?>
	Below is a table that is skinned according to the themes specifications, tables are very useful for displaying and organising data. <a href='#'>A link</a>.<br /><br />
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
}
function top($mod){
	?>
	This is the website, we hope you like it!
	<?php
}
function bop($mod){
	?>
	Thanks for scrolling down to the bottom of the website, you can now go back to the top.
	<?php
}
$page->add("internalHtml");
$page->addF("top","on da top",Module::TOP);
$page->addF("bop","on da bott",Module::BOTTOM);
$page->add("SkinChanger",Module::RIGHT);
//$page->add("Lfp");
//$page->add("Box");
$page->addF("someContent","This is a module");


$AbsRootPath=preg_replace("/\\\/","/",dirname(__FILE__));
$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);
//$page->addS($_SERVER['SERVER_ADMIN'].$_SERVER['HTTP_HOST'],"With string method");
$page->create();
?>
