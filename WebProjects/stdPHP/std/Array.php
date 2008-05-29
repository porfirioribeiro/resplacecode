<?php
include_once "String.php";
class ArrayExt extends ArrayObject implements IKlass {
	/**
	 * Used for properties
	 * @internal 
	 */
	function __get($name){
		return Klass_get($this,$name);
	}
	/**
	 * Used for properties
	 * @internal 
	 */
	function __set($name, $value){
		return Klass_set($this, $name, $value);
	}
	/**
	 * Used for properties
	 * @internal 
	 */
	function __isset($name){
		return Klass_isset($this, $name);
	}
	/**
	 * Used for user functions
	 * @internal 
	 */
	function __call($name, $arguments){
		return Klass_call($this, $name, $arguments);
	}
	/**
	 * @internal 
	 */
	function __unset($name){
		if (isset($this[$name])){
			unset($this[$name]);
		}
	}	
	/**
	 * @internal 
	 */
	function _get($name){
		return $this->_isset($name)?$this[$name]:null;
	}
	/**
	 * @internal 
	 */
	function _set($name, $value){
		$this[$name]=$value;
	}
	/**
	 * @internal 
	 */
	function _isset($name){
		return isset($this[$name]);
	}
	/**
	 * @internal 
	 */
	function __toString(){
		return print_r($this,true);
	}
	function get($name, $default=null){
		return $this->_isset($name)?$this[$name]:$default;
	}
	function set($name, $value){
		$this->_set($name, $value);
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
	function each($callback){
		if (!is_callable($callback)){
			throw new Exception("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {
			call_user_func($callback,$value,$key,$this);
		}
		
	}
	/**
	 * @internal 
	 */
	function _get_length(){
		return count($this);
	}
	/**
	 * @internal 
	 */
	function _get_empty(){
		return count($this)==0;
	}
	/**
	 * @internal 
	 */
	function _get_array(){
		return $this->getArrayCopy();
	}

}
/**
 * Checks or creates
 * @param unknown_type $arr
 * @return ArrayExt
 */
function arext($arr){
	if ($arr instanceof ArrayExt) {
		return $arr;
	}else if (is_array($arr)){
		return new ArrayExt($arr);
	}else if (is_string($arr)){
		return new ArrayExt(explode(" ",$arr));
	}
	
	
}

function ArrayExt_get_serialized($self){
	return serialize($self->array);
}
function _callback($value, $key, $array){
	echo "$key = $value <br>";
}
arext("nice ass you have")->each("_callbac");
?>