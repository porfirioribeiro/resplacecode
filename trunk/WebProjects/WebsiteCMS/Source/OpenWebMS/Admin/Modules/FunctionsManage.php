<?php
class FunctionsManage extends Module {
	function FunctionsManage($page){
		parent::Module($page);
		$this->title="Function's Management";		
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
			WriteFile($page->functionspath.$_POST['edit'].".php",stripslashes($_POST['data']));
			?></fieldset><br /><?php
			}
			
		//delete
		if (isset($_GET['del']))
			{
			?>
			<fieldset>
			<legend>Delete...</legend>
			Request should have succeeded.
			<?php
			unlink($page->functionspath.$_GET['del'].".php");
			?></fieldset><br /><?php
			}
		
		?>
		<fieldset>
		<legend>Functions Explorer</legend>
		Heres a list of the currently installed functions:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2">
		<?php
		$files=GetFiles($page->functionspath);
		if (count($files)) {
			foreach ($files as $fil) {
			
				$name=explode('.',$fil);
				if ($name[1]=='php') {
				
					
					echo'<tr>
								<td><a href="?nav=FunctionsManage&amp;edit='.$name[0].'"><img alt="Edit" title="Edit this function" border="0" style="vertical-align:middle" src="icons/edit.png"></a></td>
								<td><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this function?\n'.$name[0].'\')){document.location=\'?nav=FunctionsManage&del='.$name[0].'\'}"><img alt="Delete" title="Delete this function" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
								<td width="100%">'.$name[0].'</td>
							  </tr>';
					}
				}
			} else {
				echo'<tr><td colspan="3">There are no existing functions.</td></tr>';
			}
		?>
		<tr><td colspan="3"><a href="?nav=FunctionsManage&amp;add=add">Add new function</a></td></tr>
		</table>
		<br>
		</fieldset><br>
		<?php
		
		//begin edit
		if (isset($_GET['edit']))
			{
			
			$file=$page->functionspath.$_GET['edit'].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);
			
			?>
			<fieldset>
		<legend>Edit function '<?=$_GET['edit']; ?>'</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="nav" value="FunctionsManage" />
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
		<legend>Create a function</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="nav" value="FunctionsManage" />
			<b>function Name:</b><br>
			The name of your function (remember the class you would normally use, uses this name):<br>
			<input type="text" name="edit" value="" /><br><br>
			<b>function Code:</b><br>
			The code for your function:<br>
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;">&lt;?php
/*
 * My function
 * Notes: My function Notes
 * Author: Who am i?
 */
class Myfunction extends function {
	function Myfunction($page){
		$this->page=$page;
		//where do you want function LEFT, RIGHT, BOTTOM, TOP, CENTER?
		$this->side=function::RIGHT;
		//function title
		$this->title="Box.net Files";
	}
	function content(){
	//function content here
	}
}
?&gt;</textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editpage" value="Create function" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</fieldset>
			<?php
			}
			
		}
	}
	
	$page->add("FunctionsManage");
?>
