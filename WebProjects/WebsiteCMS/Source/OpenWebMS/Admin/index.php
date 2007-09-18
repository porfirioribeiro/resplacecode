<?php
/**
* Admin Panel
* A means for manipulating OpenWebMS
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 09-09-07
*/

//Set path to the data/ directory FIRST:
$path="../";
$stopadmin=false;
include_once $path.'WebMS.php';
$page=new WebMS($path,"Admin Panel");

//read all the admin modules/functions and panes
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
$page->addModuleSearchPath("AdminPanes/");
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
$page->addDefaults();
if (isset($_GET["message"])){
	$page->addAlert("dbmesage",$_GET["message"]);
}

//check if we can use internel or integrated systems to handle login.
if ($WebMS["Integrate"]==false){
	
	$addd=false;
	if ($WebMS["MySQL_Use"]){
		$db= new sql();
		$result=$db->query("SELECT * FROM ".$WebMS["MySQL_Prefix"]."users WHERE usrlvl='2'",true);
		$db->disconnect();
		
		if (count($result)) {
			//there are administrators
			$addd=true;
		}
		
	}
	
	if ($WebMS["MySQL_Use"]==false || $addd==false){
		//use super admin routine for access to admin panel.
		
		$db=new ResDB("WebMSoptions");
		$psswd=$db->get("adminpassword");

		if (isset($_POST['psswd'])){
			$_SESSION['admin_session']=md5($_POST['psswd']);
		}

		if (!isset($_SESSION['admin_session']) || $_SESSION['admin_session']!=$psswd){
			class internalHtml extends Module {
				function internalHtml($page){
					$this->title="Admin Panel";
					parent::Module($page);
				}
				function content(){
					global $path, $devmode;
					//set the admin password
					
					if ($WebMS["MySQL_Use"]==false){
						$stringq="You are running non-integrated mode and MySQL is disabled.";
					}
					if ($ddd==false){
						$stringq="There are no administrators set in the non-integrated user database.";
					}
					
					?>
					Welcome to the admin panel, please login below using the super admin password:<br>
					<i>Default password is documented in the readme.txt document, this password should be changed immediately after you first login.</i><br><br>
		
					<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
						<input name="psswd" type="password" />
						<input name="submit" type="submit" value="Login" />
					</form><br><br>
					The reason you have to use the super admin password is outlined below:<br>
					- <?=$stringq?>
					<?php
				}
			}
			
			$page->add("internalHtml");
			$page->create();
			exit();
		}		
	} else {
		//non-integrated method, admin exists...
		if (!$WebMS["User_Userlvl"]==2) {
			$stopadmin=true;
			$reason='Please <a href="'.$WebMS["WebMSUrl"].'User/Login.php">login as an administrator</a> to access this admin panel.';
		}
	}
} else {
	//integrated method, assume an admin exists (cant check)
	if (!$WebMS["User_Userlvl"]==2) {
			$stopadmin=true;
			$reason='Please login as an administrator on the integrated software to access this admin panel.';
		}
}

//stop admin entry...
if ($stopadmin==true){
	class internalHtml extends Module {
		function internalHtml($page){
			$this->title="Admin Panel";
			parent::Module($page);
		}
		function content(){
			global $path, $devmode,$reason;
			?>
			I'm sorry but the administration panel is off limits to you because of the following reason:<br><br>
			<?php
			echo '<b>- '.$reason.'</b>';
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
$adminpanes=GetFiles("AdminPanes");

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
			<a href="index.php">Summary</a><br>
			<a href="index.php?nav=VersionHistory">Version History</a><br>
			<a href="index.php?nav=Updates">Updates</a><br>
		</div>
		<br>
		<b>Management:</b>
		<div style="padding-left:8px;">
			<? //<a href="?manage=menu">Menu</a><br>
			?>
			<a href="?nav=PagesManage">Web pages</a> <br>
			<div style="padding-left:8px;">
				<a href="?nav=Files">Files</a>
			</div>
			<a href="?nav=db">Database's</a> <br>
			<a href="?nav=ModulesManage">Modules</a> <br>
			<a href="?nav=FunctionsManage">Functions</a> <br>
			<a href="?nav=LManager">Layouts</a> <br>
		</div>
		<br>
		<b>Configuration:</b>
		<div style="padding-left:8px;">
			<a href="index.php?nav=FeaturesAndOptions">Features &amp; Options</a><br>
			<a href="index.php?nav=ThemesAndLayout">Themes &amp; Layout</a><br>
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
						echo'<a href="?pane='.$name[0].'">'.$name[0].'</a> <br>';
						}
					}
				}

			?>
		</div>
		<br>
		<b>Misc:</b>
		<div style="padding-left:8px;">
			<a href="?devMODE<?=$this->page->devMode?"&amp;message=You just disabled Debug Mode.":""?>"><?=$this->page->devMode?"Disable Debug Mode":"Enable Debug Mode"?></a><br><br>
			<a href="?nav=ErrorLog">View Error Log</a><br>
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
class VersionHistory extends Module {
	function VersionHistory($page){
		$this->side=Module::CENTER;
		$this->title="Version History";
		parent::Module($page);
	}
	function content(){
		global $WebMS;
		?>
		Version History is obtained from resplace.net servers, if it does not appear below then please try again later.<br><br>
		<div style="padding:10px;">
		<?php

		// get the host name and url path
		$parsedUrl = parse_url("http://resplace.net/WebMS/VersionHistory.php?verid=".$WebMS['Version']);
		$host = $parsedUrl['host'];
		if (isset($parsedUrl['path'])) {
			$path = $parsedUrl['path'];
		} else {
			// the url is pointing to the host like http://www.mysite.com
			$path = '/';
		}

		if (isset($parsedUrl['query'])) {
			$path .= '?' . $parsedUrl['query'];
		}

		if (isset($parsedUrl['port'])) {
			$port = $parsedUrl['port'];
		} else {
			// most sites use port 80
			$port = '80';
			}

			$timeout = 10;
			$response = '';

			// connect to the remote server
			$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

			if( !$fp ) {
				echo "Cannot retrieve $url";
			} else {
				// send the necessary headers to get the file
				fputs($fp, "GET $path HTTP/1.0\r\n" .
				"Host: $host\r\n" .
				"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
				"Accept: */*\r\n" .
				"Accept-Language: en-us,en;q=0.5\r\n" .
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
				"Keep-Alive: 300\r\n" .
				"Connection: keep-alive\r\n" .
				"Referer: http://$host\r\n\r\n");

				// retrieve the response from the remote server
				while ( $line = fread( $fp, 4096 ) ) {
				$response .= $line;
			}

			fclose( $fp );

			// strip the headers
			$pos      = strpos($response, "\r\n\r\n");
			$response = substr($response, $pos + 4);

			echo $response;
		}
		echo'</div>';
	}
}
//version update module!
class Updates extends Module {
	function Updates($page){
		$this->side=Module::CENTER;
		$this->title="OpenWebMS Updates";
		parent::Module($page);
	}
	function content(){
		global $WebMS;
		?>
		Your copy of OpenWebMS will now contact resplace.net and check if there are any updates, if it does not appear below then please try again later.<br><br>
		<div style="padding:10px;">
		<?php

		// get the host name and url path
		$parsedUrl = parse_url("http://resplace.net/WebMS/Updates.php?verid=".$WebMS['Version']);
		$host = $parsedUrl['host'];
		if (isset($parsedUrl['path'])) {
			$path = $parsedUrl['path'];
		} else {
			// the url is pointing to the host like http://www.mysite.com
			$path = '/';
		}

		if (isset($parsedUrl['query'])) {
			$path .= '?' . $parsedUrl['query'];
		}

		if (isset($parsedUrl['port'])) {
			$port = $parsedUrl['port'];
		} else {
			// most sites use port 80
			$port = '80';
			}

			$timeout = 10;
			$response = '';

			// connect to the remote server
			$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

			if( !$fp ) {
				echo "Cannot retrieve $url";
			} else {
				// send the necessary headers to get the file
				fputs($fp, "GET $path HTTP/1.0\r\n" .
				"Host: $host\r\n" .
				"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
				"Accept: */*\r\n" .
				"Accept-Language: en-us,en;q=0.5\r\n" .
				"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
				"Keep-Alive: 300\r\n" .
				"Connection: keep-alive\r\n" .
				"Referer: http://$host\r\n\r\n");

				// retrieve the response from the remote server
				while ( $line = fread( $fp, 4096 ) ) {
				$response .= $line;
			}

			fclose( $fp );

			// strip the headers
			$pos      = strpos($response, "\r\n\r\n");
			$response = substr($response, $pos + 4);

			echo $response;
		}
		echo'</div>';
	}
}





$nav='';
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
	$files=GetFiles("Modules");
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

/**
 * Create the page :)
 * 
 */

$page->create();
?>
