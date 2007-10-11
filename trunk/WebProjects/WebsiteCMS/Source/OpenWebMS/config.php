<?php
/**
* OpenWebMS Configuration File
* This file loads all "super global" variables, aswell as post-run scripts
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 21-09-07
*/

error_reporting(E_ALL); 

global $WebMS;
$WebMS=array();
$WebMS["FailSafeLogin"]				="openwebms";
$WebMS["Version"]				="0.1|BETA";
//url formats:
//Normal		- ?p=blah&amp;c=blah&amp;a=blah
//CleanDots		- ?blah.blah.huh.yey
$WebMS["URLFormat"]				="CleanDots";
$WebMS["RootPath"]          	=preg_replace("/\\\/","/",preg_replace("/OpenWebMS$/","",dirname(__FILE__)));
$WebMS["RootUrl"]           	=str_replace($_SERVER["DOCUMENT_ROOT"], "", $WebMS["RootPath"]);
$WebMS["WebMSPath"]         	=$WebMS["RootPath"] ."OpenWebMS/";
$WebMS["WebMSUrl"]          	=$WebMS["RootUrl"]  ."OpenWebMS/";
$WebMS["FilesPath"]         	=$WebMS["WebMSPath"]."Files/";
$WebMS["FilesUrl"]          	=$WebMS["WebMSUrl"] ."Files/";
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

//used for GDLib
$WebMS["imgNumb"]				=0;

class Conf{
  static $conf;
  function get($key){
  	return Conf::$conf[$key];
  }
  function set($key,$value){
  	Conf::$conf[$key]=$value;
  }
  function __get($key){
  	return Conf::$conf[$w];
  }
  function __set($key,$value){
  	Conf::$conf[$key]=$value;
  }
}
Conf::$conf;

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
include_once $WebMS["IncPath"]."DBMS.php";

?>