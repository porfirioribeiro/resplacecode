<?php
include_once "String.php";

class RegExp extends Klass {
	/**
	 * The internal expression
	 * @var String
	 */
	var $re;
	function RegExp($str="//"){
		$this->re=st($str);
	}
	function grep($input, $flags=null){
		return preg_grep($this,$input,$flags);
	}
	
	function __toString(){
		return $this->re."";
	}
}

function re($re){
	if ($re instanceof RegExp){
		return $re;
	}
	return new RegExp($re);
}

echo re("/nice/");
?>