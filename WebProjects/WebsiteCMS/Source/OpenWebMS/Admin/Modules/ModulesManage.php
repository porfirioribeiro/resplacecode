<?php
class ModulesManage extends Module {
	function ModulesManage($page){
		parent::Module($page);
		$this->title="Module's Management";
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;

		echo'<br>';

		//edit submit
		if (isset($_POST['editpage']))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Add/Edit Page:</b></div><br />
			Request should have succeeded.
			<?php
			WriteFile($page->modulespath.$_POST['edit'].".php",stripslashes($_POST['data']));
			?></div><br><br><?php
			}

		//delete
		if (isset($_GET['del']))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Deleting page:</b></div><br />
			Request should have succeeded.
			<?php
			unlink($page->modulespath.$_GET['del'].".php");
			?></div><br><br><?php
			}

		?>
		<div class="fieldset">
			<div class="ftitle"><b>Module explorer:</b></div><br />
		Heres a list of the currently installed modules:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2" class="tbl">
		<?php
		$files=GetFiles($page->modulespath);
		if (count($files)) {
			foreach ($files as $fil) {

				$name=explode('.',$fil);
				if ($name[1]=='php') {


					echo'<tr>
								<td class="sub"><a href="?nav=ModulesManage&amp;edit='.$name[0].'"><img alt="Edit" title="Edit this module" border="0" style="vertical-align:middle" src="icons/edit.png"></a></td>
								<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this module?\n'.$name[0].'\')){document.location=\'?nav=ModulesManage&del='.$name[0].'\'}"><img alt="Delete" title="Delete this module" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
								<td width="100%">'.$name[0].'</td>
							  </tr>';
					}
				}
			} else {
				echo'<tr><td colspan="3" class="sub">There are no existing modules.</td></tr>';
			}
		?>
		<tr><td colspan="3" class="sub"><a href="?nav=ModulesManage&amp;add=add">Add new module</a></td></tr>
		</table>
		<br>
		</div><br><br>
		<?php

		//begin edit
		if (isset($_GET['edit']))
			{

			$file=$page->modulespath.$_GET['edit'].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);

			?>
			<div class="fieldset">
			<div class="ftitle"><b>Editing '<?=$_GET['edit']; ?>':</b></div><br />
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="nav" value="ModulesManage" />
			<input type="hidden" name="edit" value="<?=$_GET['edit']; ?>" />
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Save Edit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</div>
			<?php
			}
		//begin add
		if (isset($_GET['add']))
			{

			?>
			<div class="fieldset">
			<div class="ftitle"><b>New module:</b></div><br />
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="nav" value="ModulesManage" />
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
			</div>
			<?php
			}
		}
	}
	$page->add("ModulesManage");
?>
