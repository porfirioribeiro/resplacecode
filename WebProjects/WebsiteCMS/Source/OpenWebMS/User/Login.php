<?php
/**
* Login to a user account
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 05-07-07
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
	global $WebMS;

	if ($WebMS["Integrate"]) {
		err("Integration is enabled, this system is diactivated.");
		return false;
		exit;
	}
	
	if (!$WebMS["MySQL_Use"]){
		err("MySQL is disabled, this system requires MySQL.");
		return false;
		exit;
	}

		if ((!isset($_POST["submit"])) || (submit())) {
			?>
			Please login to your account below:<br>
			Are you <a href="Register.php" target="_blank">registered</a>?<br><br>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']; ?>">
				<table width="100%" border="0" cellspacing="0" cellpadding="2">
				  <tr valign="top">
					<td><b>Username:</b><br>
				    </td>
					<td><label>
					  <input type="text" name="username" value="<?=isset($_POST["username"]) ? $_POST["username"]:"" ?>" maxlength="48">
					</label></td>
				  </tr>
				  <tr valign="top">
					<td><b>Password:</b><br>
				      <br>
			        <br></td>
					<td><input type="password" name="password" maxlength="48"></td>
				  </tr>
				  <tr valign="top">
				    <td><b>Varification:</b><br>
			        <div class="smalltext">Type whats shown in the picture. <br>
			          <br>
			        </div>
					</td>
				    <td>
					<?php
					$b=new GDLib(145,40,null,false);
					$b->CreateStyle('Big','Eunjin',70,'#0000BB','#85BF7D');
					$no="";
					$fnts=array("Eunjin","Bangwool","Tuffy","UnPen","Bandal","FreeMonoBold","punk kid");
					$fntcols=array("#8F0000","#8F5E08","#3A5F00","#00348F","#51099F","#85008F");

					$b->Captcha(null);
					$file=$b->out(true);
					//echo $_SESSION['captcha_string'];
					?>
					<img src='<?=$file; ?>' border='0' alt='test' title='test' />
					<br />
				    <input type="text" name="string" maxlength="10"></td></tr>
				</table>
				<input type="submit" value="submit" name="submit">
			</form>
			<?php
		} else {

		}
	}

function submit() {
	global $WebMS, $page;

	//check captcha!
	if (strcmp(strtoupper($_POST["string"]),$_SESSION["captcha_string"])==0) {

		//check username
		$db= new sql();
		$result=$db->query("SELECT * FROM ".$WebMS["MySQL_Prefix"]."users WHERE usrname='".$_POST["username"]."' ",true);

		if (!count($result)) {
			err('There is no user registered with this username!');
			return true;
		} else if (!$result[0]['activate']=="1") {
			err('You need to activate your account by clicking the activate link in the email we sent you before you can login!<br>Missed your activation email?');
			return true;
		} else {
			//check passwords

			if ((strcmp(md5($_POST["password"]),$result['0']['psswrd'])==0)) {
				//check password chrs
				echo'You have successfully logged into your account, please enjoy your visit!';
				$_SESSION['username']=$result['0']["usrname"];
				$_SESSION['psswrd']=$result['0']["psswrd"];
				
			} else {
				err('The password you provided is not correct.'.md5($_POST["password"]).' '.$result['0']['psswrd']);
				return true;
			}
		}
	} else {
		err('Captcha was invalid!');
		return true;
	}

}

$page->add("SkinChanger",Module::RIGHT);

$page->addF("someContent","Register to this website");

$page->create();

//check email address function
//thanks to: http://www.ilovejackdaniels.com/php/email-address-validation/
function check_email($email) {
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

//Error handler
//Small error wrapper for form submits (possible internal class for this sort of function?)
function err($errtxt) {
	echo"<div class='ErrorBox'><b>Error:</b><br>$errtxt</div><br>";
}
?>
