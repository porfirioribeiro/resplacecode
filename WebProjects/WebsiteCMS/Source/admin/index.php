<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Admin Panel");
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
$page->addJS("codepress.js");
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
		<a href="?manage=pages">Database</a><br>
		</fieldset>
		<?php
	}
}

//$page->add(AdminMenu,Module::TOP);
$page->add(AdminMenu2,Module::LEFT);
if ($_GET['manage']) {$manage=$_GET['manage'];}
if ($_POST['manage']) {$manage=$_POST['manage'];}

if ($manage=="pages")
	{
	$page->add("PagesManage");
	}
if ($manage=="modules")
	{
	$page->add("ModulesManage");
	}
if ($manage=="functions")
	{
	$page->add("FunctionsManage");
	}


//

$page->create();
?>
