<?php
include_once "Class.php";

/**
 * Class with static functions
 */
class Str {
	function is($var){
		return is_string($var) | $var instanceof String;
	}
	/**
	 * Returns the character at the specified index.
	 * @param string $string
	 * @param int $index
	 * @return String
	 */
	function charAt($string, $index){
		$string.="";
		return st($string[$index]);
	}
	/**
	 * Returns the Unicode of the character at a specified position.
	 * @param String $string
	 * @param int $index
	 * @return int
	 */
	function charCodeAt($string, $index){
		$string.="";
		return ord($string[$index]);
	}
	/**
	 * Is used to join two or more strings.
	 * @param String $string
	 * @param String $string2
	 * @return String
	 */
	function concat($string, $string2){
		return st(implode("",func_get_args()));
	}
	/**
	 * Returns the position of the first occurrence of a specified string value in a string.
	 * @param String $string
	 * @param String $searchvalue
	 * @param int $fromindex
	 * @return int
	 */
	function indexOf($string, $searchValue, $fromIndex=0){
		$p=strpos($string,$searchValue,$fromIndex);
		return ($p===false)?-1:$p;
	}
	/**
	 * Returns the position of the last occurrence of a specified string value, searching backwards from the specified position in a string.
	 * @param String $string
	 * @param String $searchValue
	 * @param int $fromIndex
	 * @return int
	 */
	function lastIndexOf($string, $searchValue, $fromIndex=0){
		$p=strrpos($string,$searchValue,$fromIndex);
		return ($p===false)?-1:$p;
	}
	/**
	 * Searches for a specified value in a string
	 * @param String $string
	 * @param mixed $searchValue
	 * @return String
	 */
	function match($string, $searchValue){
		if (Str::is($searchValue)){
			return (Str::indexOf($string,$searchValue)!=-1)?st($searchValue):null;
		}else{
			return null;//TODO implement RegEx on match
		}
	}
	/**
	 * Its used to replace some characters with some other characters in a string.
	 * @param String $string
	 * @param mixed $find
	 * @param String $newString
	 * @return String
	 */
	function replace($string, $find, $newString){
		if (Str::is($find)){
			return str_replace($find, $newString,$string);
		}else{
			return "";//TODO implement RegEx on replace
		}
	}
	/**
	 * Its used to search a string for a specified value.
	 * @param String $string
	 * @param mixed $find
	 * @return int
	 */
	function search($string, $find){
		if (Str::is($find)){
			return Str::indexOf($string, $find);
		}else{
			return -1;//TODO implement RegEx on search
		}
	}
	/**
	 * Extracts a part of a string and returns the extracted part in a new string.
	 * @param String $string
	 * @param int $start
	 * @param int $end optional
	 * @return String
	 */
	function slice($string, $start, $end=null){
		if ($end!=null){
			return st(substr($string, $start, $end-$start));
		}else{
			return st(substr($string, $start));
		}
	}
	/**
	 * Its used to split a string into an array of strings.
	 * @param mixed $string
	 * @param String $separator
	 * @param int $howmany
	 * @return array TODO use ArrayObject or other
	 */
	function split($string, $separator, $howmany=null){
		if (Str::is($separator)){
			if ($howmany){
				return explode($separator, $string, $howmany);
			}
			return explode($separator, $string);
		}else{
			return null;//TODO implement RegEx on split
		}
	}
	/**
	 * Extracts a specified number of characters in a string, from a start index.
	 * @param String $string
	 * @param int $start
	 * @param int $length
	 * @return String
	 */
	function substr($string, $start, $length=null){
		if ($length!=null){
			return st(substr($string, $start, $length));
		}else{
			return st(substr($string, $start));
		}		
	}
	/**
	 * Extracts the characters in a string between two specified indices.
	 * @see String#slice
	 * @param String $string
	 * @param int $start
	 * @param int $stop
	 * @return String
	 */
	function substring($string, $start, $stop=null){
		return Str::slice($string, $start, $stop);
	}
	/**
	 * Its used to display a string in lowercase letters.
	 * @param String $string
	 * @return String
	 */
	function toLowerCase($string){
		return st(strtolower($string));
	}
	/**
	 * Its used to display a string in uppercase letters.
	 * @param String $string
	 * @return String
	 */
	function toUpperCase($string){
		return st(strtoupper($string));
	}
	/**
	 * Check if two strings have the same value, optionaly it can ignoreCase
	 * @param String $string
	 * @param String $compare
	 * @param boolean $caseSensitive
	 * @return boolean
	 */
	function equals($string, $compare, $ignoreCase=false){
		return preg_match('/^'.$compare.'$/'.($ignoreCase?"i":""), $string)>0;
	}
	/**
	 * Check if the string starts with other string, optionaly it can ignoreCase
	 * @param String $string
	 * @param String $start
	 * @param boolean $ignoreCase
	 * @return boolean
	 */
	function startsWith($string, $start, $ignoreCase=false){
		return preg_match('/^'.$start.'.*$/'.($ignoreCase?"i":""), $string)>0;
	}
	/**
	 * Check if the string ends with other string, optionaly it can ignoreCase
	 * @param String $string
	 * @param String $end
	 * @param boolean $ignoreCase
	 * @return boolean
	 */
	function endsWith($string, $end, $ignoreCase=false){
		return preg_match('/^.*'.$end.'$/'.($ignoreCase?"i":""), $string)>0;
	}	
	
	function size($string){
		return strlen($string);
	}
	
	function isEmpty($string){
		return strlen($string)==0;
	}
	
	function isBlank($string){
		return preg_match("/^\s*$/",$string)>0;
	}
}

class String extends Klass {
	private $_str="";
	/**
	 * Creates this string
	 * @param string $str
	 * @return String
	 */
	function String($str=""){
		$this->_str=$str."";
	}
	/**
	 * @internal
	 */
	function __toString(){
		return $this->_str;
	}
	/**
	 * Returns the character at the specified index.
	 * @param int $index
	 * @return String
	 */
	function charAt($index){
		return Str::charAt($this,$index);
	}
	/**
	 * Returns the Unicode of the character at a specified position.
	 * @param int $index
	 * @return int
	 */
	function charCodeAt($index){
		return Str::charCodeAt($this,$index);
	}
	/**
	 * Is used to join two or more strings.
	 * @param String $string2
	 * @return String
	 */
	function concat($string2){
		return st($this.implode("",func_get_args()));
	}
	/**
	 * Returns the position of the first occurrence of a specified string value in a string.
	 * @param String $searchvalue
	 * @param int $fromindex
	 * @return int
	 */
	function indexOf($searchvalue, $fromindex=0){
		return Str::indexOf($this, $searchvalue, $fromindex);
	}
	/**
	 * Returns the position of the last occurrence of a specified string value, searching backwards from the specified position in a string.
	 * @param String $searchValue
	 * @param int $fromIndex
	 * @return int
	 */
	function lastIndexOf($searchValue, $fromIndex=0){
		return Str::lastIndexOf($this, $searchValue, $fromIndex);
	}
	/**
	 * Searches for a specified value in a string
	 * @param mixed $searchValue
	 * @return String
	 */
	function match($searchValue){
		return Str::match($this, $searchValue);
	}	
	/**
	 * Its used to replace some characters with some other characters in a string.
	 * @param mixed $find
	 * @param String $newString
	 * @return String
	 */
	function replace($find, $newString){
		return Str::replace($this, $find, $newString);
	}
	/**
	 * Its used to search a string for a specified value.
	 * @param mixed $find
	 * @return int
	 */
	function search($find){
		return Str::search($this, $find);
	}
	/**
	 * Extracts a part of a string and returns the extracted part in a new string.
	 * @param int $start
	 * @param int $end optional
	 * @return String
	 */
	function slice($start, $end=null){
		return Str::slice($this, $start, $end);
	}
	/**
	 * Its used to split a string into an array of strings.
	 * @param String $separator
	 * @param int $howmany
	 * @return array TODO use ArrayObject or other
	 */
	function split($separator, $howmany=null){
		return Str::split($this, $separator, $howmany);
	}	
	/**
	 * Extracts a specified number of characters in a string, from a start index.
	 * @param int $start
	 * @param int $length
	 * @return String
	 */
	function substr($start, $length=null){
		return Str::substr($this, $start, $length);		
	}
	/**
	 * Extracts the characters in a string between two specified indices.
	 * @see String#slice
	 * @param int $start
	 * @param int $stop
	 * @return String
	 */
	function substring($start, $stop=null){
		return Str::slice($this, $start, $stop);
	}		
	/**
	 * Check if two strings have the same value, optionaly it can ignoreCase
	 * @param String $compare
	 * @param boolean $caseSensitive
	 * @return boolean
	 */
	function equals($compare, $ignoreCase=false){
		return preg_match('/^'.$compare.'$/'.($ignoreCase?"i":""), $this)>0;
	}
	/**
	 * Check if the string starts with other string, optionaly it can ignoreCase
	 * @param String $start
	 * @param boolean $ignoreCase
	 * @return boolean
	 */
	function startsWith($start, $ignoreCase=false){
		return preg_match('/^'.$start.'.*$/'.($ignoreCase?"i":""), $this)>0;
	}
	/**
	 * Check if the string ends with other string, optionaly it can ignoreCase
	 * @param String $end
	 * @param boolean $ignoreCase
	 * @return boolean
	 */
	function endsWith($end, $ignoreCase=false){
		return preg_match('/^.*'.$end.'$/'.($ignoreCase?"i":""), $this)>0;
	}
	
	
	
	/**
	 * @alias String#length
	 * @internal
	 */
	function _get_length(){
		return strlen($this);
	}
	/**
	 * @alias String#upperCase
	 * @internal
	 */
	function _get_upperCase(){
		return st(strtoupper($this));
	}
	/**
	 * @alias String#lowerCase
	 * @internal
	 */
	function _get_lowerCase(){
		return st(strtolower($this));
	}
	/**
	 * @alias String#empty
	 * @internal
	 */
	function _get_empty(){
		return Str::isEmpty($this);
	}
	/**
	 * @alias String#blank
	 * @internal
	 */
	function _get_blank(){
		return Str::isBlank($this);
	}
}


/**
 * convert to String
 * @param mixed $var
 * @return String
 */
function st($var){
	if ($var instanceof String) {
		return $var;
	}
	return new String($var);
}
?>