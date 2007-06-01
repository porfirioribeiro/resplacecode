<?php
//allows you to grab a copy of the WebMSoptions.db file (bypass the .htaccess restriction).
include_once "../data/Functions/ResDB.php";
$db=new ResDB("WebMSoptions");
$psswd=$db->get("adminpassword");
//echo '1:'.$psswd.'<br>2:'.$_REQUEST['sessid'].'<br>';

if ($_REQUEST['sesid']==$psswd){
	$file="../data/db/WebMSoptions.db";
	$fh=fopen($file,'r');
	$filedata=fread($fh,filesize($file));
	fclose($fh);
	echo $filedata;
} else {
	echo 'You need to be logged in as an admin ;)';
}
?>