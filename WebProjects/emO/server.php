<?php
include "inc/JSON.php";
class serv{
	/**
	 * Internal JSON class
	 * @var Services_JSON
	 */
	var $json=null;
	function serv(){
		$this->json=new Services_JSON();
	}
	function __call($name, $args){
		return $this->_error(0,"Sorry the function $name was not defined!");
	}
	function _return($v){
		$ret="";
		if (is_bool($v)){
			$ret.="{type:bool}";
		}else if (is_numeric($v)){
			$ret.="{type:number}";
		}else if (is_string($v)){
			$ret.="{type:string}";
		}else if (is_array($v) || is_object($v)){
			$ret.="{type:json}";
		}else if (is_null($v)){
			$ret.="{type:null}";
		}
		return $ret.$this->json->encode($v);
	}
	function _error($code, $m){
		return "{type:error}{code:$code}$m";
	}
	function sayHello($args){
		return $this->_return($args[0]);
	}
}

$_USE=$_GET;


if (isset($_USE["fn"])){
	$args=array_keys($_USE);
	array_shift($args);
	$serv= new serv();
	echo $serv->$_USE["fn"]($args);
}
?>