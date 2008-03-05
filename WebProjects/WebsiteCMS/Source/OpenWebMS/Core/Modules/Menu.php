<?php
/**
* Menu module<br>
* This module builds the menu from the DB
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 05-03-08
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
	function expandMenu($mnu,$par="",$id=0){
		global $WebMS;
		?>
		
		<?php
		for ($i=1;$i<=count($mnu);$i++){
			if (!isset($mnu[$i])){
				return;
			}
			$val=$mnu[$i];
			if (ArrayMap::is($val)){
				if ($val->isMap("1")){
					$id=preg_replace(array("/-/","/ /"),"_",(($par=="")?"":"$par"."_").$val->get("name"));
					//read cookie
					if ((!isset($_COOKIE['MENU_'.$id.'_COOKIE'])) || ($_COOKIE['MENU_'.$id.'_COOKIE']=="none")) {
						$b="none";
						$c="folder closed alpha";
					} else {
						$b="block";
						$c="folder open alpha";
					}
					?>
					<div class="group">
					<a id="MENU_ITEM_<?=$id?>" class="<?=$c ?>"  style="display:block; text-decoration:none;" href="javascript:;" onclick="togglemenu('<?=$id?>')"><?=$val->get("name")?></a>
					</div>
					<div class="section alpha" id="MENU_PANEL_<?=$id?>" style="display:<?=$b?>;">
					<div>
					<?php
						$this->expandMenu($val,$val->name,$id);
					?>
					</div>
					</div>
					<?php				
				}else{
					$name=$val->get("name");
					$url =$val->get("url"); 
					$icon=$val->get("icon");
					$AddClass="";
					$AddClass2="";
					//Is url {lol,lol}?
					
					$FLet=substr($url,0,1);
					$LLet=substr($url,-1);

					if ($FLet=="{" && $LLet=="}") {
						//Special URL
						$arrs=substr($url,1,-1);
						$arr=explode(",",$arrs);
						$url=url($arr);	
						
						//Are we on this page NOW?
						if ($arr==$WebMS['URLArray']) {
							$AddClass="selitem";
							$AddClass2="sellink";
							if (!$id==0)
								echo"<script type=\"text/javascript\" language=\"JavaScript\">forcevisible('$id');</script>";
						}
					} else {
						//grab the ?...
						$str='?'.$_SERVER['QUERY_STRING'];
						$str2=explode("?",$url);
						if (isset($str2[1])) {
							$str2=="?".$str2[1];
						} else {
							$str2="";	
						}
						if ($str==$url || $str==$str2) {
							$AddClass="selitem";
							$AddClass2="sellink";
							if (!$id==0)
								echo"<script type=\"text/javascript\" language=\"JavaScript\">forcevisible('$id');</script>";
						}
					}
					?>
					<div class="item alpha <?=$AddClass; ?>">
					<a class="link alpha <?=$AddClass2; ?>" style="<?=($icon)?"background-image: URL($icon);":""?>" href="<?=$url ?>"><?=$val->get("name")?></a>
					</div>
					<?php	
				}
			}
		}
		?>
		
		<?php		
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