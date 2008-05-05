<?php
class ArrayExt extends ArrayObject {
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
}

class Attributes extends ArrayExt {
	function Attributes($array){
		parent::__construct($array);
	}
	function toAttStr(){
		$res="";
		foreach ($this as $key => $value) {
			$res.=" ".$key.'="'.$value.'"';
		}
		return $res;
	}
	function __toString(){
		return $this->toAttStr();
	}
}

class DOMStyle extends ArrayExt {
	function DOMStyle($css){
		$this->addCSS($css);
	}
	function get($name, $default=""){
		if ($this->__isset($name)){
			return $this->__get($name);
		}
		return $default;
	}
	function set($name, $value){
		$this->__set($name,$value);
	}
	function has($name){
		return $this->__isset($name);
	}
	function clean(){
		$this->__construct(array());
	}
	function addCSS($css){
		$styles=explode(";",$css);
		foreach ($styles as $style) {
			if (!empty($style)){
				$arr=preg_split("/ *: */",$style);
				if (count($arr)==2){
					$this[$arr[0]]=$arr[1];	
				}	
			}
		}		
	}
	function setCss($css){
		$this->clean();
		$this->addCSS($css);
	}
	function isEmpty(){
		return count($this)==0;
	}
	function toStyleStr(){
		$str="";
		foreach ($this as $name=>$value){
			$str.=$name.": ".$value.";";
		}
		return $str;
	}
	function __toString(){
		return $this->toStyleStr();
	}
}

class Widget {
	static $ALL_IDS=array();
	static $UID=array();
	var $att=array();
	var $style;
	var $rendered=false;
	var $tag="div";
	var $name="Widget";
	var $jsClass="pw.Widget";
	var $stdAttributes="id|class|name|title|onclick|onmousedown|style";
	function Widget($args=array()){
		$this->att=new Attributes($this->att);
		if (!isset(Widget::$UID[$this->name])){
			Widget::$UID[$this->name]=0;
		}
		$this->att->id=$this->name.Widget::$UID[$this->name]++ ;
		$this->parseStdAttributes($args);
		$this->style=new DOMStyle($this->att->style);
		unset($this->att["style"]);
		Widget::$ALL_IDS[$this->id]=$this;
		if (isset($args["bounds"])){
			$b=preg_split("/\||,| /",$args["bounds"]);
			$s=$this->att->style;
			$abs=false;
			if (isset($b[0]) && $b[0]!=""){
				$this->setStyle("left",$b[0]);
				//$s=preg_replace('/(^\\w)*left:\\w*(;|\\s|$)/', '', $s)."left: {$b[0]}px;";
				$abs=true;
			}
			if (isset($b[1]) && $b[1]!=""){
				$this->setStyle("top",$b[1]);
				//$s=preg_replace('/(^\\w)*top:\\w*(;|\\s|$)/', '', $s)."top: {$b[1]}px;";
				$abs=true;
			}
			if (isset($b[2]) && $b[2]!=""){
				$this->setStyle("width",$b[2]);
				//$s=preg_replace('/(^\\w)*width:\\w*(;|\\s|$)/', '', $s)."width: {$b[2]}px;";
			}
			if (isset($b[3]) && $b[3]!=""){
				$this->setStyle("height",$b[3]);
				//$s=preg_replace('/(^\\w)*height:\\w*(;|\\s|$)/', '', $s)."height: {$b[3]}px;";
			}
			if ($abs){
				$this->setStyle("position","absolute");
				//$s=preg_replace('/(^\\w)*position:\\w*(;|\\s|$)/', '', $s)."position: absolute;";
			}
			//$this->att->style=$s;
		}
		if (isset($args["margins"])){
			
		}
	}
	function parseStdAttributes($array){
		foreach ($array as $key => $value) {
			if (preg_match('/^('.$this->stdAttributes.')$/', $key)) {
				if (($p=strpos($key,"on"))!==false && $p==0){
					$value = preg_replace('/([^\w]|^)this([^\\w])/', '$1'.$this->toJSElement().'$2', $value);
					$value = preg_replace_callback('/([^\w]|^)\$\{(\w*)\}([^\w]|$)/', create_function('$m','
						if (isset(Widget::$ALL_IDS[$m[2]]) && is_object(Widget::$ALL_IDS[$m[2]])){
							return $m[1].Widget::$ALL_IDS[$m[2]]->toJSElement().$m[3];
						}
						return $m[1]."null".$m[3];						
					'), $value);
				}
				$this->att[$key]=$value;
			}
		}
	}
	function open(){
		$tag="<".$this->tag;
		$tag.=$this->att->toAttStr();
		if (!$this->style->isEmpty()){
			$tag.=' style="'.$this->style.'"';
		}
		$tag.=">";
		return $tag;
	}
	function create(){
		return "";
	}
	function close(){
		return "</".$this->tag.">\n";
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
	function toJSElement(){
		return '$C(\''.$this->jsClass.'\',\''.$this->att->id.'\')';
	}
	function __toString(){
		if (!$this->rendered){
			$this->rendered=true;
			return $this->toTag();
		}else{
			return $this->toJSElement();
		}

	}
	function getStyle($style){
		return $this->style->get($style);
	}
	function setStyle($style,$value){
		$this->style->set($style,$value);
	}
	function addCss($css){
		$this->style->addCss($css);
	}
}
?>