<?php
class Attributes extends ArrayObject {
	function Attributes($array){
		parent::__construct($array);
	}
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
	function toArray(){
		return $this->getArrayCopy();
	}
	function fromArray($array){
		$this->__construct($array);
	}
	function append($arr){
		$this->fromArray(array_merge($this->getArrayCopy(),$arr));
	}
	function toAttStr(){
		$res="";
		foreach ($this as $key => $value) {
			$res.=" ".$key.'="'.$value.'"';
		}
		return $res;
	}

}

class Widget {
	static $UID=array();
	var $att=array();
	var $rendered=false;
	var $tag="div";
	var $name="Widget";
	var $jsClass="pw.Widget";
	var $stdAttributes="id|class|name|title|onclick|style";
	function Widget($args=array()){
		$this->att=new Attributes($this->att);
		if (!isset(Widget::$UID[$this->name])){
			Widget::$UID[$this->name]=0;
		}
		$this->att->id=$this->name.Widget::$UID[$this->name]++ ;
		$this->parseStdAttributes($args);

		if (isset($args["bounds"])){
			$b=preg_split("/,/",$args["bounds"]);
			$s=$this->att->style;
			$abs=false;
			if (isset($b[0]) && $b[0]!=""){
				$s=preg_replace('/(^\\w)*left:\\w*(;|\\s|$)/', '', $s)."left: {$b[0]}px;";
				$abs=true;
			}
			if (isset($b[1]) && $b[1]!=""){
				$s=preg_replace('/(^\\w)*top:\\w*(;|\\s|$)/', '', $s)."top: {$b[1]}px;";
				$abs=true;
			}
			if (isset($b[2]) && $b[2]!=""){
				$s=preg_replace('/(^\\w)*width:\\w*(;|\\s|$)/', '', $s)."width: {$b[2]}px;";
			}
			if (isset($b[3]) && $b[3]!=""){
				$s=preg_replace('/(^\\w)*height:\\w*(;|\\s|$)/', '', $s)."height: {$b[3]}px;";
			}
			if ($abs){
				$s=preg_replace('/(^\\w)*position:\\w*(;|\\s|$)/', '', $s)."position: absolute;";
			}
			$this->att->style=$s;
		}
	}
	function parseStdAttributes($array){
		foreach ($array as $key => $value) {
			if (preg_match('/^('.$this->stdAttributes.')$/', $key)) {
				if (($p=strpos($key,"on"))!==false && $p==0){
					$value = preg_replace('/([^\w]|^)this([^\\w])/', '$1'.'$C(\''.$this->jsClass.'\',\''.$this->att->id.'\')'.'$2', $value);
				}
				$this->att[$key]=$value;
			}
		}
		return $att;
	}
	function open(){
		$tag="<".$this->tag;
		$tag.=$this->att->toAttStr();

		$tag.=">\n";
		return $tag;
	}
	function create(){
		return "";
	}
	function close(){
		return "\n</".$this->tag.">\n";
	}
	function __get($name){
		switch ($name) {
			case "id":
				return $this->att->id;
				break;
			case "el":
				return '$(\''.$this->att->id.'\')';
				break;
			default:
				;
				break;
		}
	}
	function toTag(){

	}
	function __toString(){
		if (!$this->rendered){
			$this->rendered=true;
			return $this->toTag();
		}else{
			return '$C(\''.$this->jsClass.'\',\''.$this->att->id.'\')';
		}

	}
	function getStyle($style){
		if (preg_match('/(^|;|\\s)'.$style.':\\s*(\\w*)(;|$)/', $this->att->style, $regs)) {
			return print_r($regs[2]);
		} else {
			return "";
		}
	}
	function setStyle($style,$value){
		if ($this->getStyle($style)==""){
			$this->att->style.=$style.": ".$value.";";
		}else{
			$this->att->style = preg_replace('/(^|;|\\s)('.$style.':)\\s*(\\w*)(;|$)/', '$1$2 '.$value.";", $this->att->style);
		}
	}
}
?>