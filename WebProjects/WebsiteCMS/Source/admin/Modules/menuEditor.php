<?php

class menuEditor extends Module {
	/** 
	 * @var ResDB 
	 */
	var $db;
	function menuEditor($page){
		parent::Module($page);
		$this->title="Menu editor";
		$this->side=Module::CENTER;
		$this->db=new ResDB($this->page->path."db/Menu.db");
	}
	function finish(){
		$this->db->close();
	}
	function expandMenu($mnu,$path){
		for ($i=1;$i<=count($mnu);$i++){
			$val=$mnu[$i];
			if (ArrayMap::is($val)){
				if ($val->isMap("1")){
					$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
					?>
					+<?=$val->get("name")?>
					
					<div id="<?=$id?>" style="display:;padding-left:10px">
					<?php
					
						$this->expandMenu($val,$path+"."+$i);
					?>
					</div>
					<?php				
				}else{
					$name=$val->get("name");
					$url =$val->get("url"); 			
					?>
					- <?=$i.$name?>-<?=$url?>"
					<br>
					<?php	
				}
			}
		}
	}
	function content(){
	?>
		<?=$this->expandMenu($this->db,"")?>
	<?php
	}
}

?>
