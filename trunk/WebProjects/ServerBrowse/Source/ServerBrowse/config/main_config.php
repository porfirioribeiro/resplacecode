<?php
// Server Browser Settings file.
// Read all notes carefully before making any edits, always backup this file.

/*
Do you want the script to work?
true | false
*/
$active=true;

/*
How big do you want the icons in lists?
16 | 22 | 32 | 48 | 64 | 96 | 128
*/
$iconsize="22";
$thumbsize="128";

/*
what files/directorys should we ignore?
place comma between each "one,two,three"
*/
$ignore="ignore,ServerBrowse,hidden,system,setings,data,server_browser_files,restricted,forbidden,.htaccess,settings.php,setup.php,install.php,_settings.php,robots.txt,Thumbs.db";

/*
what file types should we ignore?
place comma between each "zip,rar,gzip"
dont place a dot
*/
$ignorefiletype="db,ini";

/*
Read folders and files seperate or together?
asread | seperate

desc: Allows you to read files after folders, or whether just to read them as they come.
*/
$folderfilesetting="seperate";

//list view
$view="tiles";

/*
Read folder size:
Whether you want to count up file sizes in directorys to give directorys a filesize (this can be slow on huge directorys).
*/
$readfoldersizes=true;

/*
information format:
how information should be displayed for each file, some commands you can use:
%FILESIZE% - places the filesize
%MODIFY_DATE% - plces the modified date
*/

$infostring="%FILESIZE%</td><td class='text2' align='center'>%MODIFY_DATE%";

/*
For advanced users. Set the date/time return format.
*/
function timestampconvert($ts)
	{
	// 08/11/87 10:43:34 PM
	return date('d/m/y h:m:s A', $ts);
	
	// 08/11/87
	//return date('d/m/y', $ts);
	}
	


//some required functions
function in_multi_array($needle, $haystack) {
   $in_multi_array = false;
   foreach ($haystack as $key => $val) {
	   if($key==$needle) {
       		$in_multi_array = true;
            break;
       }
   }
   return $in_multi_array;
}

?>
