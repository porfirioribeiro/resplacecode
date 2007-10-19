<?php
/**
* Last Forum Topics module<br>
* This module list the latest forum topicss
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 12-05-07
*/

class Lfp extends Module {
	function Lfp($page){
		$this->page=$page;
		$this->title="Last Forum Posts";
		$this->side=Module::RIGHT;
	}
	function content(){
	?>
		Nothing yet here :p<br>
		Maybe use SSI or RSS<br>
		Don't know yet<br>
		oh btw this module is included in a external file ;)<br>
		$page->addModuleFromFile<br>("Last Forum Posts",<br>"lfp.php");	
	<?php
	}
}
?>


