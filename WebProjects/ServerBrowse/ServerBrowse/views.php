<?php
//list view
$view="list";

if ($view=="list")
	{
	?>
	<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
		<tr style='height:30px;' align='center'>
			<td nowrap class='text1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align='left'><b>Name:</b></td>
			<td><b>Filesize:</b></td>
			<td><b>Last Modified:</b></td>
		</tr>
	<?php
	
	if ($folderfilesetting=="seperate")
		{ 
		//prints all directorys, then prints all files.
	
		//directorys first yeah??
		while ($file = readdir($rep))
			{
			if($file != '..' && $file !='.' && $file !='' && !in_array($file,$ignore))
				{
				//display a folder on the screen.
				display_folder_list($browse,$file);
				}
			}
	
		//restart
		closedir($rep);
		if (isset($_GET['browse']))
			{
			$rep=opendir(str_replace("..","[UHAAA]",$browse));
			}
			else
			{
			$rep=opendir(".");
			}
	
	
		//now for the files
		while ($file = readdir($rep))
			{
			if($file != '..' && $file !='.' && $file !='' && !in_array($file,$ignore))
				{
				//display a file on the screen.
				display_file_list($browse,$file);
				}
			}
		}
		else if ($folderfilesetting=="asread"){ 
			//prints all files and folders in whatever order their read.
			while ($file = readdir($rep)){
				if($file != '..' && $file !='.' && $file !='' && !in_array($file,$ignore)){
					if (is_dir($browse.$file)){
						display_folder_list($browse,$file);
					}else{				
						display_file_list($browse,$file);
					}
					}
				}
		}else{ 
			echo'<b>A setting is incorrect: <i>$folderfilesetting</i></b>'; 
		}
		
	if ($processed == false) {
			print("<tr><td nowrap class='text1'><div align='center'>-&nbsp; $noDir &nbsp;-</div></td>");
			print("</td></tr>");
		}
		
	?></table><?php		
	closedir($rep);
	clearstatcache();
	
	}
	else if ($view=="")
	{
	
	}
	
//diplay a folder in list view	
function display_folder_list($path,$file)
	{
	global $folderloc, $rep, $infostring, $foldericon, $processed, $iconsize, $mimes, $readfoldersizes;
	
	if (is_dir($path.$file))
		{
		$processed=true;
		?>
		<tr>
			<td nowrap class='text1'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td class='text1'>
				<img src='<?=$folderloc; ?>icons/<?=$mimes->getFileByExt("folder",$iconsize.'x'.$iconsize); ?>' style='vertical-align:middle' alt='>' />&nbsp;
				<a href='<?=$_SERVER['PHP_SELF']; ?>?browse=<?=$_GET['browse'].$file.".SLSH."; ?>' class='text1'><?=$file; ?></a> <a href='<?=str_replace('.SLSH.','/',$browse.$file); ?>' target='_blank' title='Open Folder'><img src='<?=$folderloc; ?>arrow.gif' style='vertical-align:middle' alt='Open Folder' border='0'></a>
			</td>
			<td class='text2' align='center'>
				<?php 
				include($folderloc.'infostring.php');
				print("$infostringu");
				?>
			</td>
		</tr>
		<?php
		}
		
	return $processed;
	}
	
//display a file in list view
function display_file_list($path,$file)
	{
	global $ignorefiletype, $iconsarray, $folderloc, $rep, $infostring, $processed, $browse, $mimes, $iconsize, $readfoldersizes; 
	
	$ext=strtolower(end(explode(".", $file)));
	if (!is_dir($path.$file) && !in_array($ext,$ignorefiletype))
		{
		$processed=true;
		?>
		<tr>
			<td nowrap class='text1'>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td class='text1'>
				<?php
				if ($ext=="ico"){
				?>
					<img src='<?=$browse.$file; ?>' width='<?=$iconsize; ?>' height='<?=$iconsize; ?>' style='vertical-align:middle' alt='<?=$ext; ?>'>
				<?php
				}else{
				?>
					<img src='<?=$folderloc; ?>icons/<?=$mimes->getFileByExt($ext,$iconsize.'x'.$iconsize); ?>' width='<?=$iconsize; ?>' height='<?=$iconsize; ?>' style='vertical-align:middle' alt='<?=$ext; ?>'>
				<?php
				}
				?>&nbsp
				<?=$file; ?>
				<a href='<?=str_replace('.SLSH.','/',$path.$file); ?>' target='_blank' title='Open File'><img src='<?=$folderloc; ?>arrow.gif' style='vertical-align:middle' alt='Open File' border='0'></a>
			</td>
			<td class='text2' align='center'>
				<?php
				include($folderloc.'infostring.php');
				print("$infostringu");
				?>
			</td>
		</tr>
		<?php
		}
		
	return $processed;
	}

?>