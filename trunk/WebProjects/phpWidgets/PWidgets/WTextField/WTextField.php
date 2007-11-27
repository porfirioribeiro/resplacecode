<?php
class WTextField extends WInlinePanel {
	var $name="WTextField";
	var $jsClass="pw.WTextField";
	var $label;
	var $input;
	function WTextField($args=array()){
		$this->tag="span";
		parent::Widget($args);
		$text=(isset($args["label"]))?$args["label"]:"";	
		$value=(isset($args["value"]))?$args["value"]:"";	
		
		$this->label=new WLabel(array("id"=>$this->id.":label", "text"=>$text));
		$this->input=new WInput(array("id"=>$this->id.":input", "type"=>"text", "value"=>$value));
		$this->setStyle("width","120%");
	}
	function create(){
		return $this->label."<br>".$this->input;
	}
}
?>