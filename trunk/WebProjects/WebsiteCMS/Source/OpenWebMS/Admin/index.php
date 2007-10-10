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

$page=new WebMS("OpenWebMS/","Admin Panel");

//read all the admin modules/functions and panes
$page->addFunctionSearchPath($WebMS['AdminPath']."Functions/");
$page->addModuleSearchPath($WebMS['AdminPath']."Modules/");
$page->addModuleSearchPath($WebMS['AdminPath']."AdminPanes/");
$page->addJS("edit_area/edit_area_full.js");
$page->addJSCode("
function editAreaSaveHandler(){
	$('EditAreaSubmit').click();
}
");
$page->addOnLoad("
if ($('use_php')){
	editAreaLoader.init({
		id: \"use_php\"	// id of the textarea to transform
		,start_highlight: true	// if start with highlight
		,allow_resize: \"both\"
		,allow_toggle: true
		,language: \"en\"
		,syntax: \"php\"
		,save_callback:\"editAreaSaveHandler\"
		,plugins:\"charmap,syntax_selection\"
		,toolbar:\" save, |,syntax_selection, charmap, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight,fullscreen, |, help\",
		syntax_selection_allow:\"php,js,css,html\"
	});
}
if ($('use_none')){
	editAreaLoader.init({
		id: \"use_php\"	// id of the textarea to transform
		,start_highlight: true	// if start with highlight
		,allow_resize: \"both\"
		,allow_toggle: true
		,language: \"en\"
		,syntax: \"none\"
		,save_callback:\"editAreaSaveHandler\"
		,plugins:\"charmap,syntax_selection\"
		,toolbar:\" save, |,syntax_selection, charmap, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight,fullscreen, |, help\",
		syntax_selection_allow:\"php,js,css,html\"
	});
}");

if (isset($_GET["message"])){
	$page->addAlert("dbmesage",$_GET["message"]);
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
			global $path, $devmode, $WebMS, $reason, $logintype;
			//set the admin password
			
			if ($logintype==1) {
				//integrated logon box here
			} else if ($logintype==2) {
				//Super admin login
				?>
				Welcome to the admin panel, please login below using the super admin password:<br>
				<i>Default password is documented in the readme.txt document, this password should be changed immediately after you first login.</i><br><br>
	
				<form action="<?=$_SERVER['PHP_SELF']; ?>?Admin" method="post">
					<input name="psswd" type="password" />
					<input name="submit" type="submit" value="Login" />
				</form><br><br>
				<?php
			}
			
			?><br><br>
			Error Details Below:<br>
			<?php
			echo $reason;
		}
	}
	
	$page->add("internalHtml");
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
	
	$page->add("internalHtml");
	$page->create();
	exit();
}

//load the administration panes before we enter the class
//so we can access this variable outside the class ;)
$adminpanes=array();
$adminpanes=GetFiles("OpenWebMS/Admin/AdminPanes");

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
			<a href="index.php?Admin">Summary</a><br>
			<a href="index.php?Admin.VersionHistory">Version History</a><br>
			<a href="index.php?Admin.Updates">Updates</a><br>
		</div>
		<br>
		<b>Management:</b>
		<div style="padding-left:8px;">
			<? //<a href="?manage=menu">Menu</a><br>
			?>
			<a href="index.php?Admin.PagesManage">Web pages</a> <br>
			<div style="padding-left:8px;">
				<a href="index.php?Admin.Files">Files</a>
			</div>
			<a href="index.php?Admin.db">Database's</a> <br>
			<a href="index.php?Admin.ModulesManage">Modules</a> <br>
			<a href="index.php?Admin.FunctionsManage">Functions</a> <br>
			<a href="index.php?Admin.LManager">Layouts</a> <br>
		</div>
		<br>
		<b>Configuration:</b>
		<div style="padding-left:8px;">
			<a href="index.php?Admin.FeaturesAndOptions">Features &amp; Options</a><br>
			<a href="index.php?Admin.ThemesAndLayout">Themes &amp; Layout</a><br>
			<?php
			/*
			integration will be tough to get right... first we must make sure its totally adaptable for integrating whatever system is required, such as IPB SMF or etc.
			We must then allow some way for unique settings to be set within the integration options, this would include ie. SMF SSI path.
			Ofcourse the "self integrated" code will be far different from the integrate methods, so my idea is that this is BUILT INTO this system and does not use an integration template like others do, this will make the task much easyer...
			And allow our "self integration" to be more powerful and easyer to code, understand and modify :)

			Hope you understand and agree :)

			So recap:
			1) Some way to add settings to integrate settings page.
			2) Common classes for certain tasks such as fetch a user, check if someones signed in, link to sign in/register page (since we assume what we integrate too controls user registration etc), fetch user avatar, check if user is admin, fetch user id.

			Problems:
			Some integrations might not support some things, such as user avatars (may implement a function or may not, discuss??)
			and i forsee other problems, I hope we can allow integration for atleast a few systems :p

			thankfully integrating SMF will be easyer than asking a girl on a date ;) Hope others are similar (have no idea)
			*/
			?>
		</div>
		<br>
		<b>Panes:</b>
		<div style="padding-left:8px;">
			<?php
			
			if (count($adminpanes)) {
				foreach ($adminpanes as $fil) {

					$name=explode('.',$fil);
					if ($name[1]=='php') {
						echo'<a href="index.php?Admin.Panes.'.$name[0].'">'.$name[0].'</a> <br>';
						}
					}
				}

			?>
		</div>
		<br>
		<b>Misc:</b>
		<div style="padding-left:8px;">
			<a href="?Admin&devMODE<?=$this->page->devMode?"&amp;message=You just disabled Debug Mode.":""?>"><?=$this->page->devMode?"Disable Debug Mode":"Enable Debug Mode"?></a><br><br>
			<a href="?Admin.ErrorLog">View Error Log</a><br>
			<a href="?">View Site</a><br>
			<br>
		</div>

		<?php


	}
}

//Hide admin menu function, no implementation yet.
if (isset($_GET['menu']) && $_GET['menu']=='hide') {}else{
	$page->add("AdminMenu2",Module::LEFT);
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


if (defined("URL_PART_2")){
	if (defined("URL_PART_3") && URL_PART_2=="Panes"){
		if (is_file("OpenWebMS/Admin/AdminPanes/".URL_PART_3.".php")){
			include "OpenWebMS/Admin/AdminPanes/".URL_PART_3.".php";
		}else{
			$page->addS("The Specified Pane ( ".URL_PART_3." ) does not exists","ERROR!");
		}
	}else{
		if (is_file("OpenWebMS/Admin/Modules/".URL_PART_2.".php")){
			include("OpenWebMS/Admin/Modules/".URL_PART_2.".php");
		}else{
			$page->addS("Cant navigate to  ".URL_PART_2." , it does not exists","ERROR!");
		}
	}
}else{
	$page->add("welcome",Module::CENTER);
}


/*
if (isset($_REQUEST['nav'])) {
	$nav=$_REQUEST['nav'];
}

//built in pages
if (!isset($_REQUEST['nav'])) {
	if (!isset($_REQUEST['pane']))
		$page->add("welcome",Module::CENTER);
} else {
	if ($_REQUEST['nav']=="VersionHistory")
		$page->add("VersionHistory");
		
	if ($_REQUEST['nav']=="Updates")
		$page->add("Updates");
		
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

$page->create();
?>
