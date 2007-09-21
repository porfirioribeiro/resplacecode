<?php
/**
* Menu module<br>
* This module builds the menu from the DB
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright � 2007 ResPlace Team
* @lastedit 14-05-07
*/

class Menu extends Module {
	function Menu($page){
		$this->page=$page;
		$this->side=Module::LEFT;
		$this->title="Menu";
		$this->db=new ResDB("Menu");
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
					} else {
						$b="block";
					}
					
					?>
					<a style="display:block; text-decoration:none;" href="javascript:;" onclick="$('<?=$id?>').toggle(); togglemenu($('<?=$id?>'),'MENU_<?=$id?>_COOKIE')"><?=$val->get("name")?></a>
					<div id="<?=$id?>" style="display:<?=$b?>;padding-left:10px">
					<?php
						$this->expandMenu($val);
					?>
					</div>
					<?php				
				}else{
					$name=$val->get("name");
					$url =$val->get("url"); 			
					?>
					<a style="display:block;" href="<?=$val->get("url")?>"><?=$val->get("name")?></a>
					<?php	
				}
			}
		}
	}
	function content(){
	?>
		<?=$this->expandMenu($this->db)?>
	<?php
	}
}
?>

