<?php
/**
* Admin Panel
* A means for manipulating OpenWebMS
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 21-09-07
*/


$stopadmin=false;

$page=new WebMS("AutoSys/","Admin Panel");

//read all the admin modules/functions and panes
$page->addFunctionSearchPath($WebMS['AdminPath']."Functions/");
$page->addModuleSearchPath($WebMS['AdminPath']."Modules/");
$page->addModuleSearchPath($WebMS['AdminPath']."AdminPanes/");

//TODO replace this feature perhaps?
//if (isset($_GET["message"])){
//	$page->addAlert("dbmesage",$_GET["message"]);
//}
//<?=$this->page->devMode?"&amp;message=You just disabled Debug Mode.":""? >
if (isset($WebMS['URLArray'][1]) && $WebMS['URLArray'][1]=="DevMode") {
	if ($page->devMode) {
		$page->addAlert("Developer Mode","<b>Developer Mode</b> was just enabled, this is useful for debuging the system and making sure its complient and secure.");
	} else {
		$page->addAlert("Developer Mode","<b>Developer Mode</b> was just disabled.");
	}
}

//check if we can use internel or integrated systems to handle login.
$grantaccess=false;
$reason="An unknown error occured!";
$logintype=0;

//check if we are using integrated!
if ($WebMS['Integrate']) {
	if ($WebMS["User_Userlvl"]==2) {
		$grantaccess=true;
	} else {
		$reason="Please login as an administrator on the integrated software to access this admin panel.";
	}
} else {
	//check if we are using built-in
	if ($WebMS['UMS']) {
		if ($WebMS['MySQL_Use']) {
			if ($WebMS["User_Userlvl"]==2) {
				$grantaccess=true;
			} else {
				$reason="Please <a href='{$WebMS["WebMSUrl"]}User/Login.php'>login as an administrator</a>.";
				$logintype=1;
			}
		} else {
			$reason="UMS is enabled but MySQL is not setup, system needs MySQL.";
			$logintype=2;
		}
	} else {
		$reason="UMS is not enabled.";
		$logintype=2;
	}	
}



//Process some logins
if ($logintype==1) {
	//FIXME
	//maybe not needed
} else if ($logintype==2) {
	//super admin login
	$db=new ResDB("WebMSoptions");
		$psswd=$db->get("adminpassword");
		if ($psswd=="") {
			$psswd=md5($WebMS["FailSafeLogin"]);
		}
	if (isset($_POST['psswd'])){
		$_POST['psswd']=md5($_POST['psswd']);
		$_SESSION['admin_session']=$_POST['psswd'];
	}
	
	if ((isset($_SESSION['admin_session'])) && ($_SESSION['admin_session']==$psswd)) {
		$grantaccess=true;
		$WebMS["User_Userlvl"]=2;
	}
}

//stop admin entry...
if (!$grantaccess){
	
	class internalHtml extends Module {
		function internalHtml($page){
			$this->title="Admin Panel";
			parent::Module($page);
		}
		function content(){
			/*global $path, $devmode, $WebMS, $reason, $logintype;
			//set the admin password
			
			if ($logintype==1) {
				//integrated logon box here
			} else if ($logintype==2) {
				//Super admin login
				?>
				Welcome to the admin panel, please login below using the super admin password:<br>
				<i>Default password is documented in the readme.txt document, this password should be changed immediately after you first login.</i><br><br>
	
				<form action="<?=url(array("*")); ?>" method="post">
					<input name="psswd" type="password" />
					<input name="submit" type="submit" value="Login" />
				</form><br><br>
				<?php
			}
			
			?><br><br>
			Error Details Below:<br>
			<?php

			echo $reason;*/
			
		}
	}
	
	$page->addModule("internalHtml");
	$page->create();
	exit();
	
}

/**
 * FIRST TIME CONFIGURATION
 */
$db=new ResDB("WebMSoptions");
	$firstrun=$db->get("firstrunconfig");
	
if ($firstrun){
	//load first config panel
	class internalHtml extends Module {
		function internalHtml($page){
			$this->title="First time setup wizards";
			parent::Module($page);
		}
		function content(){
			global $path, $devmode,$reason;
			?>
			<br>
			<b>Congratulations on downloading OpenWebMS to your server!</b><br><br>
			The system has recognised this is your first visit to the administration panel, there are some settings you should urgently define so your OpenWebMS runs how you want it to! (and so its secure).
			<br><br>
			<b>Super admin password:</b><br>
			Lets start by changing the Super admin password, this is the password you used to first login to the admin panel, and is required if you do not use the built in (or integrated) User Management System (UMS).<br>
			
			 <?php
		}
	}
	
	$page->addModule("internalHtml");
	$page->create();
	exit();
}

//load the administration panes before we enter the class
//so we can access this variable outside the class ;)
$adminpanes=array();
$adminpanes=GetFiles("AutoSys/Admin/AdminPanes");

/**
 * MAIN ADMINISTRATION PANEL
 * Load the menu medule:
 */
class AdminMenu2 extends Module {
	function AdminMenu2($page){
		$this->side=Module::LEFT;
		$this->title="Admin Menu";
		parent::Module($page);
	}
	function content(){
		global $path, $adminpanes;
		?>
		<b>Main:</b>
		<div style="padding-left:8px;">
			<a href="<?=url(array("*")) ?>">Summary</a><br>
			<a href="<?=url(array("*","VersionHistory")) ?>">Version History</a><br>
			<a href="<?=url(array("*","Updates")) ?>">Updates</a><br>
		</div>
		<br>
		<b>Configuration:</b>
		<div style="padding-left:8px;">
			<a href="<?=url(array("*","ThemesAndLayout")) ?>">Themes &amp; Layout</a><br>
			
		</div>
		<br>
		<b>Misc:</b>
		<div style="padding-left:8px;">
			<a href="<?=url(array("*","DevMode"));?>"><?=$this->page->devMode?"Disable Debug Mode":"Enable Debug Mode"?></a><br><br>
			<a href="<?=url(array("*","ErrorLog"));?>">View Error Log</a><br>
			<br>
		</div>

		<?php


	}
}

//Hide admin menu function, no implementation yet.
if (isset($_GET['menu']) && $_GET['menu']=='hide') {}else{
	$page->addModule("AdminMenu2",null,Module::LEFT);
}

//Welcome to the admin panel module!
class welcome extends Module {
	function welcome($page){
		$this->side=Module::CENTER;
		$this->title="Welcome admin";
		parent::Module($page);
	}
	function content(){
		?>
		Welcome <b>admin</b>, to the WebMS administration panel, this panel should enable you to do what you need to do to the WebMS system. If there is some functionality you believe should be included on this panel or you have some suggestions for improvements then please post at our forums.<br><br>
		Thanks for choosing WebMS to manage your web site content, if you like this system then please consider donating some change so we can keep the project going strong, alternatively if you ar good with PHP then why not help develop the project further?
		<?php
	}
}

//version history module!


//version update module!






$nav='';

//TODO
//echo "page={$WebMS["URLPage"]} sub={$WebMS["URLCat"]}";
if (!$WebMS["URLCat"]==""){
	if ($WebMS["URLCat"]=="Panes"){
		if (is_file("AutoSys/Admin/AdminPanes/".$WebMS["URLArray"][2].".php")){
			include "AutoSys/Admin/AdminPanes/".$WebMS["URLArray"][2].".php";
		}else{
			$page->addModule("The Specified Pane ( ".$WebMS["URLArray"][2]." ) does not exists","ERROR!");
		}
	}else{
		if (is_file("AutoSys/Admin/Modules/".$WebMS["URLCat"].".php")){
			include("AutoSys/Admin/Modules/".$WebMS["URLCat"].".php");
		}else{
			$page->addModule("Cant navigate to  ".$WebMS["URLCat"]." , it does not exists","ERROR!");
		}
	}
}else{
	$page->addModule("welcome",null,Module::CENTER);
}


/*
if (isset($_REQUEST['nav'])) {
	$nav=$_REQUEST['nav'];
}

//built in pages
if (!isset($_REQUEST['nav'])) {
	if (!isset($_REQUEST['pane']))
		$page->addModule("welcome",Module::CENTER);
} else {
	if ($_REQUEST['nav']=="VersionHistory")
		$page->addModule("VersionHistory");
		
	if ($_REQUEST['nav']=="Updates")
		$page->addModule("Updates");
		
	//External Modular admin pages
	$files=GetFiles("OpenWebMS/Admin/Modules");
	if (count($files)) {
		foreach ($files as $fil) {
			$name=explode('.',$fil);
			if ($name[1]=='php') {
				if ($name[0]==$_REQUEST['nav']) {
					include("Modules/".$fil);
				}
			}
		}
	}
}




//Load requested administration panes
if (isset($_REQUEST['pane'])) {
	if (count($adminpanes)) {
		foreach ($adminpanes as $fil) {
			$name=explode('.',$fil);
			if ($name[1]=='php') {
				if ($name[0]==$_REQUEST['pane']) {
					include("AdminPanes/".$fil);
				}
			}
		}
	}
}
*/
/**
 * Create the page :)
 * 
 */

print_r($page);
//$page->create();
?>
