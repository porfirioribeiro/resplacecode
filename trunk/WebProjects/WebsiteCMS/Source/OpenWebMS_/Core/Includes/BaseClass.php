<?php
BaseClass::$_config="cool";
class BaseClass{
	static $_config;
	var $config;
	function __construct(){
		$this->config=BaseClass::$_config;
	}
	function __toString(){
		return __CLASS__."::";
	}
}
class Class2 extends BaseClass {
	function Class2(){
		parent::__construct();
		echo $this->config;
	}
}
echo new Class2();

?>