<?php
class PagesManage extends Module {
	function PagesManage($page){
		parent::Module($page);
		$this->title="Page's Management";
		$this->side=Module::CENTER;
	}
	function content() {
		global $path,$WebMS;

		echo'<br>';

		//add a page - submit
		if (isset($_POST['addpage'])) {
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Add/Edit page:</b></div><br>
			Request should have succeeded.
			<?php
			$pageid=str_replace(array(" ","/"),array("_","_"),$_POST['pageid']);
			if ($_POST['folder']==""){
				WriteFile($WebMS['WebMSPath']."Pages/".$pageid.".php",stripslashes($_POST['data']));
			} else {
				WriteFile($WebMS['WebMSPath']."Pages/".$_POST['folder'].'/'.$pageid.".php",stripslashes($_POST['data']));
			}
			
			?></div><br><br><?php
			}

		if (isset($_GET['pageiddel']))
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Deleting page:</b></div><br>
			Request should have succeeded.
			<?php
			if (isset($_GET['folder'])){
				unlink($WebMS['WebMSPath']."Pages/".$_GET['folder']."/".$_GET['pageiddel'].".php");
			}else{
				unlink($WebMS['WebMSPath']."Pages/".$_GET['pageiddel'].".php");
			}
			?></div><br><br><?php
			}

		?>
		<div class="fieldset">
		<div class="ftitle"><b>Page explorer:</b></div><br>
		Heres a list of web pages that exist in this system:<br><br>
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2" class="tbl">
		<tr>
			<td class="sub" style="text-align:left" colspan="3"><b>%Root% Directory:</b></td>
		</tr>
		<?php
		/*$db= new ResDB("files");
		if (count($db)) {
			foreach ($db as $key=>$value) {
				$name=$db->get($key)->get("name");
				echo'<tr>
							<td class="sub"><a href="?nav=PagesManage&amp;page=page-edit&amp;pageid='.$key.'"><img alt="Edit" title="Edit this page" border="0" style="vertical-align:middle" src="icons/edit.png"></a></td>
							<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this page?\n'.$key.'\')){document.location=\'?nav=PagesManage&pageiddel='.$key.'\'}"><img alt="Delete" title="Delete this page" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
							<td width="100%"><a href="'.str_replace("OpenWebMS/","",$path).'../getfile.php?page='.$key.'" target="_blank">'.$name.'</a></td>
						  </tr>';
				}
			} else {
				echo'<tr><td colspan="3" class="sub">There are no existing pages.</td></tr>';
			}
		echo'<tr><td colspan="3" class="sub"><a href="?nav=PagesManage&amp;page=page-add">Add new page</a></td></tr></table><br>
		';

		//Add a page
		*/

		$files=GetFiles($WebMS["PagesPath"]);
		if (count($files)) {
			foreach ($files as $fil) {

				$name=explode('.',$fil);
				if ($name[1]=='php') {


					echo'<tr>
								<td class="sub"><a href="?Admin.PagesManage&amp;page=page-edit&amp;pageid='.$name[0].'"><img alt="Edit" title="Edit this web page" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/edit.png"></a></td>
								<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this web page?\n'.$name[0].'\')){document.location=\'?Admin.PagesManage&amp;pageiddel='.$name[0].'\'}"><img alt="Delete" title="Delete this web page" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/button_cancel.png"></a></td>
								<td width="100%"><a href="'.str_replace("OpenWebMS/","",$path).'../index.php?'.$name[0].'" target="_blank">'.$name[0].'</a></td>
							  </tr>';
				}
			}
		} else {
			echo'<tr><td colspan="3" class="sub">There are no existing web pages.</td></tr>';
		}
		
		$files=GetFolders($WebMS["PagesPath"]);
		if (count($files)) {
			foreach ($files as $fil) {
				
				echo'
				<tr>
					<td class="sub" style="text-align:left" colspan="3"><b>"'.$fil.'" Directory:</b></td>
				</tr>';
				$files2=GetFiles($WebMS["PagesPath"].$fil);
				if (count($files2)) {
					foreach ($files2 as $fil2) {
		
						$name=explode('.',$fil2);
						if ($name[1]=='php') {
		
		
							echo'<tr>
										<td class="sub"><a href="?Admin.PagesManage&amp;page=page-edit&amp;pageid='.$name[0].'&amp;folder='.$fil.'"><img alt="Edit" title="Edit this web page" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/edit.png"></a></td>
										<td class="sub"><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this web page?\n'.$name[0].'\')){document.location=\'?Admin.PagesManage&pageiddel='.$name[0].'&amp;folder='.$fil.'\'}"><img alt="Delete" title="Delete this web page" border="0" style="vertical-align:middle" src="'.$WebMS['AdminUrl'].'icons/button_cancel.png"></a></td>
										<td width="100%"><a href="'.str_replace("OpenWebMS/","",$path).'../index.php?'.$fil.'.'.$name[0].'" target="_blank">'.$name[0].'</a></td>
									  </tr>';
						}
					}
				} else {
					echo'<tr><td colspan="3" class="sub">There are no existing web pages.</td></tr>';
				}
				
			}
		} 
			
		echo'<tr><td colspan="3" class="sub"><a href="?Admin.PagesManage&amp;page=page-add">Add new page</a></td></tr></table><br>
		';
		?><br><br>

			<?php
		if (isset($_GET['page']) && $_GET['page']=="page-add")
			{
			?>
			<div class="fieldset">
			<div class="ftitle"><b>Add new page:</b></div><br>
			<form action="<?=$_SERVER['PHP_SELF']; ?>?Admin.PagesManage" method="post">
			<b>Directory:</b><br><i>A directory to place this file into. New directory.</i><br>
				<?php
					$files=GetFolders($WebMS["PagesPath"]);
					if (count($files)) {
						echo '<select name="folder">
							<option value="" selected="selected">%ROOT% Directory</option>';
						
						foreach ($files as $fil) {
							echo'<option value="'.$fil.'">'.$fil.'</option>';
						}
						
						echo'</select>';
					} else {
						echo'<input name="folder" type="hidden" value="">';
					}
				?>
			<br><br>
			<input type="hidden" name="nav" value="PagesManage" />
			<b>Page Name:</b><br><i>Define the name of the file, also used to load your page using index.php?page=PageID.</i><br>
				<input name="pageid" type="text" value="" /><br><br>
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"></textarea>
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="addpage" value="Create Page" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>

			</div><br>

			<?php
			}

		//edit a page
		if (isset($_GET['page']) && $_GET['page']=="page-edit")
			{

			if (isset($_GET['pageid']))
				{
				?>
				<div class="fieldset">
				<div class="ftitle"><b>Editing '<?=$_GET['pageid']; ?>':</b></div><br>
				<?php
				if (isset($_GET['folder'])){
					$file=$WebMS['WebMSPath']."Pages/".$_GET['folder']."/".$_GET['pageid'].".php";	
				}else {
					$file=$WebMS['WebMSPath']."Pages/".$_GET['pageid'].".php";
				}
				
				$fh=fopen($file,'r');
				if (filesize($file)>=1) { 
					$filedata=fread($fh,filesize($file));
				} else {
					$filedata="";	
				}
				fclose($fh);
				?>


				<form action="?Admin.PagesManage" method="post">
				<b>Directory:</b><br><i>The directory this file exists in.</i><br>
				<input name="folder" type="text" value="<?=(isset($_GET['folder'])) ? $_GET['folder']:"" ?>" disabled>
			<br><br>
				<input type="hidden" name="nav" value="PagesManage" />
				<input type="hidden" name="folder" value="<?=(isset($_GET['folder'])) ? $_GET['folder']:"" ?>" />
				<b>Page Name:</b><br><i>Define the name of the file, also used to load your page using index.php?page=PageID.</i><br>
				<input name="pageid" type="text" value="<?=(isset($_GET['pageid'])) ? $_GET['pageid']:"" ?>" /><br><br>
				<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br>
			<input name="addpage" value="Save Edit" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>

				<?php
				}
				?></div><?php
			}
		}
	}
	$page->add("PagesManage");
?>
