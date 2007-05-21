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
	function evaluate($object){
		$result=$this->template;
		if (class_exists("ArrayMap") && ArrayMap::is($object)){
			foreach ($object->listPaths() as $value) {
				$result=preg_replace("/".$this->patern[0].$value.$this->patern[1]."/",$object->getPath($value),$result);
			}
		}else if (is_array($object)){
			foreach ($object as $key => $value) {
				$result=preg_replace("/".$this->patern[0].$key.$this->patern[1]."/",$value,$result);
			}
		}
		return $result;
	}
	function parse($object){
		return $this->evaluate($object);
	}
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