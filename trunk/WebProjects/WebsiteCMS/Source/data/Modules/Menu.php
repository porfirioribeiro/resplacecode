<?php
/**
* Menu module<br>
* This module builds the menu from the DB
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright © 2007 ResPlace Team
* @lastedit 14-05-07
*/

class Menu extends Module {
	function Menu($page){
		$this->page=$page;
		$this->side=Module::LEFT;
		$this->title="Menu";
		$this->db=new ResDB(dirname(__FILE__)."/../db/Menu.db");
	}
	function expandMenu($mnu){
		for ($i=1;$i<=count($mnu);$i++){
			$val=$mnu[$i];
			if (ArrayMap::is($val)){
				if ($val->isMap("1")){
					$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
					?>
					<a style="display:block; text-decoration:none;" href="javascript:;" onclick="$('<?=$id?>').toggle();"><?=$val->get("name")?></a>
					<div id="<?=$id?>" style="display:none;padding-left:10px">
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
				//if ()
				//expandMenu($val->getArray());
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

