<?php

error_reporting(E_ALL);
/**
 * Standart implementation for properties, for get value
 * @param Klass $object
 * @param String $name
 * @return mixed
 */
function Klass_get($object, $name){
	$setter=false;
	$class=get_class($object);
	do{
		if (function_exists($class."_get_".$name)){
			return call_user_func($class."_get_".$name, $object);
		}	
		if (function_exists($class."_set_".$name)){
			$setter=true;
		}	
	}while($class=get_parent_class($class));
	if (method_exists($object,"_get_".$name)){
		return call_user_method("_get_".$name, $object);
	}
	if (method_exists($object,"_get")){
		return $object->_get($name);
	}
	if ($setter | method_exists($object,"_set_".$name) | method_exists($object,"_set")){
		$m="Write-only";
	}else{
		$m="Undefined";
	}
	$trace = debug_backtrace();
	trigger_error("$m property: <b>\"$name\"</b> in  {$trace[0]['file']} on line {$trace[0]['line']}",E_USER_NOTICE);
	return null;
}
/**
 * Standart implementation for properties, for get value
 * @param Klass $object
 * @param String $name
 * @param mixed $value
 * @return mixed
 */
function Klass_set($object, $name, $value){
	$getter=false;
	$class=get_class($object);
	do{
		if (function_exists($class."_set_".$name)){
			return call_user_func($class."_set_".$name, $object, $value);
		}	
		if (function_exists($class."_get_".$name)){
			$getter=true;
		}	
	}while($class=get_parent_class($class));
	if (method_exists($object,"_set_".$name)){
		return call_user_method("_set_".$name, $object, $name, $value);
	}
	if (method_exists($object,"_set")){
		return $object->_set($name, $name, $value);
	}
	if ($getter | method_exists($object,"_get_".$name) | method_exists($object,"_get")){
		$m="Read-only";
	}else{
		$m="Undefined";
	}
	$trace = debug_backtrace();
	trigger_error("$m property: <b>\"$name\"</b> in  {$trace[0]['file']} on line {$trace[0]['line']}",E_USER_NOTICE);
	return null;
}
/**
 * Standart implementation for properties, for check if a key exists
 * @param Klass $object
 * @param String $name
 * @return bool
 */
function Klass_isset($object, $name){
	$class=get_class($object);
	do{
		if (function_exists($class."_set_".$name) | function_exists($class."_get_".$name)){
			return true;
		}		
	}while($class=get_parent_class($class));
	return method_exists($object,"_get_".$name) | method_exists($object,"_set_".$name) | (method_exists($object,"_isset") && $object->_isset($name));
}
/**
 * Standar implementation for call's, let you define extra functions outside class
 * @param Klass $object
 * @param String $name
 * @param array $arguments
 * @return mixed
 */
function Klass_call($object, $name, $arguments){
	$class=get_class($object);
	do{
		if (function_exists($class."_fn_".$name)){
			array_unshift($arguments,$object);
			return call_user_func_array($class."_fn_".$name, $arguments);
		}		
	}while($class=get_parent_class($class));	
	if (method_exists($object,"_call")){
		return $object->_call($name, $arguments);
	}
	$trace = debug_backtrace();
	trigger_error("Undefined method: <b>\"$name\"</b> in  {$trace[0]['file']} on line {$trace[0]['line']}",E_USER_NOTICE);
	return null;
}
/**
 * Use this interface for create classes that use properties
 * Use this when you need to extend other class and can't extend Klass
 * Use the code of Klass
 */
interface IKlass{
	function __get($name);
	function __set($name, $value);
	function __call($name, $arguments);
	function __isset($name);
}

class Klass implements IKlass {
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
}

?>