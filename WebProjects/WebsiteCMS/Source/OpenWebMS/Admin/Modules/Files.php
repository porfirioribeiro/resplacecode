<?php
class Files extends Module {
	function Files($page) {
		parent::Module($page);
		$this->title="File Management";
		$this->side=Module::CENTER;
	}
	function content() {
		global $path, $page;

		echo'<br>';
		//Upload the file
		if (isset($_FILES['userfile']['name'])) {
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Upload file:</b></div><br />

			<?php
			include $path.'setup.php';
			$uploaddir = $AbsUploadPath;
			$uploadfile = $uploaddir . $_FILES['userfile']['name'];
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])) {
				print "File was uploaded successfully!";
				} else {
				print "For some reason upload failed :(";
				}
			?>
			</div><br /><br>
			<?php
			}

		//delete
		if (isset($_GET['del'])) {
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Deleting file:</b></div><br />
			Request should have succeeded.
			<?php
			unlink($path."Files/".$_GET['del']);
			?></div><br /><br><?php
			}

		?>
		<div class="fieldset">
		<div class="ftitle"><b>File Explorer:</b></div><br />
		Heres a list of the currently uploaded files:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2" class="tbl">
		<?php
		$files=GetFiles($path."Files/");
		if (count($files)) {
			foreach ($files as $fil) {
					echo'<tr>
								<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this file?\n'.$fil.'\')){document.location=\'?nav=Files&del='.$fil.'\'}"><img alt="Delete" title="Delete this file" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
								<td width="100%">'.$fil.'</td>
							  </tr>';
				}
			} else {
				echo'<tr><td colspan="2"  class="main">There are no files.</td></tr>';
			}
		?>
		<tr><td colspan="3">
			<form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
			<input type="hidden" name="manage" value="Files"  />
			Upload a file:<br />
			<input name="userfile" type="file" />
			<br />
			<input type="submit" value="Upload" />
			</form>
		</td></tr>
		</table>
		<br>
		</div><br><br>
		<?php

		}
	}

	$page->add("Files");
?>
