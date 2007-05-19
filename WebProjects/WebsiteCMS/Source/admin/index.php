<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Admin Panel");
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
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
		});}");
$page->addDefaults();

$psswd="letmein";
			
			if ($_POST['psswd']==$psswd){
				$_SESSION['admin_session']=md5("logged in");
				}

if ($_SESSION['admin_session']!=md5("logged in")){
	class internalHtml extends Module {
		function internalHtml($page){
			$this->title="Admin Panel";
			parent::Module($page);
		}
		function content(){
			global $path;
			//set the admin password
			
			?>
			Welcome to the admin panel, please login below.<br /><br />
			
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input name="psswd" type="text" />
				<input name="submit" type="submit" value="Login" />
			</form>
			<?php
			}
		}
	$page->add(internalHtml);
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
		?>
		<a href="index.php">Admin Home</a><br /><br />
		<fieldset>
		<legend>Manage:</legend>
		<a href="?manage=pages">Pages</a><br>
		<a href="?manage=modules">Modules</a><br>
		<a href="?manage=functions">Functions</a><br>
		<a href="?manage=pages">Skins</a><br><br />
		<a href="?manage=pages">Other Files</a><br>
		</fieldset><br />
		<fieldset>
		<legend>Misc:</legend>
		<a href="?manage=dbEditor">Database</a><br>
		</fieldset>
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
$page->add(AdminMenu2,Module::LEFT);
if ($_GET['manage']) {$manage=$_GET['manage'];}
if ($_POST['manage']) {$manage=$_POST['manage'];}

if ($manage=="pages") {
	$page->add("PagesManage");
}else if ($manage=="modules") {
	$page->add("ModulesManage");
}else if ($manage=="functions") {
	$page->add("FunctionsManage");
}else if ($manage=="dbEditor") {
	$page->add("dbEditor");
	$page->add("dbList",Module::RIGHT);
}else{
	$page->add(welcome,Module::CENTER);
}

/**/
//

$page->create();
?>
