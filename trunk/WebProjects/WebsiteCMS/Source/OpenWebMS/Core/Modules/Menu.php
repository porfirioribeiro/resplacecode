<?php
/**
* Menu module<br>
* This module builds the menu from the DB
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright � 2007 ResPlace Team
* @lastedit 14-05-07
*/
global $WebMS;
class Menu extends Module {
	
	/**
	 * Modue Menu
	 * @param WebMS $page
	 * @return Menu
	 */
	function Menu($page){
		parent::Module($page);
		$this->side=Module::LEFT;
		$this->title="Menu";
		$this->db=new ResDB("Menu");
		$page->addCSS($page->config["ModulesUrl"]."Menu/Menu.css");

	}
	function expandMenu($mnu){
		for ($i=1;$i<=count($mnu);$i++){
			if (!isset($mnu[$i])){
				return;
			}
			$val=$mnu[$i];
			if (ArrayMap::is($val)){
				if ($val->isMap("1")){
					$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
					
					//read cookie
					if ((!isset($_COOKIE['MENU_'.$id.'_COOKIE'])) || ($_COOKIE['MENU_'.$id.'_COOKIE']=="none")) {
						$b="none";
						$c="section";
					} else {
						$b="block";
						$c="sectionOpen";
					}
					echo($val->get("icon"));
					?>
					
					<a id="MENU_ITEM_<?=$id?>" class="<?=$c ?>" style="display:block; text-decoration:none;" href="javascript:;" onclick="togglemenu('<?=$id?>')"><?=$val->get("name")?></a>
					<div class="section" id="MENU_PANEL_<?=$id?>" style="display:<?=$b?>;padding-left:10px">
					<?php
						$this->expandMenu($val);
					?>
					</div>
					<?php				
				}else{
					$name=$val->get("name");
					$url =$val->get("url"); 			
					?>
					<a class="sublink" href="<?=$val->get("url")?>"><?=$val->get("name")?></a>
					<?php	
				}
			}
		}
	}
	function content(){
	?>
		<div class="Menu">
		<?=$this->expandMenu($this->db)?>
		</div>
	<?php
	}
}
?>

