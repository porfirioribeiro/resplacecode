<?php
class PW_inlinepanel extends Widget {
	var $name="PW_inlinepanel";
	function toTag(){
		return $this->open().$this->create().$this->close();
	}	
}
?>