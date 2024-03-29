<?php
/**
* OpenWebMS Configuration File
* This file loads all "super global" variables, aswell as post-run scripts
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-10-07
*/

error_reporting(E_ALL); 

global $WebMS;
$WebMS=array();
require_once("db.conf.php");

$WebMS["mod_rewrite"]=(getenv('mod_rewrite')=="true");

$WebMS["FailSafeLogin"]				="openwebms";
$WebMS["Version"]				="0.1|BETA";
//url formats:
//Normal		- ?p=blah&amp;c=blah&amp;a=blah
//CleanDots		- ?blah.blah.huh.yey
//Slashs        - /blah/blah/blah/huh/yey
$WebMS["URLFormat"]				    ="CleanDots";
$WebMS["URLParts"]				    =0;
$WebMS["URLArray"]				    =array();
$WebMS["URLPage"]				      ="";
$WebMS["URLCat"]				      ="";
$WebMS["ServerURL"]           =((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == TRUE) ? 'https://' : 'http://').($_SERVER['HTTP_HOST']).(($_SERVER['SERVER_PORT']!=80 && $_SERVER['SERVER_PORT']!=443)  ? ":{$_SERVER['SERVER_PORT']}" : '');
$WebMS["RootUrl"]           	=$WebMS["ServerURL"].str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
$WebMS["ScriptUrl"]           =$WebMS["ServerURL"].$_SERVER['SCRIPT_NAME'];
$WebMS["RootPath"]          	="";						 
$WebMS["WebMSPath"]         	=dirname(__FILE__)."/";
$WebMS["WebMSUrl"]          	=$WebMS["RootUrl"]  ."AutoSys/";
$WebMS["SystemPath"]         	=$WebMS["WebMSPath"]."System/";
$WebMS["SystemUrl"]          	=$WebMS["WebMSUrl"] ."System/";
$WebMS["TempPath"]          	=$WebMS["WebMSPath"]."Temp/";
$WebMS["TempUrl"]           	=$WebMS["WebMSUrl"] ."Temp/";
$WebMS["AdminPath"]         	=$WebMS["WebMSPath"]."Admin/";
$WebMS["AdminUrl"]          	=$WebMS["WebMSUrl"] ."Admin/";
$WebMS["ThemesPath"]        	=$WebMS["WebMSPath"]."Themes/";
$WebMS["ThemesUrl"]         	=$WebMS["WebMSUrl"] ."Themes/";
$WebMS["DBPath"]            	=$WebMS["WebMSPath"]."db/";
$WebMS["UserFunctionsPath"] 	=$WebMS["WebMSPath"]."Functions/";
$WebMS["UserFunctionsUrl"]  	=$WebMS["WebMSUrl"] ."Functions/";
$WebMS["UserModulesPath"]   	=$WebMS["WebMSPath"]."Modules/";
$WebMS["UserModulesUrl"]    	=$WebMS["WebMSUrl"] ."Modules/";
$WebMS["UserJSPath"]        	=$WebMS["WebMSPath"]."JS/";
$WebMS["UserJSUrl"]         	=$WebMS["WebMSUrl"] ."JS/";
$WebMS["UserLayoutsPath"]   	=$WebMS["WebMSPath"]."Layouts/";
$WebMS["UserLayoutsUrl"]    	=$WebMS["WebMSUrl"] ."Layouts/";
$WebMS["CorePath"]          	=$WebMS["WebMSPath"]."Core/";
$WebMS["CoreUrl"]           	=$WebMS["WebMSUrl"] ."Core/";
$WebMS["IntPath"]          		=$WebMS["WebMSPath"]."Core/Integrations/";
$WebMS["IntUrl"]           		=$WebMS["WebMSUrl"] ."Core/Integrations/";
$WebMS["IncPath"]           	=$WebMS["CorePath"] ."Includes/";
$WebMS["IncUrl"]            	=$WebMS["CoreUrl"]  ."Includes/";
$WebMS["ModulesPath"]       	=$WebMS["CorePath"] ."Modules/";
$WebMS["ModulesUrl"]        	=$WebMS["CoreUrl"]  ."Modules/";
$WebMS["PagesPath"]         	=$WebMS["WebMSPath"] ."Pages/";
$WebMS["PagesUrl"]          	=$WebMS["WebMSUrl"]  ."Pages/";
$WebMS["JSPath"]            	=$WebMS["CorePath"] ."JS/";
$WebMS["JSUrl"]             	=$WebMS["CoreUrl"]  ."JS/";
$WebMS["ImagesUrl"]          	=$WebMS["WebMSUrl"]  ."Images/";
$WebMS["imgNumb"]			      	=0;

include_once $WebMS["IncPath"]."JSON.php";
include_once $WebMS["IncPath"]."String.php";
include_once $WebMS["IncPath"]."ResDB.php";
include_once $WebMS["IncPath"]."GetFolders.php";

//Read system settings from ResDB
$db=new ResDB("WebMSoptions");
	$WebMS["AdminPassword"]		=$db->get("adminpassword");
	$WebMS["DefaultSkin"]		=$db->get("defaultskin");
	$WebMS["GlobalLogo"]		=$db->get("logo_use");
	//Use a UMS?
	$WebMS["UMS"]				=$db->get("ums_use");
	
	//Integrations - true or false.
	$WebMS["Integrate"]			=$db->get("Integrate");
	//filename of integration script, ie. smf.php
	$WebMS["IntegrateScript"]	=$db->get("IntegrateScript");
	
	//define user variables
	$WebMS["User_ID"]			=0;
	$WebMS["User_Username"]		="";
	$WebMS["User_Password"]		="";
	$WebMS["User_Email"]		="";
	$WebMS["User_Name"]			="";
	$WebMS["User_Userlvl"]		=0;
	$WebMS["User_Datereg"]		="";
	$WebMS["User_Datelog"]		="";
	$WebMS["User_Sig"]			="";
	$WebMS["User_Avatar"]		="";
	
	//MySQL Configuration
	//Use MySQL? false or true
	$WebMS["MySQL_Use"]			=$db->get("MySQL_use");
	$WebMS["MySQL_Host"]		=$db->get("MySQL_host");
	$WebMS["MySQL_UserName"]	=$db->get("MySQL_user");
	$WebMS["MySQL_Password"]	=$db->get("MySQL_pass");
	$WebMS["MySQL_Database"]	=$db->get("MySQL_db");
	$WebMS["MySQL_Prefix"]		=$db->get("MySQL_pre");
	
	if (($WebMS["UMS"]) && ($WebMS["Integrate"])) {
		include($WebMS["IntPath"].$WebMS["IntegrateScript"]);	
	}
			


/**
 * ERROR REPORTER (NOTE)
 * Usually you would call the Error Handler first, however this script seems to cause the output of the PHP headers, which in turn fucks up integration scripts which require the headers for modification. So thats why its all the way down here :)
 */
include_once $WebMS["IncPath"]."error_reporter.php";
include_once $WebMS["IncPath"]."Module.php";
include_once $WebMS["IncPath"]."Template.php";
include_once $WebMS["IncPath"]."Theme.php";
include_once $WebMS["IncPath"]."Browser.php";
include_once $WebMS["IncPath"]."GDLib.php";
include_once $WebMS["IncPath"]."SQL.php";
include_once $WebMS["SystemPath"]."Makes.php";
?>