<?php
session_start();
$_SESSION["PW_CSS_INC"]=array();
$_SESSION["PW_JS_INC"]=array();
	
class PWidgets{
	static function requireCSS($file){
		$_SESSION["PW_CSS_INC"][]=$file;	
	}
	static function requireJS($file){
		$_SESSION["PW_JS_INC"][]=$file;			
	}
	static function createCSSTag(){
		
	}
}

function __autoload($cl){
	$d=dirname(__FILE__)."/";

	$f=$cl.".php";
	$df=$d.$cl.DIRECTORY_SEPARATOR;
	if (is_file($df.$f)){
		include_once($df.$f);
		if (is_file($df.$cl.".css")){
			PWidgets::requireCSS($df.$cl.".css");
		}
		if (is_file($df.$cl.".js")){
			PWidgets::requireJS($df.$cl.".js");
		}
	}else if (is_file($d.$f)){
		include_once($d.$f);
	}
	if (class_exists($cl)){
		return;
	}
	die("Cant find class!!.".$cl);
}

//PWidgets::requireJS("js/prototype.js");
PWidgets::requireJS("js/dollar.js");
PWidgets::requireJS("js/Element.js");
PWidgets::requireJS("js/Enumerable.js");
PWidgets::requireJS("js/Eventable.js");
PWidgets::requireJS("js/prototypes.js");
PWidgets::requireJS("js/pw.js");
?>

