<?php
/**
* System Content Provider
* Handles all requests (or should) in the system
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 24-10-07
*/

//start collecting the output
session_start();
ini_set('implicit_flush',false);
ob_start();

include_once("OpenWebMS/config.php");
define("WEBMS_ROOT","OpenWebMS/");

//TODO remove...
$page="";
$pages=WEBMS_ROOT."Pages/";
$systems=WEBMS_ROOT."Systems/";
$users=WEBMS_ROOT."User/";
$admin=WEBMS_ROOT."Admin/";
$tests=WEBMS_ROOT."Tests/";
include_once(WEBMS_ROOT."WebMS.php");
include_once($WebMS["CorePath"]."URL/".$WebMS["URLFormat"].".php");

//grab all the collected HTML then output it.
$cont= ob_get_contents();
ob_end_clean();
echo $cont;

?>
