<?php
//allows you to grab a copy of the WebMSoptions.db file (bypass the .htaccess restriction).
//include_once "../Core/Includes/ResDB.php";
$path="../";
include_once $path.'WebMS.php';
$page=new WebMS("Admin Panel");
$db=new ResDB("WebMSoptions");
$psswd=$db->get("adminpassword");
//echo '1:'.$psswd.'<br>2:'.$_REQUEST['sesid'].'<br>';

if ($_REQUEST['sesid']==$psswd){
	$file="../db/WebMSoptions.db";
	if (file_exists($file)) {
		$fh=fopen($file,'r');
		$filedata=fread($fh,filesize($file));
		fclose($fh);
		echo $filedata;
	} else {
		echo 'No database exists to backup (error?)';
	}
} else {
	echo 'You need to be logged in as an admin ;)';
}
?>