<?php
class Menu extends Module {
	function Menu($page){
		parent::Module($page);
		$this->side=Module::TOP;
		$this->UseTPL=false;
	}
	function content(){
		?>
<div class="Toolbar">
	<a href="#">Inicio</a>
	<a href="#">Procura</a>
	<a href="#">Contactos</a>
	<a href="#">Localização</a>
</div>
		<?php
	}
}
?>