<?php
class String{
	var $string;
	function String($str=""){
		$this->string=$str;
	}
	static function _match($string,$what){
		return preg_match("/$what/",$string);
	}
	function match($what){
		return String::_match($this->string,$what);
	}
	static function _startsWith($string,$start){
		return String::_match($string,"^".preg_quote($start));
	}
	function startsWith($start){
		return String::_startsWith($this->string,$start);
	}
	static function _endsWith($string,$end){
		return String::_match($string,preg_quote($arg0)."$");
	}
	function endsWith($end){
		return String::_endsWith($end);
	}
	static function _contains($string,$what){
		return String::_match($string,preg_quote($what));
	}
	function contains($what){
		return String::_contains($what);
	}	
	static function _inside($string,$start,$end){
		return String::_startsWith($string,$start) && String::_endsWith($string,$end);
	}
}
?>