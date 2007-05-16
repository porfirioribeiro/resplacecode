<?php
/**
* Skin Changer module<br>
* This module allows a visitor to select which skin to use on the website
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright © 2007 ResPlace Team
* @lastedit 12-05-07
*/

class SkinChanger extends Module {
	function SkinChanger($page){
		$this->page=$page;
		$this->side=Module::RIGHT;
		$this->title="Change Skin";
	}
	function content(){
	?>
	This will test the change skin (external) module. Lets see :D	
    <?php
	if ($_REQUEST['page']) {?>
	<form name="ChangeSkin" method="POST" action="<?=$_SERVER['PHP_SELF'].'?page='.$_REQUEST['page']; ?>">
    <?php
	}else{?>
	<form name="ChangeSkin" method="POST" action="<?=$_SERVER['PHP_SELF']; ?>">
    <?php } ?>
	  <select name="SkinMenu" onchange="ChangeSkin.submit()">
			<?php
			
			//get themes		
			$contents=GetFolders($this->page->themespath);
			if(is_array($contents)){
				foreach($contents as $item){
					$itemi=$item;
					$item=str_replace(array("-","_"),array(" "," "),$item);
					
					//pick out default skin
					if ($item==$this->page->defaultskin){
						$item=$item." (Default)";
					}
					
					//start group
					if($item != '.' && $item != '..'){
						echo "<optgroup label='{$item}'>";
						
						//get styles for the theme...
						$contents2=GetFolders($this->page->themespath.$itemi."/");
						
						if(is_array($contents2)){
							foreach($contents2 as $item2){
								$itemi2=$item2;
								$item2=str_replace(array("-","_"),array(" "," "),$item2);
								
								if ($itemi.'/'.$itemi2.'/'==$this->page->selectedskin){
									echo "<option selected value='{$itemi}/{$itemi2}/'>{$item2}</option>";
								}else{
									if($item2 != '.' && $item2 != '..'){	
										echo "<option value='{$itemi}/{$itemi2}/'>{$item2}</option>";
									}
								}
							}
						}
						
						//end group
						echo"</optgroup>";
					}
				}
			}
			?>
		</select>
	</form>
	
	Skin: <?=$this->page->selectedskin; ?><?php		
	}
}

?>
<?php

//Finally add our copywright to the thanksto array :)
//$this->credits[]="<a href='http://tpvgames.co.uk' title='Dean Williams'>Skin Changer 0.1</a>";
?>
