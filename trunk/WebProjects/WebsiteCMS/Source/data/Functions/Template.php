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
	/** @var String The default patern */
	const patern="#{*}:#[*]";
	/** @var String The Patern */
	var $patern=Template::patern;
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
		$paterns=preg_split("/:/",$this->patern);
		$varpt=preg_split("/\*/",$paterns[0]);
		$fnpt=preg_split("/\*/",$paterns[1]);
		$result=$this->template;
		if (class_exists("ArrayMap") && ArrayMap::is($object)){
			foreach ($object->listPaths() as $value) {
				$result=preg_replace("/".$varpt[0].$value.$varpt[1]."/",$object->getPath($value),$result);
			}
		}else if (is_array($object)){
			foreach ($object as $key => $value) {
				$result=preg_replace("/".$varpt[0].$key.$varpt[1]."/",$value,$result);
			}
		}
		return $result;
	}
}
?>