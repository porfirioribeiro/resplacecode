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
	//get text size for creating the image size later
	/*
	$br=new GDCanvas(6,6);
	$br->SetFontTTF("Halo.ttf");
	$br->SetFontSize(100);
	$siz=$br->TextTTFBox(0, "GD TEST :)");
	print_r($siz);
	$g=new GDCanvas($siz[0],$siz[1]);
	
	$g->SetFontTTF("Halo.ttf");
	$g->SetFontSize(100);
	$g->AddTextTTF(0,0-$siz[2],$siz[1]-$siz[3],'#EF0000',"GD TEST :)");
	$g->out("test.png");
	?>
	<img src='test.png' border='0' alt='test' title='test' />
	<?php
	*/
	//this is the brush
	$bru=new GDLib(5,5);
	$bru->SetColor('#FFFFFF','draw'); $bru->SetColor('#91C846','fill');
	$bru->Ellipse(2,2,5,5);
	$file=$bru->out(true);
		echo $file;
	//$br->out();
	
	
	
	$b=new GDLib(100,60);
		$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
		$b->Captcha();
		$file=$b->out(true);
		?>
		<img src='<?=$file; ?>' border='0' alt='test' title='test' />
		<?php
	
	$br=new GDLib($textdim[0],$textdim[1],true);
	$check=$br->CheckCache();
	if (!is_array($check)) {
		echo' TEST ';
		$br->CreateStyle('Big','Eunjin',50,'#85BF7D','#F0F0F0');
		$br->CreateText(0,0-$textdim[2],$textdim[1]-$textdim[3]-10,'resplace.net');
		$br->fontSize=10;
		$br->CreateText(0,0-$textdim[2]+120,$textdim[1]-$textdim[3]+2,'All your resource are belong to us!');
		
		imagesetbrush($br->image,$bru->image);
		imagesettile($br->image,$bru->image);
		$br->CreateStyle('Big','Eunjin',70,'#0000BB','#7BB1E1');
		$br->Rect(10,10,80,80,IMG_COLOR_TILED);
		$file=$br->out(true);
	} else {
		$file=$check[0];
	}
		echo $file;
		//echo preg_replace('/[^a-zA-Z0-9]/i','z',$br->imagehash);
		?>
		<img src='<?=$file; ?>' border='0' alt='test' title='test' />
		<?php
		
	$br2=new GDLib($textdim[0],$textdim[1]);
		$br2->CreateStyle('Big','Eunjin',50,'#BB','#F0F0F0');
		$br2->CreateText(0,0-$textdim[2],$textdim[1]-$textdim[3]-10,'Porf�rio!');
		$br2->fontSize=10;
		$br2->CreateText(0,0-$textdim[2]+120,$textdim[1]-$textdim[3]+2,'All your resource are belong to us!');
		$file=$br2->out(true);
		echo $file;
		//echo preg_replace('/[^a-zA-Z0-9]/i','z',$br->imagehash);
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