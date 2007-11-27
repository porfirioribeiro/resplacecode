<?php
class WInlinePanel extends Widget {
	var $name="WInlinePanel";
	function toTag(){
		return $this->open().$this->create().$this->close();
	}	
}
?>