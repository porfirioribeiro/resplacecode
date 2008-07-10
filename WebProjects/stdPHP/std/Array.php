<?php
include_once "String.php";
class ArrayExt extends ArrayObject implements IKlass, IteratorAggregate {
	function ArrayExt($arr=array())	{
		if (is_array($arr)){
			parent::__construct($arr);
		}else if ($arr instanceof ArrayExt){
			parent::__construct($arr->toArray());
		}else{
			return parent::__construct(func_get_args());			
		}
	}

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
	/**
	 * Rebuilds this object with a new array;
	 * @param array $array
	 * @return ArrayExt
	 */
	function fromArray($array){
		$this->__construct($array);
		return $this;//sometimes we liek a bit of recursion
	}
	function append($arr){
		return $this->fromArray(array_merge($this->toArray(),(array)$arr));
	}
	function push($lement1=null, $element2=null){
		return $this->append(func_get_args());
	}
	function join($delimiter=""){
		return st(implode($delimiter,$this->toArray()));
	}
	/**
	 * Reverse this array or a new copy
	 * @param bool $new
	 * @return ArrayExt
	 */
	function reverse($new=false){
		$arr=array_reverse($this->toArray());
		if ($new){
			return arr($arr);
		}
		return $this->fromArray($arr);
	}
	/**
	 * Returns the first index at which the specified element can be found in the array.
	 * Returns -1 if the element is not present.
	 * @param mixed $searchElement
	 * @param int $fromIndex
	 * @return mixed
	 */
	function indexOf($searchElement, $fromIndex=0){
		$index=0;
		foreach ($this->toArray() as $key => $value) {
			if ($index>=$fromIndex && $value==$searchElement){
				return $key;
			}
			$index++;
		}
		return -1;
	}
	/**
	 * Searches an array backwards starting from fromIndex and returns the last index at which the specified element can be found in the array.
	 * Returns -1 if the element is not present.
	 * @param mixed $searchElement
	 * @param int $fromIndex
	 * @return mixed
	 */
	function lastIndexOf($searchElement, $fromIndex=0){
		return $this->reverse(true)->indexOf($searchElement, $fromIndex);
	}
	/**
	 * Executes the specified function once for each element in an array.
	 * @param function $callback
	 * @param bool $recursive
	 * @return ArrayExt
	 */
	function each($callback, $recursive=false){
		if (!is_callable($callback)){
			throw new UnexpectedValueException("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {                 //void too much recursion and server crashes
			if ($recursive && $value instanceof ArrayExt && $value!=$this){
				$value->each($callback, $recursive);
			}else if (call_user_func($callback,$value,$key,$this)===false){
				return $this;
			}
		}
		return $this;
	}
	/**
	 * Returns true if every element in an array meets the specified criteria.
	 * @param function $callback
	 * @param bool $recursive
	 * @return bool
	 */
	function every($callback, $recursive=false){
		if (!is_callable($callback)){
			throw new UnexpectedValueException("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {                 //void too much recursion and server crashes
			if ($recursive && $value instanceof ArrayExt && $value!=$this){
				if (!$value->every($callback, $recursive)){
					return false;
				}
			}else if (!call_user_func($callback,$value,$key,$this)){
				return false;
			}
		}
		return true;
	}
	/**
	 * Returns true if some element in the array passes the test implemented by the provided function.
	 * @param function $callback
	 * @param bool $recursive
	 * @return bool
	 */
	function some($callback, $recursive=false){
		if (!is_callable($callback)){
			throw new UnexpectedValueException("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {                 //void too much recursion and server crashes
			if ($recursive && $value instanceof ArrayExt && $value!=$this){
				if ($value->some($callback, $recursive)){
					return true;
				}
			}else if (call_user_func($callback,$value,$key,$this)){
				return true;
			}
		}
		return false;
	}
	/**
	 * Creates a new array with all elements that meet the specified criteria.
	 * @param function $callback
	 * @param bool $recursive
	 * @return ArrayExt
	 */
	function filter($callback, $recursive=false){
		$class=get_class($this);
		$arr= new $class();
		if (!is_callable($callback)){
			throw new UnexpectedValueException("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {                 //void too much recursion and server crashes
			if ($recursive && $value instanceof ArrayExt && $value!=$this){
				$arr->append($value->filter($callback, $recursive));
			}else if (call_user_func($callback,$value,$key,$this)){
				$arr[$key]=$value;
			}
		}
		return $arr;		
	}
	function map($callback, $recursive=false){
		$class=get_class($this);
		$arr= new $class();
		if (!is_callable($callback)){
			throw new UnexpectedValueException("Invalid datatype expected");
		}
		foreach ($this as $key => $value) {                 //void too much recursion and server crashes
			if ($recursive && $value instanceof ArrayExt && $value!=$this){
				$arr[$key]=$value->map($callback, $recursive);
			}else {
				$arr[$key]=call_user_func($callback,$value,$key,$this);
			}
		}
		return $arr;		
	}

	function limit($offset, $limit=null){
		return new LimitIterator($this->getIterator(),$offset,($limit==null)?count($this):$limit);
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
 * @param mixed $arr
 * @return ArrayExt
 */
function arr($arr=array()){
	if ($arr instanceof ArrayExt) {
		return $arr;
	}else if (is_array($arr)){
		return new ArrayExt($arr);
	}else if (is_string($arr)){
		return new ArrayExt(explode(" ",$arr));
	}
	return new ArrayExt(func_get_args());
}


function ArrayExt_get_serialized($self){
	return serialize($self->array);
}

$n="\n<br>";

function _callback($value, $key, $array){
	if (is_numeric($value)){
		return $value*2;
	}
}

class MyArr extends ArrayExt {

}

$arr=new MyArr("nice","i like");

//print_r($arr->map(@array("Str","toUpperCase"),true));


$it=arr(array(10,12,13,15));



?>
