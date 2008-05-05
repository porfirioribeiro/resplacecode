<?php
session_start();
$_SESSION["PW_CSS_INC"]=array();
$_SESSION["PW_JS_INC"]=array();
	
class PW{
	static $parser;
	static $parsing=false;
	static function requireCSS($file){
		$_SESSION["PW_CSS_INC"][]=$file;	
	}
	static function requireJS($file){
		$_SESSION["PW_JS_INC"][]=$file;			
	}
	static function createTags(){
		$s=dirname(__FILE__).DIRECTORY_SEPARATOR."srv.php";
		echo '
			<link rel="stylesheet" href="'.$s.'?css" type="text/css">
			<script type="text/javascript" src="'.$s.'?js"></script>
		';		

	}
	static function initParser(){
		$parser=xml_parser_create();
		xml_set_element_handler($parser,array(PW,"startTag"),array(PW,"endTag"));
		xml_set_default_handler($parser,array(PW,"tagBody"));
		return $parser;
	}
	
	static function parseFile($f){
		$parser=PW::initParser();
		xml_parse($parser,file_get_contents($f));
		$error=xml_get_error_code($parser);
		if ($error){
			die("PHP widgets xml parse error!!File: $f Error: ".xml_error_string($error));
		}			
		PW::close($parser);
	}
	
	static function startParse(){
		PW::$parser=PW::initParser();
		PW::$parsing=true;
		ob_start();
	}
	
	static function stopParse(){
		if (PW::$parsing){
			$data=ob_get_clean();
			if (!preg_match("/^\s*$/",$data)){
				xml_parse(PW::$parser,$data,true);
				$error=xml_get_error_code(PW::$parser);
				if ($error){
					die("PHP widgets xml parse error!! Error: ".xml_error_string($error));
				}				
			}
			PW::$parsing=false;				
		}
		PW::close(PW::$parser);
	}
	
	static function close($parser){
		xml_parser_free($parser);		
	}
	
	//tag functions
	private static function startTag($parser,$name,$attrs){
		$name=strtolower($name);
		//testing stuff
		if ($name=="pw:include"){
			PW::parseFile($attrs["FILE"]);
		}
		$attrsl="";
		foreach ($attrs as $k => $v) {
			$k=strtolower($k);
			$attrsl.=" $k=\"$v\"";
		}
		echo "<$name$attrsl>";		
	}
	private static function endTag($parser,$name){
		$name=strtolower($name);
		echo "</$name>";		
	}
	private static function tagBody($parser,$data){
		echo $data;
	}
}

function __autoload($cl){
	$d=dirname(__FILE__).DIRECTORY_SEPARATOR;
	$ns=preg_split("/_/",$cl);
	if (count($ns)>1){
		$cn=$ns[1];	
		$ns=strtolower($ns[0]);
		$d.=$ns.DIRECTORY_SEPARATOR;
	}else{
		$cn=$ns[0];
	}

	$f=$cn.".php";
	$df=$d.$cn.DIRECTORY_SEPARATOR;

	if (is_file($df.$f)){
		include_once($df.$f);
		if (is_file($df.$cl.".css")){
			PW::requireCSS($df.$cl.".css");
		}
		if (is_file($df.$cl.".js")){
			PW::requireJS($df.$cl.".js");
		}
	}else if (is_file($d.$f)){
		include_once($d.$f);
	}
	if (class_exists($cl)){
		return;
	}
		die("$df$f - $d$f - $ns - $cl");
	die("Cant find class!!.".$cl);
}

//PW::requireJS("js/prototype.js");
PW::requireJS("js/dollar.js");
PW::requireJS("js/Element.js");
PW::requireJS("js/Enumerable.js");
PW::requireJS("js/Eventable.js");
PW::requireJS("js/prototypes.js");
PW::requireJS("js/pw.js");
?>

