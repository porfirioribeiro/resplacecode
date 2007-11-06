<?php
//this is an included file.
//sort out the information string...
$infostringu=$infostring;
if (!is_dir($path.$file))
	{
	$infostringu=str_replace("%FILESIZE%",ConvertSize(filesize($path.$file)),$infostring);
	}
	else
	{
	if ($readfoldersizes==true)
		{
		$returned=explode("|",GetFolderSize($path.$file,$chachecount,$folderloc));
		$chachecount=$returned[1];
		if ($returned[2]=="STOP")
			{
			$stringu=ConvertSize($returned[0])."*";
			}
			else
			{
			$stringu=ConvertSize($returned[0]);
			}
		$infostringu=str_replace("%FILESIZE%",$stringu,$infostring);
		}
	}
$infostringu=str_replace("%MODIFY_DATE%",timestampconvert(filemtime($path.$file)),$infostringu);

?>
