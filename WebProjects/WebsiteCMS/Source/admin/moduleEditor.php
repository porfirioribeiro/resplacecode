<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
include($path."FCKeditor/fckeditor.php");
$page=new WebMS($path,"Admin Panel");
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
$page->addDefaults();

class IntOpts extends Module {
	function IntOpts($page){
		parent::Module($page);
		$this->title="Module Options";	
		$this->side=Module::CENTER;
	}
	function content(){
		?>
		ok
		<?php
	}
}
class FCKEditorModule extends Module {
	function FCKEditorModule($page){
		parent::Module($page);
		$this->title="FCKEditor";	
		$this->side=Module::CENTER;	
	}
	function content(){
		?>
		<form action="moduleEditor.php" method="post">
			<input type="hidden" name="SubmitModule">
			Module Name:<input type="text" name="name"><br>
			Module Title:<input type="text" name="title"><br>
			Module Pos:
			<select name="Pos">
				<option value="top">Top</option>
				<option value="left">Left</option>
				<option value="center" selected="selected">Center</option>
				<option value="right">Right</option>
				<option value="bottom">Bottom</option>
			</select>				
			<?php
			$oFCKeditor = new FCKeditor('Content');
			$oFCKeditor->BasePath =$this->page->path.'/FCKeditor/';
			$oFCKeditor->Value = 'Default text in editor';
			$oFCKeditor->Create();
			?>
		</form>
		<?php
		}
}
$page->add(IntOpts);
$page->add(FCKEditorModule);
if (isset($_POST["SubmitModule"])){
	$page->addAlert("","Module Saved!!");
}
//

$page->create();
?>
