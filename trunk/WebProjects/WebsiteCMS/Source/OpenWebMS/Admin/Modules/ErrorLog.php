<?php
class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		
		//delete
		if (isset($_GET['del']))
			{
			?>
			<fieldset>
			<legend>Delete...</legend>
			Request should have succeeded.
			<?php
			unlink($path."Core/Includes/errors.log");
			?></fieldset><br><?php
			}
		
		?>
		<fieldset>
			<legend>View &amp; Modify</legend>
			Below you can View &amp; Modify the error log.
			<br><br>
			[<a href="?nav=ErrorLog&amp;del=1">Delete log</a>]<br><br>
			<?php
			$file=$path."Core/Includes/errors.log";
				$fh=fopen($file,'a+');
				if (!filesize($file)==0) {
					$filedata=fread($fh,filesize($file));
				} else {
					$filedata="No Errors Logged.";
				}
				fclose($fh);
			?>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="manage" value="ErrorLog" />
				<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="addpage" value="Save Edit" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_none')" type="submit">
			</form>
			
			</fieldset><br><?php
			
		}
	}
	
	$page->add("ErrorLog");
?>
