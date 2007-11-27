<?php
class WPanel extends Widget {
	var $name="WPanel";
	function toTag(){
		return $this->open().$this->create();
	}
}
?>