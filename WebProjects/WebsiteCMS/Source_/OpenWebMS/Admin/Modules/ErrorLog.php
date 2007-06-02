<?php
class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		//edit a page - submit
		if (isset($_POST['editlog'])){
			?><fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			<?php
			
			WriteFile($path."Inc/errors.log",stripslashes($_POST['data']));
			
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
			unlink($path."Inc/errors.log");
			?></fieldset><br /><?php
			}
		
		?>
		<fieldset>
			<legend>View &amp; Modify</legend>
			Below you can View &amp; Modify the error log.
			<?php
			$file=$path."Inc/errors.log";
				$fh=fopen($file,'r');
				$filedata=fread($fh,filesize($file));
				fclose($fh);
			?>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="manage" value="ErrorLog" />
				<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="editlog" value="Save Edit" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_none')" type="submit">
			</form>
			
			</fieldset><br /><?php
			
		}
	}
?>
