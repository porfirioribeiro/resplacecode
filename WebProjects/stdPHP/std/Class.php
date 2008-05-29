<?php

error_reporting(E_ALL);
/**
 * Standart implementation for proprieties, for get value
 * @param Klass $object
 * @param String $name
 * @return mixed
 */
function Klass_get($object, $name){
	$c=get_class($object)."_get_".$name;
	if (function_exists($c)){
		return call_user_func($c,$object);
	}
	if (method_exists($object,"_get_".$name)){
		return call_user_method("_get_".$name, $object);
	}
	if (method_exists($object,"_get")){
		return $object->_get($name);
	}
	if (function_exists(get_class($object)."_set_".$name) | method_exists($object,"_set_".$name) | method_exists($object,"_set")){
		$m="is write-only";
	}else{
		$m="doesnt exists";
	}
	trigger_error("The property <b>'$name'</b> $m, and theres no default getter assigned!",E_USER_ERROR);	
}
/**
 * Standart implementation for proprieties, for get value
 * @param Klass $object
 * @param String $name
 * @param mixed $value
 * @return mixed
 */
function Klass_set($object, $name, $value){
	$c=get_class($object);
	if (function_exists($c."_set_".$name)){
		return call_user_func($c."_set_".$name,$object);
	}
	if (method_exists($object,"_set_".$name)){
		return call_user_method("_set_".$name, $object);
	}
	if (method_exists($object,"_set")){
		return $object->_set($name);
	}
	if (function_exists($c."_get_".$name) | method_exists($object,"_get_".$name) | method_exists($object,"_get")){
		$m="is read-only";
	}else{
		$m="doesnt exists";
	}
	trigger_error("The property <b>'$name'</b> $m, and theres no default setter assigned!",E_USER_ERROR);	
}

function Klass_isset($object, $name){
	$c=get_class($object);
	return function_exists($c."_get_".$name) | method_exists($object,"_get_".$name) | function_exists($c."_set_".$name) | method_exists($object,"_set_".$name) | (method_exists($object,"_isset") && $object->_isset($name));
}
/**
 * Standar implementation for call's, let you defile extra functions outside class
 * @param Klass $object
 * @param String $name
 * @param array $arguments
 * @return mixed
 */
function Klass_call($object, $name, $arguments){
	$c=get_class($object)."_fn_".$name;
	array_unshift($arguments,$object);
	if (function_exists($c)){
		return call_user_func_array($c, $arguments);
	}	
}

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