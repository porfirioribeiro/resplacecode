<?php
global $WebMS;
$WebMS=array();
$WebMS["RootPath"]          =preg_replace("/\\\/","/",preg_replace("/OpenWebMS$/","",dirname(__FILE__)));
$WebMS["RootUrl"]           =str_replace($_SERVER["DOCUMENT_ROOT"], "", $WebMS["RootPath"]);
$WebMS["WebMSPath"]         =$WebMS["RootPath"] ."OpenWebMS/";
$WebMS["WebMSUrl"]          =$WebMS["RootUrl"]  ."OpenWebMS/";
$WebMS["FilesPath"]         =$WebMS["WebMSPath"]."Files/";
$WebMS["FilesUrl"]          =$WebMS["WebMSUrl"] ."Files/";
$WebMS["TempPath"]          =$WebMS["WebMSPath"]."Temp/";
$WebMS["TempUrl"]           =$WebMS["WebMSUrl"] ."Temp/";
$WebMS["AdminPath"]         =$WebMS["WebMSPath"]."Admin/";
$WebMS["AdminUrl"]          =$WebMS["WebMSUrl"] ."Admin/";
$WebMS["ThemesPath"]        =$WebMS["WebMSPath"]."Themes/";
$WebMS["ThemesUrl"]         =$WebMS["WebMSUrl"] ."Themes/";
$WebMS["DBPath"]            =$WebMS["WebMSPath"]."db/";
$WebMS["UserFunctionsPath"] =$WebMS["WebMSPath"]."Functions/";
$WebMS["UserFunctionsUrl"]  =$WebMS["WebMSUrl"] ."Functions/";
$WebMS["UserModulesPath"]   =$WebMS["WebMSPath"]."Modules/";
$WebMS["UserModulesUrl"]    =$WebMS["WebMSUrl"] ."Modules/";
$WebMS["UserJSPath"]        =$WebMS["WebMSPath"]."JS/";
$WebMS["UserJSUrl"]         =$WebMS["WebMSUrl"] ."JS/";
$WebMS["CorePath"]          =$WebMS["WebMSPath"]."Core/";
$WebMS["CoreUrl"]           =$WebMS["WebMSUrl"] ."Core/";
$WebMS["IncPath"]           =$WebMS["CorePath"] ."Includes/";
$WebMS["IncUrl"]            =$WebMS["CoreUrl"]  ."Includes/";
$WebMS["ModulesPath"]       =$WebMS["CorePath"] ."Modules/";
$WebMS["ModulesUrl"]        =$WebMS["CoreUrl"]  ."Modules/";
$WebMS["JSPath"]            =$WebMS["CorePath"] ."JS/";
$WebMS["JSUrl"]             =$WebMS["CoreUrl"]  ."JS/";

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
include_once $WebMS["IncPath"]."error_reporter.php";
include_once $WebMS["IncPath"]."ResDB.php";
include_once $WebMS["IncPath"]."GetFolders.php";
//include_once $WebMS["IncPath"]."LoadSkin.php";
include_once $WebMS["IncPath"]."Module.php";
include_once $WebMS["IncPath"]."Template.php";
include_once $WebMS["IncPath"]."Theme.php";	
include_once $WebMS["IncPath"]."Browser.php";
include_once $WebMS["IncPath"]."GDLib.php";	


?>
