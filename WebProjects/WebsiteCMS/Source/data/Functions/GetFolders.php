<?php
/**
* Get Folders script<br>
* This script will return an array of files or folders in a directory you send it
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright � 2007 ResPlace Team
* @lastedit 12-05-07
*/

//WARNING!!
//This is a CORE module and may be required to accomplish certain tasks within other modules, delete at your own risk.

//INFORMATION:
//Returns an array of every folder found at the given location (only works on local server directorys).

//USAGE:
//This function returns an array or first level directorys, you can then sift through each value using a foreach statement:

/*
$contents=GetFolders("my/path/");
if(is_array($contents))	{
    foreach($contents as $item){
		if($item != '.' && $item != '..'){
			echo "{$directory}{$item}\n";
		}
	}
}
*/
	
function GetFolders($dir='.'){
	$files="";	
	if(is_dir($dir)){
		$dirlist = opendir($dir);
		while( ($file = readdir($dirlist)) !== false){
			if(is_dir($dir.$file) && strpos($file,".svn")===false){
				$files[] = $file;
			}				
		}			
		return $files;
	} else {
		echo'A serious error is reported by a module called GetFolders.php. If you cannot fix this problem please goto the tpvgames support forums.';
	}
}

//GET FILES

function GetFiles($dir='.'){
    $files="";	
    if(is_dir($dir)){
    	$dirlist = opendir($dir);
		while( ($file = readdir($dirlist)) !== false){
			if(!is_dir($dir.$file)){
				$files[] = $file;
			}
		}
		($sortorder == 0) ? asort($files) : rsort($files);
		return $files;
	} else {
		return FALSE;
		break;
	}
}

?>
