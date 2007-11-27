<?php
class WInput extends WInlinePanel {
	var $name="WInput";
	var $jsClass="pw.WInput";
	function WInput($args=array()){
		$this->tag="input";
		$this->stdAttributes.="|value|type";
		parent::Widget($args);

	}

	function close(){
		return "";
	}
}
?>