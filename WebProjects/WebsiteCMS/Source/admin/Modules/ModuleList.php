<?php
class ModuleList extends Module {
	function ModuleList($page){
		parent::Module($page);
		$this->title="Module List";		
		$this->side=Module::LEFT;
	}
	function content(){
		?>
		Nothig yet
		<?
	}
}
?>