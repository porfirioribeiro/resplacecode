<?php
/**
* Template class<br>
* This class allow for templates to operate
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright © 2007 ResPlace Team
* @lastedit 12-05-07
*/
class Template{
	/** @var String The Patern */
	var $patern=array("#{","}");
	/** @var String The Template */
	var $template="";
	var $globalContext=array();
	/**
	 * Create a new Template object
	 * @param string $template The template to parse
	 * @param string $patern The patern that would be used to parse the template 
	 */
	function Template($template=null,$patern=null){
		if ($template){
			$this->template=$template;
		}
		if ($patern){
			$this->patern=$patern;
		}
	}
	/**
	 * Evaluates the Template and returns the result
	 * @param mixed $object The object to fill the template, either Array or ArrayMap
	 * @return String The result of the combination with patern and $object
	 */
	function evaluate($object_){
		global $object;
		$object=array_merge($this->globalContext,$object_);
		$result=$this->template; 
		function evalPHP($m){
			eval('$r='.$m[1].";");
			return $r;
		}
		$result=preg_replace_callback('/\?\{([^\{\{\}]*)\}/',evalPHP,$result);
		/*function parse($m){
			die(print_r($m,true));
		}
		$result=preg_replace_callback('/\#\{([^\{\{\}]*)\}/',parse,$result);
		function ifCallback($m){
			die(print_r($m,true));
		}
		$result=preg_replace_callback('/\#\{(IF|if)([^\{\{\}]*)\}/',ifCallback,$result);*/
		function iifCallback($m){
			global $object;
			if ($object[$m[1]]){
				return $m[2];
			}else{
				return $m[3];
			}
		}		
		function ifElseCallback($m){
			print_r($m);
		}
		$result=preg_replace_callback("/#\{iif:(.*),(.*),(.*)\}/i",iifCallback,$result);
		$result=preg_replace_callback("/#\{if:(.*)\}\s*(.*)\s*#\{else\}\s*(.*)\s*#\{endif\}/i",iifCallback,$result);
		//$result=preg_replace("/".$st."if:".$key.$ed."\s*(.*)\s*".$st."endif:".$key.$ed."/",($value)?'${1}':'',$result);
		return $result;
	}
	function parse($object){
		return $this->evaluate($object);
	}
	/**
	 * Get one template inside other
	 * @param String $part
	 * @return Template
	 */
	function get($part){
		$stexp=$this->patern[0]."start:".$part.$this->patern[1];
		$enexp=$this->patern[0]."end:".$part.$this->patern[1];
		$start=strpos($this->template,$stexp);
		$end=strpos($this->template,$enexp);
		$tpl="";
		if ($start!==false && $end!==false){
			$start+=strlen($stexp);
			$tpl=substr($this->template,$start,$end-$start);
		}
		return new Template($tpl);
	}
	function isPart($part){
		$stexp=$this->patern[0]."start:".$part.$this->patern[1];
		$enexp=$this->patern[0]."end:".$part.$this->patern[1];
		$start=strpos($this->template,$stexp);
		$end=strpos($this->template,$enexp);
		return ($start!==false && $end!==false);
	}
}

class TplFile extends Template {
	function TplFile($file,$patern=null){
		$this->template=file_get_contents($file);
		if ($patern){
			$this->patern=$patern;
		}		
	}
}
?>