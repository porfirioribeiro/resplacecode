<?php
session_start();
include "DOM.php";
include "Tag.php";
include "Widget.php";
$_SESSION["PW_CSS_INC"]=array();
$_SESSION["PW_JS_INC"]=array();

class PWParser {
	var $xmlParser;
	var $file;
	var $realFile;
	var $linesBefore=0;
	var $stack=array();
	var $depth=0;
	function PWParser($file="", $linesBefore=0){
		$this->file=$file;
		$this->realFile=realpath($file);
		$this->linesBefore=$linesBefore;
		$this->xmlParser=xml_parser_create();
		xml_set_element_handler($this->xmlParser,array($this,"startTag"),array($this,"endTag"));
		xml_set_default_handler($this->xmlParser,array($this,"tagBody"));
	}
	function parse($data){
		xml_parse($this->xmlParser,$data,true);
		$this->checkError();
	}
	function parseFile(){
		if (!is_file($this->file)){
			$this->showError("File Not Found");
		}else{
			$data=file_get_contents($this->file);
			$this->parse($data);
		}
	}
	function checkError(){
		$error=xml_get_error_code($this->xmlParser);
		if ($error){
			$this->showError(xml_error_string($error));
		}
	}
	function showError($error="Unknow Error", $message=null){
		$m="PHP widgets xml parse error!!<br>";
		if ($message!=null){
			$m.=$message."<br>";
		}
		$m.="<b>Error:</b> ".$error."<br>";
		$m.="<b>File:</b> $this->file<br>";
		$m.="<b>At line:</b> ".($this->linesBefore+xml_get_current_line_number($this->xmlParser)).", <b>Column:</b> ".xml_get_current_column_number($this->xmlParser)."<br>";
		echo('<p style="background-color:RGB(255,121,121);border: 1px solid black;padding:5px;">'.$m.'</p>');
	}
	function __destruct(){
		xml_parser_free($this->xmlParser);
	}

	//tag functions
	private function startTag($parser,$name,$attrs){
		$name=strtolower($name);
		$class=Widget;
		$full=explode(":",$name);
		if (count($full)>1){
			$ns=$full[0];
			$nm=$full[1];
			$class=$ns."_".$nm;
			$dir=dirname(__FILE__).DIRECTORY_SEPARATOR.$ns.DIRECTORY_SEPARATOR;
			$fn1=$dir.$nm.".php";
			$fn2=$dir.$nm.DIRECTORY_SEPARATOR.$nm.".php";
			if (!class_exists($class)){
				if (is_file($fn1)){
					include $fn1;
				}else if (is_file($fn2)){
					include $fn2;
				}
				//die($class);
				if (!class_exists($class)){
					$class=Widget;
					$this->showError("Tag Not Found! Tag: $name");
				}
			}
		}
		$w=new $class($this, $name, new DOMAttributes($attrs));
		$this->stack[count($this->stack)] = $w;
		$this->depth++;
	}
	private function tagBody($parser,$data){
		$this->stack[$this->depth-1]->body($data);
	}
	private function endTag($parser,$name){
		$this->stack[$this->depth-1]->end();
		array_pop($this->stack);
		$this->depth--;
	}
}

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

	static function parseFile($f){
		$p= new PWParser($f);
		$p->parseFile();
		return $p;
	}

	static function startParse($ln=0){
		$bt=debug_backtrace();
		PW::$parser=new PWParser($bt[0]["file"],$bt[0]["line"]);
		PW::$parsing=true;
		ob_start();
	}

	static function stopParse(){
		if (PW::$parsing){
			$data=ob_get_clean();
			if (!preg_match("/^\s*$/",$data)){
				PW::$parser->parse($data);
			}
			PW::$parsing=false;
		}
		PW::$parser=null;
	}
	
	static function tag($name,$args){
	
	}
}

/*function __autoload($cl){
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
 */
//PW::requireJS("js/prototype.js");
PW::requireJS("js/dollar.js");
PW::requireJS("js/Element.js");
PW::requireJS("js/Enumerable.js");
PW::requireJS("js/Eventable.js");
PW::requireJS("js/prototypes.js");
PW::requireJS("js/pw.js");
?>

