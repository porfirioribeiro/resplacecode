<?php
//Set path to the data/ directory FIRST:
$path="OpenWebMS/";
include_once $path.'WebMS.php';
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
		<!--APPLET code="javazoom.jlGui.TinyPlayer" archive="data/lib/tinyplayer/tinyplayer.jar,data/lib/tinyplayer/jl020.jar" 
		width="59" height="32" name="playerid"> 
		<param name="skin" value="data/lib/tinyplayer/skins/Deep">
		<param name="bgcolor" value="638182">
		<param name="autoplay" value="yes">
		<param name="audioURL" value="data/lib/tinyplayer/sound.mp3">
		<param name="scriptable" value="true">
		</APPLET--> 
		Testing the creation of a module using the more complicated class method.		
		<div style="border: 1px solid black;">
		<?=$this->page->title?>
		</div>
		<?php
	}
}

function someContent($mod){
	?>
	this is a module, with a <a href='#'>link</a>.<br /><br />
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
	Some content on top ;)
	<?php
}
$page->add("internalHtml");
$page->addF("top","on da top",Module::TOP);
$page->add("SkinChanger",Module::RIGHT);
$page->add("Lfp");
//$page->add("Box");
$page->addF("someContent","Create function method");


$AbsRootPath=preg_replace("/\\\/","/",dirname(__FILE__));
$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);
$page->addS($_SERVER['SERVER_ADMIN'].$_SERVER['HTTP_HOST'],"With string method");
$page->create();
?>
