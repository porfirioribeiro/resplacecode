<?php
/**
* Module Management (Admin)
* Allows module management.
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-10-07
*/
class LManager extends Module {
	function LManager($page){
		parent::Module($page);
		$this->title="Layout Manager";
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page, $WebMS;

		echo'<br>';

		//edit submit
		if (isset($_POST['editpage']))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Add/Edit:</b></div><br>
			Request should have succeeded.
			<?php
			$_POST['edit']=preg_replace('/[^a-zA-Z0-9]/i','-',$_POST['edit']);
			WriteFile($WebMS['UserLayoutsPath'].$_POST['edit'].".php",stripslashes($_POST['data']));
			?></div><br><br><?php
			}

		//delete
		if (isset($WebMS['URLArray'][2]) && ($WebMS['URLArray'][2]=="Del"))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Delete:</b></div><br>
			Request should have succeeded.
			<?php
			unlink($WebMS['UserLayoutsPath'].$WebMS['URLArray'][3].".php");
			?></div><br><br><?php
			}

		?>
		<div class="fieldset">
			<div class="ftitle"><b>Layout explorer:</b></div><br>
		Heres a list of the currently iexisting layouts:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2" class="tbl">
		<?php
		$files=GetFiles($WebMS['UserLayoutsPath']);
		if (count($files)) {
			foreach ($files as $fil) {

				$name=explode('.',$fil);
				if (isset($name[1]) && $name[1]=='php') {


					echo'<tr>
								<td class="sub"><a href="'.url(array("*","*","Edit",$name[0])).'"><img alt="Edit" title="Edit this layout" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/edit.png"></a></td>
								<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this layout?\n'.$name[0].'\')){document.location=\''.url(Array("*","*","Del",$name[0])).'\'}"><img alt="Delete" title="Delete this layout" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/button_cancel.png"></a></td>
								<td width="100%">'.$name[0].'</td>
							  </tr>';
					}
				}
			} else {
				echo'<tr><td colspan="3" class="sub">There are no existing layouts.</td></tr>';
			}
		?>
		<tr><td colspan="3" class="sub"><a href="<?=url(array("*","*","Add")); ?>">Add new layout</a></td></tr>
		</table>
		<br>
		</div><br><br>
		<?php

		//begin edit
		if (isset($WebMS['URLArray'][2]) && ($WebMS['URLArray'][2]=="Edit"))
			{

			$file=$WebMS['UserLayoutsPath'].$WebMS['URLArray'][3].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);

			?>
			<div class="fieldset">
			<div class="ftitle"><b>Editing '<?=$WebMS['URLArray'][3]; ?>':</b></div><br>
			<form action="<?=url(array("*","*")); ?>" method="post">
			<input type="hidden" name="edit" value="<?=$WebMS['URLArray'][3]; ?>" />
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="editpage" value="Save Edit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</div>
			<?php
			}
		//begin add
		if (isset($WebMS['URLArray'][2]) && ($WebMS['URLArray'][2]=="Add"))
			{

			?>
			<div class="fieldset">
			<div class="ftitle"><b>New layout:</b></div><br>
			<form action="<?=url(array("*","*")); ?>" method="post">
			<b>Module Name:</b><br>
			The name of your layout:<br>
			<input type="text" name="edit" value="" /><br><br>
			<b>Module Code:</b><br>
			The code for your layout (php):<br>
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"></textarea>
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="editpage" value="Create Module" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</div>
			<?php
			}
		}
	}
	$page->addModule("LManager");
?>
