<?php
class WLabel extends WInlinePanel {
	var $name="WLabel";
	var $text="";
	function WLabel($args=array()){
		$this->tag="label";
		$this->stdAttributes.="|for";
		parent::Widget($args);
		if (isset($args["text"])){
			$this->text=$args["text"];
		}
	}
	function create(){
		return $this->text;
	}
}
?>