<?php
class untitled extends Module {
	function untitled($page){
		parent::Module($page);
		$this->title="Page's Management";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		test
		<?php
		}
	}
?>
