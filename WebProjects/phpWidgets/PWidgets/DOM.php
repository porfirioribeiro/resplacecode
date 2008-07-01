<?php
class ArrayExt extends ArrayObject {
	function __get($name){
		if (isset($this[$name])){
			return $this[$name];
		}else{
			return "";
		}
	}
	function __set($name,$value){
		$this[$name]=$value;
	}
	function __isset($name){
		return isset($this[$name]);
	}
	function __unset($name){
		unset($this[name]);
	}
	function get($name, $default=""){
		if ($this->__isset($name)){
			return $this->__get($name);
		}
		return $default;
	}
	function set($name, $value){
		$this->__set($name,$value);
	}
	function has($name){
		return $this->__isset($name);
	}
	function clean(){
		$this->__construct(array());
	}
	function isEmpty(){
		return count($this)==0;
	}	
	/**
	 * Return an array of this object
	 * @return array 
	 */
	function toArray(){
		return $this->getArrayCopy();
	}
	function fromArray($array){
		$this->__construct($array);
	}
	function append($arr){
		$this->fromArray(array_merge($this->getArrayCopy(),$arr));
	}
}

class DOMAttributes extends ArrayExt {
	function DOMAttributes($array){
		foreach ($array as $k => $v) {
			$k=strtolower($k);
			$this[$k]=$v;
		}
	}
	
	function getValid($name,$match,$default=""){
		$v=$this->get($name, $default);
		if (!preg_match("/^($match)$/",$v)){
			$v=$default;
		}
		return $v;
	}
	
	function toAttStr(){
		$res="";
		foreach ($this as $key => $value) {
			$res.=" ".$key.'="'.$value.'"';
		}
		return $res;
	}
	function __toString(){
		return $this->toAttStr();
	}
}

class DOMStyle extends ArrayExt {
	function DOMStyle($css){
		$this->addCSS($css);
	}
	
	function addCSS($css){
		$styles=explode(";",$css);
		foreach ($styles as $style) {
			if (!empty($style)){
				$arr=preg_split("/ *: */",$style);
				if (count($arr)==2){
					$this[$arr[0]]=$arr[1];	
				}	
			}
		}		
	}
	function setCss($css){
		$this->clean();
		$this->addCSS($css);
	}

	function toStyleStr(){
		$str="";
		foreach ($this as $name=>$value){
			$str.=$name.": ".$value.";";
		}
		return $str;
	}
	function __toString(){
		return $this->toStyleStr();
	}
}

?>