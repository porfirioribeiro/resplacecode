<?php

if ($rep==0)
	{ die("<br><b>Folder is not accessible!</b><br><br><i>Sorry about that :)</i>"); }
	
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
			//display a folder on the screen.
			display_ff_list($browse,$file,1);
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
			//display a file on the screen.
			display_ff_list($browse,$file,2);
			}
		}
		else if ($folderfilesetting=="asread")
		{ 
			//prints all files and folders in whatever order their read.
			while ($file = readdir($rep))
			{
				display_ff_list($browse,$file,0);
			}
		}
		else
		{ 
			echo'<b>A setting is incorrect: <i>$folderfilesetting</i></b>'; 
		}
		
		if ($processed == false) 
			{
				print("<tr><td nowrap class='text1' colspan='4'><div align='center'>-&nbsp; $noDir &nbsp;-</div></td>");
				print("</td></tr>");
			}
		
		?></table><?php		
		closedir($rep);
		clearstatcache();
	}
	else if ($view=="tiles")
	{
	?>
	<div align="center">
	<table border="0" cellspacing="5" cellpadding="0" >
	<?php
	
	if ($folderfilesetting=="seperate")
		{ 
		//prints all directorys, then prints all files.
	
		//directorys first yeah??
		$count=0;
		while ($file = readdir($rep))
			{
			//display a folder on the screen.
			//display a file on the screen.
			
			display_ff_tiles($browse,$file,1);
			
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
		$count=0;
		while ($file = readdir($rep))
			{
			//display a file on the screen.
			display_ff_tiles($browse,$file,2);
			
			}
		}
		else if ($folderfilesetting=="asread")
		{ 

			//prints all files and folders in whatever order their read.
			$count=0;
			while ($file = readdir($rep))
			{
				display_ff_tiles($browse,$file,0);
			}
		}
		else
		{ 
			echo'<b>A setting is incorrect: <i>$folderfilesetting</i></b>'; 
		}
		
		if ($processed == false) 
			{
				print("<tr><td nowrap class='text1' colspan='4'><div align='center'>-&nbsp; $noDir &nbsp;-</div></td>");
				print("</td></tr>");
			}
		
		?></table>
		</div><?php		
		closedir($rep);
		clearstatcache();
	}
	
//diplay a file or folder in list view	
function display_ff_list($path,$file,$type)
	{
	global $ignore, $ignorefiletype, $folderloc, $rep, $infostring, $foldericon, $processed, $iconsize, $mimes, $readfoldersizes;
	
	if($file != '..' && $file !='.' && $file !='' && !in_array($file,$ignore))
		{
		if (is_dir($path.$file) && ($type==0 || $type==1))
			{
			$processed=true;
			
			?>
			<tr>
				<td nowrap class='text1'>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				<td class='text1'>
					<img src='<?=$folderloc; ?>icons/<?=$mimes->getFileByExt("folder",$iconsize.'x'.$iconsize); ?>' style='vertical-align:middle' alt='>' />&nbsp;
					<a href='<?=$_SERVER['PHP_SELF']; ?>?browse=<?=$_GET['browse'].$file.".SLSH."; ?>' class='text1'><?=$file; ?></a> <a href='<?=str_replace('.SLSH.','/',$path.$file); ?>' target='_blank' title='Open Folder'><img src='<?=$folderloc; ?>arrow.gif' style='vertical-align:middle' alt='Open Folder' border='0'></a>
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
			else if (!in_array($ext,$ignorefiletype) && !is_dir($path.$file) && ($type==0 || $type==2))
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
		}
		
	return $processed;
	}

//display a file or folder in tiles view
function display_ff_tiles($path,$file,$type)
	{
	global $ignore, $ignorefiletype, $folderloc, $rep, $infostring, $foldericon, $processed, $iconsize, $mimes, $readfoldersizes, $count;
	
	if($file != '..' && $file !='.' && $file !='' && !in_array($file,$ignore))
		{
		if (is_dir($path.$file) && ($type==0 || $type==1))
			{
			$processed=true;
			if ($count==0)
				{ echo'<tr align="center">';}
			?>
			
				<td>
					<img src='<?=$folderloc; ?>icons/<?=$mimes->getFileByExt("folder",$iconsize.'x'.$iconsize); ?>' style='vertical-align:middle' alt='>' /><br />
					<a href='<?=$_SERVER['PHP_SELF']; ?>?browse=<?=$_GET['browse'].$file.".SLSH."; ?>' class='text1'><?=$file; ?></a> <a href='<?=str_replace('.SLSH.','/',$path.$file); ?>' target='_blank' title='Open Folder'><img src='<?=$folderloc; ?>arrow.gif' style='vertical-align:middle' alt='Open Folder' border='0'></a><br /><br />
					<?php 
					//include($folderloc.'infostring.php');
					//print("$infostringu");
					?>
					</td>
			
			<?php
			
			if ($count==4)
				{ echo'</tr>'; $count=0;} else {$count+=1;}
			}
			else if (!in_array($ext,$ignorefiletype) && !is_dir($path.$file) && ($type==0 || $type==2))
			{
			$processed=true;
			
			if ($count==0)
				{ echo'<tr align="center">';}
			?>
			
				<td>
					<?php
					if ($ext=="ico"){
					?>
						<img src='<?=$browse.$file; ?>' width='<?=$iconsize; ?>' height='<?=$iconsize; ?>' style='vertical-align:middle' alt='<?=$ext; ?>'><br />
					<?php
					}else{
					?>
						<img src='<?=$folderloc; ?>icons/<?=$mimes->getFileByExt($ext,$iconsize.'x'.$iconsize); ?>' width='<?=$iconsize; ?>' height='<?=$iconsize; ?>' style='vertical-align:middle' alt='<?=$ext; ?>'><br />
					<?php
					}
					?>&nbsp
					<?=$file; ?>
					<a href='<?=str_replace('.SLSH.','/',$path.$file); ?>' target='_blank' title='Open File'><img src='<?=$folderloc; ?>arrow.gif' style='vertical-align:middle' alt='Open File' border='0'></a><br /><br />
					<?php
					//include($folderloc.'infostring.php');
					//print("$infostringu");
					?>
				</td>
			
			<?php
			if ($count==4)
				{ echo'</tr>'; $count=0;} else {$count+=1;}
			}
		}
		
	return $processed;
	}

?>