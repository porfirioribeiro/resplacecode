<?php
class ModulesManage extends Module {
	function ModulesManage($page){
		parent::Module($page);
		$this->title="Page's Management";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		?>
		<fieldset>
		<legend>Modules Explorer</legend>
		Heres a list of the currently installed modules:<br><br>
		<?php
		$files=GetFiles($page->modulespath);
		
		foreach ($files as $fil) {
		
			$name=explode('.',$fil);
			if ($name[1]=='php') {
			
				echo'[<a href="?manage=modules&amp;edit='.$name[0].'">Edit</a>] [<a href="?manage=modules&amp;del='.$name[0].'">Del</a>] - '.($name[0]).'<br>';
				}
			}
		?>
		<br>
		<a href="?manage=modules&amp;add=add">Add new module</a>
		</fieldset><br>
		<?php
		
		//begin edit
		if ($_GET['edit'])
			{
			
			$file=$page->modulespath.$_GET['edit'].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);
			
			?>
			<fieldset>
		<legend>Edit module '<?=$_GET['edit']; ?>'</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="manage" value="modules" />
			<input type="hidden" name="edit" value="<?=$_GET['edit']; ?>" />
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Save Edit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</fieldset>
			<?php
			}
		//begin add
		if ($_GET['add'])
			{
			
			?>
			<fieldset>
		<legend>Create a module</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="manage" value="modules" />
			<b>Module Name:</b><br>
			The name of your module (remember the class you would normally use, uses this name):<br>
			<input type="text" name="edit" value="" /><br><br>
			<b>Module Code:</b><br>
			The code for your module:<br>
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;">&lt;?php
/*
 * My Module
 * Notes: My Module Notes
 * Author: Who am i?
 */
class MyModule extends Module {
	function MyModule($page){
		$this->page=$page;
		//where do you want module LEFT, RIGHT, BOTTOM, TOP, CENTER?
		$this->side=Module::RIGHT;
		//module title
		$this->title="Box.net Files";
	}
	function content(){
	//module content here
	}
}
?&gt;</textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Create Module" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</fieldset>
			<?php
			}
		//edit submit
		if ($_POST['editpage'])
			{
			?>
			<fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			</fieldset><?php
			
			WriteFile($page->modulespath.$_POST['edit'].".php",stripslashes($_POST['data']));
			}
		//delete
		if ($_GET['del'])
			{
			?>
			<fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			</fieldset><?php
			unlink($page->modulespath.$_GET['del'].".php");
			}
			
		}
	}
?>