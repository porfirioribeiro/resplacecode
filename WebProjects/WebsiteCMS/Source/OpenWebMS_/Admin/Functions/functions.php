<?php
//deprecated :)
function AdminEditor($handle,$file){
		
		?><form action="<?=$_SERVER['PHP_SELF']; ?>" method="post"><?php
		
		if ($handle=="edit")
			{
			$fh=fopen($file,'r');
			$filedata=fread($fh,filesize($file));
			fclose($fh);
			
			?>
				<input name="pageid" type="text" /><br><br>
			<b>Small Description:</b><br><i>A small description of the page, used in tooltip.</i><br>
			<input name="smalldesc" type="text" /><br><br>
			<b>Large Description:</b><br><i>A large description of the page.</i><br>
			<input name="largedesc" type="text" /><br><br>
				<textarea id="datap" class="codepress php" cols="100%" rows="30" wrap="off"><?=$filedata; ?></textarea>
				<textarea name="data" style="display:none;"></textarea>
				<input name="<?=$handle; ?>" value="Save Changes" onclick="data.value = datap.getCode();" type="submit">
			
			
			<?php
			}
			else if ($handle=="new")
			{
			?>
			<b>Page ID:</b><br><i>Set a some text or a number which will be used to load your page using index.php?page=Page ID.</i><br>
			<input name="pageid" type="text" /><br><br>
			<b>Small Description:</b><br><i>A small description of the page, used in tooltip.</i><br>
			<input name="smalldesc" type="text" /><br><br>
			<b>Large Description:</b><br><i>A large description of the page.</i><br>
			<input name="largedesc" type="text" /><br><br>
			<textarea id="datap" class="codepress php" cols="100%" rows="30" wrap="off"></textarea>
				<textarea name="data" style="display:none;"></textarea>
				<input name="<?=$handle; ?>" value="Create Page" onclick="data.value = datap.getCode();" type="submit">
			<?php
			}
		?></form><?php
	}
function WriteFile($file,$data){
		$fh=fopen($file,'w');
		fwrite($fh,$data);
		fclose($fh);
	}
?>