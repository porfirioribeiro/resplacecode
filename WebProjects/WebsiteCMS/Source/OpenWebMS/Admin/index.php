<?php
/**
* Admin Panel
* A means for manipulating OpenWebMS
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 24-06-07
*/
//Set path to the data/ directory FIRST:
$path="../";
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
$db=new ResDB("WebMSoptions");
		//read it
		//$val=$db[1];
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
			
			?>
			Welcome to the admin panel, please login below.<br /><br />
			
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input name="psswd" type="password" />
				<input name="submit" type="submit" value="Login" />
			</form>
			<?php
			}
		}
	$page->add("internalHtml");
	$page->create();
	exit();
	}

//admin menu :)
class AdminMenu2 extends Module {
	function AdminMenu2($page){
		$this->side=Module::LEFT;
		$this->title="Admin Menu";
		parent::Module($page);
	}
	function content(){
		global $path;
		?>
		<b>Main:</b>
		<div style="padding-left:8px;">
			<a href="index.php">Summary</a><br />
			<a href="index.php">Version History</a><br />
			<a href="index.php">Updates</a><br />
		</div>
		<br />
		<b>Management:</b>
		<div style="padding-left:8px;">
			<? //<a href="?manage=menu">Menu</a><br>
			?>
			<a href="?nav=pages">Web pages</a> <a href="?nav=pages&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
			<div style="padding-left:8px;">
				<a href="?nav=files">Files</a> <a href="?nav=files&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a>
			</div>
			<a href="?nav=db">Database's</a> <a href="?nav=db&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
			<a href="?nav=modules">Modules</a> <a href="?nav=modules&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
			<a href="?nav=functions">Functions</a> <a href="?nav=functions&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
			<a href="?nav=LManager">Layouts</a> <a href="?nav=LManager&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		</div>
		<br />
		<b>Configuration:</b>
		<div style="padding-left:8px;">
			<a href="index.php">Features &amp; Options</a><br />
			<a href="index.php">Themes &amp; Layout</a><br />
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
		<br />
		<b>Panes:</b>
		<div style="padding-left:8px;">
			<?php
			$files=GetFiles("AdminPanes");
			if (count($files)) {
				foreach ($files as $fil) {
				
					$name=explode('.',$fil);
					if ($name[1]=='php') {
						echo'<a href="?pane='.$name[0].'">'.$name[0].'</a> <a href="?pane='.$name[0].'&amp;menu=hide" target="_blank"><img src="'.$this->page->corepath.'Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>';
						}
					}
				}
	
			?>
		</div>
		<br />
		<b>Misc:</b>
		<div style="padding-left:8px;">
			<a href="?devMODE<?=$this->page->devMode?"&amp;message=You just disabled Debug Mode.":""?>"><?=$this->page->devMode?"Disable Debug Mode":"Enable Debug Mode"?></a><br><br />
			<a href="?nav=ErrorLog">View Error Log</a> <a href="?nav=ErrorLog&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
			<br />
		</div>
		<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="psswd" value="task:logout:do" type="hidden" />
			<div align="center">
			<input name="submit" type="submit" value="Logout" />
			</div>
		</form>
		
		<?php
		
		
	}
}

//welcome admin!
class welcome extends Module {
	function welcome($page){
		$this->side=Module::CENTER;
		$this->title="Welcome admin";
		parent::Module($page);
	}
	function content(){
		?>
		Welcome <b>admin</b>, to the WebMS administration panel, this panel should enable you to do what you need to do to the WebMS system. If there is some functionality you believe should be included on this panel or you have some suggestions for improvements then please post at our forums.<br /><br />
		Thanks for choosing WebMS to manage your web site content, if you like this system then please consider donating some change so we can keep the project going strong, alternatively if you ar good with PHP then why not help develop the project further?
		<?php
	}
}


//$page->add(AdminMenu,Module::TOP);
if (isset($_GET['menu']) && $_GET['menu']=='hide') {}else{
	$page->add("AdminMenu2",Module::LEFT);
}
$nav='';
if (isset($_REQUEST['nav'])) {
	$nav=$_REQUEST['nav'];
}
	
	if ($nav=="pages") {
		$page->add("PagesManage");
	}else if ($nav=="modules") {
		$page->add("ModulesManage");
	}else if ($nav=="functions") {
		$page->add("FunctionsManage");
	}else if ($nav=="files") {
		$page->add("Files");
	}else if ($nav=="db") {
		$page->add("dbEditor");
		$page->add("dbList",Module::RIGHT);
	}else if ($nav=="menu") {
		$page->add("menuEditor");
	}else if ($nav=="ErrorLog") {
		$page->add("ErrorLog");
	}else if ($nav=="LManager") {
		$page->add("LayoutManager");
	}else{
		if (!isset($_REQUEST['pane'])) {
			$page->add("welcome",Module::CENTER);
		}
	}

$files=GetFiles("AdminPanes");
if (count($files)) {
	foreach ($files as $fil) {
	
		$name=explode('.',$fil);
		if ($name[1]=='php') {
			if (isset($_REQUEST['pane']) && $name[0]==$_REQUEST['pane']) {
				include("AdminPanes/".$fil);
				//$page->add($name[0]);
				}
			}
		}
	}

/**/
//

$page->create();
?>
