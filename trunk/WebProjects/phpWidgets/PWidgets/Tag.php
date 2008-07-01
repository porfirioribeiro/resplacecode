<?php
class PWTag{
	/**
	 * This is the parser on this class is used
	 * @var PWParser
	 */
	var $parser;
	var $ns;
	var $name;
	var $args;
	var $aceptedArgs="*";
	var $requredArgs="";
	/**
	 * The constructor of class, you dont need to subclass it, use start()
	 * @param PWParser $parser
	 * @param string $name
	 * @param DOMAttributes $args
	 * @return PWTag
	 */
	function PWTag($parser, $name, $args ){
		$this->parser=$parser;
		$this->name=$name;
		$full=explode(":",$name);
		if (count($full)>1){
			$this->ns=$full[0];
			$this->name=$full[1];
		}
		$this->args=$args;
		if ($this->aceptedArgs!="*"){
			foreach ($args->toArray() as $name => $value) {
				if (!preg_match("/(^|\|)$name(\||$)/",$this->aceptedArgs)){
					$this->parser->showError("Wrong Parameters","You passed some unacepted parameters to tag $this->name. Acepted parameters are:<br>$this->aceptedArgs");
					return;//stop
				}
			}
		}
		if ($this->requredArgs!=""){
			foreach(explode("|",$this->requredArgs) as $arg){
				$ar=$args->toArray();
				if (!isset($ar[$arg])){
					$this->parser->showError("Missing required arguments", "You must set this args: $args");	
					return;
				}				
			}
		}
		$this->start($args);
	}
	/**
	 * Tag function, its called when a tag of this type is found it constructs the object and also processes the 
	 * arguments
	 * @param DOMAttributes $args
	 * @return PWTag
	 */
	function start($args){
		
	}
	/**
	 * This function is called everytime character data is found inside tag
	 * It can be called many times!!
	 * @param array $data
	 */
	function body($data){
		
	}
	/**
	 * This function is called when the end of the tag is found
	 */
	function end(){
		
	}
	/**
	 * Loads a tag and writes it to the page
	 *
	 * @param string $name
	 * @param array $attrs
	 * @return PWTag
	 */
	function tag($name, $attrs=null, $html=""){
		if ($attrs==null){
			$attrs=array();
		}
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
					$this->parser->showError("Tag Not Found! Tag: $name");
				}
			}
		}
		$w=new $class($this, $name, new DOMAttributes($attrs));
		if ($html!=""){
			$w->body($html);
		}
		return $w;		
	}
	function tagEnd($name, $attrs=null, $html=""){
		$this->tag($name,$attrs,$html)->end();
	}
}


?>