<?php
class ModulesManage extends Module {
	function ModulesManage($page){
		parent::Module($page);
		$this->title="Module's Management";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		//edit submit
		if (isset($_POST['editpage']))
			{
			?>
			<fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			<?php
			WriteFile($page->modulespath.$_POST['edit'].".php",stripslashes($_POST['data']));
			?></fieldset><br /><?php
			}
			
		//delete
		if (isset($_GET['del']))
			{
			?>
			<fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			<?php
			unlink($page->modulespath.$_GET['del'].".php");
			?></fieldset><br /><?php
			}
		
		?>
		<fieldset>
		<legend>Modules Explorer</legend>
		Heres a list of the currently installed modules:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2">
		<?php
		$files=GetFiles($page->modulespath);
		if (count($files)) {
			foreach ($files as $fil) {
			
				$name=explode('.',$fil);
				if ($name[1]=='php') {
				
					
					echo'<tr>
								<td><a href="?manage=modules&amp;edit='.$name[0].'"><img alt="Edit" title="Edit this module" border="0" style="vertical-align:middle" src="icons/edit.png"></a></td>
								<td><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this module?\n'.$name[0].'\')){document.location=\'?manage=modules&del='.$name[0].'\'}"><img alt="Delete" title="Delete this module" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
								<td width="100%">'.$name[0].'</td>
							  </tr>';
					}
				}
			} else {
				echo'<tr><td colspan="3">There are no existing modules.</td></tr>';
			}
		?>
		<tr><td colspan="3"><a href="?manage=modules&amp;add=add">Add new module</a></td></tr>
		</table>
		<br>
		</fieldset><br>
		<?php
		
		//begin edit
		if (isset($_GET['edit']))
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
		if (isset($_GET['add']))
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
		}
	}
?>
