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
	
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	  <tr valign="top">
		<td><b>Choose username:</b><br>
		<div class="smalltext">Used for identification.<br>
		  <br>
		</div>
	    </td>
		<td><label>
		  <input type="text" name="textfield">
		</label></td>
	  </tr>
	  <tr valign="top">
		<td><b>Email:</b><br>
	    <div class="smalltext">Required for activation.<br>
	      <br>
	    </div>
		</td>
		<td><input type="text" name="textfield2"></td>
	  </tr>
	  <tr valign="top">
		<td><b>Choose password:</b><br>
	      <br>
        <br></td>
		<td><input type="text" name="textfield3"></td>
	  </tr>
	  <tr valign="top">
	    <td><b>Confirm password:</b><br>
          <br>
        <br></td>
	    <td><input type="text" name="textfield4"></td>
      </tr>
	  <tr valign="top">
	    <td><b>Varification:</b><br>
        <div class="smalltext">Type whats shown in the picture. <br>
          <br>
        </div>
		</td>
	    <td>
		<?php
		$b=new GDLib(145,40);
		$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
		$no="";
		$fnts=array("Eunjin","Bangwool","Tuffy","UnPen","Bandal","FreeMonoBold","punk kid");
		$fntcols=array('#001144','#660066','#551100','#002200','#222200');
		$b->Captcha($no,$fntcols);
		$file=$b->out(true);
		//echo $_SESSION['captcha_string'];
		?>
		<img src='<?=$file; ?>' border='0' alt='test' title='test' />
		<br />
	    <input type="text" name="textfield5"></td></tr>
</table>

	<?php
}

$page->add("SkinChanger",Module::RIGHT);
//$page->add("Box");
$page->addF("someContent","Register to this website");

$page->create();
?>
