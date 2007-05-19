<?php
class FunctionsManage extends Module {
	function FunctionsManage($page){
		parent::Module($page);
		$this->title="Page's Management";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		?>
		<fieldset>
		<legend>Functions Explorer</legend>
		Heres a list of the currently installed functions:<br><br>
		<?php
		$files=GetFiles($page->functionspath);
		
		foreach ($files as $fil) {
		
			$name=explode('.',$fil);
			if ($name[1]=='php') {
			
				echo'[<a href="?manage=functions&amp;edit='.$name[0].'">Edit</a>] [<a href="?manage=functions&amp;del='.$name[0].'">Del</a>] - '.($name[0]).'<br>';
				}
			}
		?>
		<br>
		<a href="?manage=functions&amp;add=add">Add new function</a>
		</fieldset><br>
		<?php
		
		//begin edit
		if ($_GET['edit'])
			{
			
			$file=$page->functionspath.$_GET['edit'].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);
			
			?>
			<fieldset>
		<legend>Edit function '<?=$_GET['edit']; ?>'</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="manage" value="functions" />
			<input type="hidden" name="edit" value="<?=$_GET['edit']; ?>" />
<<<<<<< .mine
			<textarea id="datap" class="codepress php" cols="100%" rows="30" wrap="off"><?=$filedata; ?></textarea><br />
			<input type="button" onclick="datap.toggleEditor();" value="Toggle Editor" />
			<textarea name="data" style="display:none;"></textarea>
			<input name="editpage" value="Save Edit" id="EditAreaSubmit" onclick="data.value = datap.getCode();" type="submit">
=======
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Save Edit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
>>>>>>> .r15
			</form>
			</fieldset>
			<?php
			}
		//begin add
		if ($_GET['add'])
			{
			
			?>
			<fieldset>
		<legend>Create a function</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="manage" value="functions" />
			<b>Function Name:</b><br>
			The name of your function (remember the class you would normally use, uses this name):<br>
			<input type="text" name="edit" value="" /><br><br>
			<b>Function Code:</b><br>
			The code for your function:<br>
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
<<<<<<< .mine
?&gt;</textarea><br />
			<input type="button" onclick="datap.toggleEditor();" value="Toggle Editor" />
			<textarea name="data" style="display:none;"></textarea>
			<input name="editpage" value="Save Edit" id="EditAreaSubmit" onclick="data.value = datap.getCode();" type="submit">
=======
?&gt;</textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Add Function" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
>>>>>>> .r15
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
			
			WriteFile($page->functionspath.$_POST['edit'].".php",stripslashes($_POST['data']));
			}
		//delete
		if ($_GET['del'])
			{
			?>
			<fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			</fieldset><?php
			unlink($page->functionspath.$_GET['del'].".php");
			}
			
		}
	}
?>
