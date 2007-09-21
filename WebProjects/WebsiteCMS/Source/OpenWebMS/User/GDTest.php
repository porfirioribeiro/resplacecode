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
$path="../";
include_once $path.'WebMS.php';

//Setup the WebMS class
$page=new WebMS($path,"Main Site");
//add some meta keywords
$page->addMeta(array('name' => 'keywords','content' => 'register,free'));
//add defaults
$page->addDefaults();

//begin adding modules...
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	?>
	Registering to our website enables you to access more content, get the latest information and interact with other website users. So register today!<br><br>
	
	
	    <b>Varification:</b><br>
        <div class="smalltext">Please look at the picture, then look at the text in the red box, do you see all those letters in the image, are they clear enough to read?. <br>
          <br>
        </div>
		<br><br>
		<?php
		$b=new GDLib(110,40);
		$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
		//random font generation
		$fnts=array("Eunjin","Bangwool","Tuffy","UnPen","Bandal","FreeMonoBold","punk kid");
		$b->Captcha($fnts);
		$file=$b->out(true);
		?>
		<img src='<?=$file; ?>' border='0' alt='test' title='test' />
		<br><br>
		<div style="width:200px; background-color:#FF0000; color:#000000"><b>
		<?php
		echo $_SESSION['captcha_string'];
		?>
		</b></div>

	<?php
}

$page->add("SkinChanger",Module::RIGHT);
//$page->add("Box");
$page->addF("someContent","Register to this website");

$page->create();
?>
