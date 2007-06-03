<?php

//Set path to the data/ directory FIRST:
$path="../";
include_once $path.'WebMS.php';
$page=new WebMS($path,"Admin Panel");
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
		<fieldset>
		<legend>Main:</legend>
		<a href="index.php">Admin Home</a><br />
		<a href="index.php">Version History</a><br />
		<a href="index.php">Updates</a><br />
		</fieldset><br>
		<fieldset>
		<legend>Website:</legend>
		<? //<a href="?manage=menu">Menu</a><br>
		?>
		<a href="?manage=pages">Webpages</a> <a href="?manage=pages&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		<a href="?manage=files">Webpage Files</a> <a href="?manage=files&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		<a href="?manage=db">Database's</a> <a href="?manage=db&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		</fieldset><br>
		<fieldset>
		<legend>System:</legend>
		<a href="?manage=modules">Add-In Modules</a> <a href="?manage=modules&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		<a href="?manage=functions">Add-In Functions</a> <a href="?manage=functions&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		</fieldset><br />
		
		<fieldset>
		<legend>Option Panes:</legend>
		<?php
		$files=GetFiles("AdminPanes");
		if (count($files)) {
			foreach ($files as $fil) {
			
				$name=explode('.',$fil);
				if ($name[1]=='php') {
					echo'<a href="?managep='.$name[0].'">'.$name[0].'</a> <a href="?managep='.$name[0].'&amp;menu=hide" target="_blank"><img src="'.$this->page->corepath.'Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>';
					}
				}
			}

		?>
		</fieldset><br />
		<fieldset>
		<legend>Debug:</legend>
		<a href="?devMODE<?=$this->page->devMode?"&amp;message=You just disabled Debug Mode.":""?>"><?=$this->page->devMode?"Disable Debug Mode":"Enable Debug Mode"?></a><br><br />
		<a href="?manage=ErrorLog">View Error Log</a> <a href="?manage=ErrorLog&amp;menu=hide" target="_blank"><img src="<?=$this->page->corepath;?>Images/NewWindow.gif" border="0" alt="^" title="Open independant in new window." /></a><br>
		</fieldset><br />
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
		Thanks for chosing WebMS to manage your website content, if you like this system then please consider donating some change so we can keep the project going strong, alternatively if you ar good with PHP then why not help develop the project further?
		<?php
	}
}


//$page->add(AdminMenu,Module::TOP);
if (isset($_GET['menu']) && $_GET['menu']=='hide') {}else{
	$page->add("AdminMenu2",Module::LEFT);
}
if (isset($_GET['manage'])) {
	$manage=$_GET['manage'];
}elseif (isset($_POST['manage'])) {
	$manage=$_POST['manage'];
}else{
	$manage="";
}

if ($manage=="pages") {
	$page->add("PagesManage");
}else if ($manage=="modules") {
	$page->add("ModulesManage");
}else if ($manage=="functions") {
	$page->add("FunctionsManage");
}else if ($manage=="files") {
	$page->add("Files");
}else if ($manage=="db") {
	$page->add("dbEditor");
	$page->add("dbList",Module::RIGHT);
}else if ($manage=="menu") {
	$page->add("menuEditor");
}else if ($manage=="ErrorLog") {
	$page->add("ErrorLog");
}else{
	if (!isset($_REQUEST['managep'])){
		$page->add("welcome",Module::CENTER);
	}
}

$files=GetFiles("AdminPanes");
if (count($files)) {
	foreach ($files as $fil) {
	
		$name=explode('.',$fil);
		if ($name[1]=='php') {
			if (isset($_REQUEST['managep']) && $name[0]==$_REQUEST['managep']) {
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
