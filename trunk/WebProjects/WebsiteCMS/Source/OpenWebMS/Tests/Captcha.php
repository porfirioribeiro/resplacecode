<?php
/**
* Register a new user account
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 05-07-07
*/
//Set path then include the system into the page.
$path="../";
include_once $path.'WebMS.php';

//Setup the WebMS class
$page=new WebMS("Main Site");
//add some meta keywords
$page->addMeta(array('name' => 'keywords','content' => 'register,free'));
//add defaults
$page->addDefaults();

//begin adding modules...
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	global $WebMS;

	if (isset($_POST["string"])) {
		if (strcmp(strtoupper($_POST["string"]),$_SESSION["captcha_string"])==0) {
			echo'<b>Validation passed!</b><br><br>';
		} else {
			echo'<b style="color:red">Validation failed!</b><br><br>';
		}
	}

	?>
	<form method="POST" action="<?=$_SERVER['PHP_SELF']; ?>">
	<b>Varification:</b><br>
	<div class="smalltext">Type whats shown in the picture. <br>
	<br>
	<?php
	$b=new GDLib(145,40);
	$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
	$no="";
	$fnts=array("Eunjin","Bangwool","Tuffy","UnPen","Bandal","FreeMonoBold");

	$b->Captcha($fnts);
	$file=$b->out(true);
	//echo $_SESSION['captcha_string'];
	?>
	<img src='<?=$file; ?>' border='0' alt='test' title='test' />
	<br>
	<input type="text" name="string" maxlength="10">
					<input type="submit" value="submit" name="submit">
	</form>
	<?php


}

$page->add("SkinChanger",Module::RIGHT);

$page->addF("someContent","Register to this website");

$page->create();

?>
