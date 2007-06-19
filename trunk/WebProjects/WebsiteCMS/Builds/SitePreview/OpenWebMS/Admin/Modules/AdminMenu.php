<?php
class AdminMenu extends Module {
	function AdminMenu($page){
		parent::Module($page);
		$this->title="Admin Menu";	
		$this->side=Module::LEFT;	
	}
	function content(){
		?>
		Nothig yet
		<?
	}
}
?>