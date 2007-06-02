<?php
class PagesManage extends Module {
	function PagesManage($page){
		parent::Module($page);
		$this->title="Page's Management";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		//add a page - submit
		if ($_POST['addpage']){
			?><fieldset>
			<legend>Add new page</legend>
			Request should have succeeded.
			<?php
			$pageid=str_replace(array(" ","/"),array("_","_"),$_POST['pageid']);
			
			WriteFile($path."Pages/".$pageid.".php",stripslashes($_POST['data']));
			$db= new ResDB("files");
			$somemap=$db->getMap($pageid);//you only need maps for organize the db
			$somemap->put("name",$_POST['name']);
			$somemap->put("smalldesc",$_POST['smalldesc']);
			$somemap->put("largedesc",$_POST['largedesc']);
			$db->close();//this is what saves the db
			?></fieldset><br /><?php
			}
		
		if ($_GET['pageiddel'])
			{
			?><fieldset>
			<legend>Delete...</legend>
			Request should have succeeded.
			<?php
			$db= new ResDB("files");
			//$somemap=$db->getMap($_GET['pageiddel']);//you only need maps for organize the db
			$db->del($_GET['pageiddel']);
			//$somemap->del("largedesc");
			$db->close();//this is what saves the db
			unlink($path."Pages/".$_GET['pageiddel'].".php");
			?></fieldset><br /><?php
			}
			
		//edit a page - submit
		if ($_POST['editpage']){
			?><fieldset>
			<legend>Editing...</legend>
			Request should have succeeded.
			<?php
			$pageid=str_replace(array(" ","/"),array("_","_"),$_POST['pageid']);
			
			WriteFile($path."Pages/".$pageid.".php",stripslashes($_POST['data']));
			
			$db= new ResDB("files");
			$somemap=$db->getMap($pageid);//you only need maps for organize the db
			$somemap->put("name",$_POST['name']);
			$somemap->put("smalldesc",$_POST['smalldesc']);
			$somemap->put("largedesc",$_POST['largedesc']);
			$db->close();//this is what saves the db
			?></fieldset><br /><?php
			}
		
		?>
		<fieldset>
		<legend>Page Explorer</legend>
		Heres a list of pages that exist in the DB:<br /><br />
		<table width="400" border="1" bordercolor="#9bcf82" cellspacing="2" cellpadding="2">
		<?php
		$db= new ResDB("files");
		if (count($db)) {
			foreach ($db as $key=>$value) {
				$name=$db->get($key)->get("name");
				echo'<tr>
							<td><a href="?manage=pages&amp;page=page-edit&amp;pageid='.$key.'"><img alt="Edit" title="Edit this page" border="0" style="vertical-align:middle" src="icons/edit.png"></a></td>
							<td><a href="javascript:void(0)" onclick="if (confirm(\'You sure you want to delete this page?\n'.$key.'\')){document.location=\'?manage=pages&pageiddel='.$key.'\'}"><img alt="Delete" title="Delete this page" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a></td>
							<td width="100%"><a href="'.str_replace("data/","",$path).'getfile.php?page='.$key.'" target="_blank">'.$name.'</a></td>
						  </tr>';
				}
			} else {
				echo'<tr><td colspan="3">There are no existing pages.</td></tr>';
			}
		echo'<tr><td colspan="3"><a href="?manage=pages&amp;page=page-add">Add new page</a></td></tr></table><br>
		';
		
		//Add a page
		?></fieldset><br />
			
			<?php
		if ($_GET['page']=="page-add")
			{
			?>
			<fieldset>
			<legend>Add new page</legend>
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="manage" value="pages" />
			<b>Page ID:</b><br /><i>Set a some text or a number which uniqly identifies the page, used as filename and when navigating to a page via ?page=</i><br />
			<input name="pageid" type="text" /><br /><br />
			<b>Page Name:</b><br /><i>The name of the page (used in page explorer and as name in generated menu):</i><br />
			<input name="name" type="text" /><br /><br />
			<b>Small Description:</b><br /><i>A small description of the page, used in tooltip.</i><br />
			<input name="smalldesc" type="text" /><br /><br />
			<b>Large Description:</b><br /><i>A large description of the page.</i><br />
			<input name="largedesc" type="text" /><br /><br />
			<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="addpage" value="Create Page" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
			
			</fieldset>
			
			<?php
			}
			
		//edit a page
		if ($_GET['page']=="page-edit")
			{
			
			if ($_GET['pageid'])
				{
				?>
				<fieldset>
				<legend>Editing '<?=$_GET['pageid']; ?>'</legend>
				<?php
				
				$smalldesc=$db->get($_GET['pageid'])->get("smalldesc");
				$largedesc=$db->get($_GET['pageid'])->get("largedesc");
				$name=$db->get($_GET['pageid'])->get("name");
				
				$file=$path."Pages/".$_GET['pageid'].".php";
				$fh=fopen($file,'r');
				$filedata=fread($fh,filesize($file));
				fclose($fh);
				?>
				
				
				<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="manage" value="pages" />
				<b>Page ID:</b><br /><i>Set a some text or a number which will be used to load your page using index.php?page=Page ID.</i><br />
				<input name="pageid" type="text" value="<?=$_GET['pageid']; ?>" /><br /><br />
				<b>Page Name:</b><br /><i>The name of the page (used in page explorer and as name in generated menu):</i><br />
			<input name="name" type="text" value="<?=$name; ?>" /><br /><br />
				<b>Small Description:</b><br /><i>A small description of the page, used in tooltip.</i><br />
				<input name="smalldesc" type="text" value="<?=$smalldesc; ?>" /><br /><br />
				<b>Large Description:</b><br /><i>A large description of the page.</i><br />
				<input name="largedesc" type="text" value="<?=$largedesc; ?>" /><br /><br />
				<textarea id="use_php" name="datap" style="height: 350px; width: 100%;"><?=$filedata; ?></textarea>
			<textarea name="data" style="display:none;"></textarea><br />
			<input name="addpage" value="Save Edit" id="EditAreaSubmit" onclick="data.value = editAreaLoader.getValue('use_php')" type="submit">
			</form>
				
				<?php
				}
				?></fieldset><?php
			}	
		}
	}
?>
