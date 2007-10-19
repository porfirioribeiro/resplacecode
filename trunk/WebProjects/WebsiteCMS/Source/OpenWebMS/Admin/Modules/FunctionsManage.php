<?php
/**
* Function Management (Admin)
* Allows function management.
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-10-07
*/
class FunctionsManage extends Module {
	function FunctionsManage($page){
		parent::Module($page);
		$this->title="Function's Management";		
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
			WriteFile($WebMS["UserFunctionsPath"].$_POST['edit'].".php",stripslashes($_POST['data']));
			?></div><br><?php
			}
			
		//delete
		if (isset($WebMS['URLArray'][2]) && ($WebMS['URLArray'][2]=="Del"))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Delete:</b></div><br>
			Request should have succeeded.
			<?php
			unlink($WebMS["UserFunctionsPath"].$WebMS["URLArray"][3].".php");
			?></div><br><?php
			}
		
		?>
		<div class="fieldset">
			<div class="ftitle"><b>Functions explorer:</b></div><br>
		Heres a list of the currently installed functions:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2" class="tbl">
		<?php
		$files=GetFiles($WebMS["UserFunctionsPath"]);
		if (count($files)) {
			foreach ($files as $fil) {
			
				$name=explode('.',$fil);
				if ($name[1]=='php') {
				
					
					echo'<tr>
								<td  class="sub"><a href="'.url(array("*","*","Edit",$name[0])).'"><img alt="Edit" title="Edit this function" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/edit.png"></a></td>
								<td  class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this function?\n'.$name[0].'\')){document.location=\''.url(array("*","*","Del",$name[0])).'\'}"><img alt="Delete" title="Delete this function" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/button_cancel.png"></a></td>
								<td width="100%">'.$name[0].'</td>
							  </tr>';
					}
				}
			} else {
				echo'<tr><td colspan="3"  class="sub">There are no existing functions.</td></tr>';
			}
		?>
		<tr><td colspan="3"  class="sub"><a href="<?=url(array("*","*","Add")); ?>">Add new function</a></td></tr>
		</table>
		<br>
		</div><br>
		<?php
		
		//begin edit
		if (isset($WebMS['URLArray'][2]) && ($WebMS['URLArray'][2]=="Edit"))
			{
			
			$file=$WebMS["UserFunctionsPath"].$WebMS["URLArray"][3].".php";
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);
			
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Edit function '<?=$WebMS["URLArray"][3]; ?>':</b></div><br>
			<form action="<?=url(array("*","*")); ?>" method="post">
			<input type="hidden" name="edit" value="<?=$_GET['edit']; ?>" />
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
			<div class="ftitle"><b>Create a function:</b></div><br>
			<form action="<?=url(array("*","*")); ?>" method="post">
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
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="editpage" value="Create function" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			</div>
			<?php
			}
			
		}
	}
	
	$page->add("FunctionsManage");
?>
