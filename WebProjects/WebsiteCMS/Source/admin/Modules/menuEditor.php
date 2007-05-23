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
	function expandMenu($mnu){
		for ($i=1;$i<=count($mnu);$i++){
			$val=$mnu[$i];
			if (ArrayMap::is($val)){
				if ($val->isMap("1")){
					$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
					?>
					<a style="display:block; text-decoration:none;" href="javascript:;" onclick="$('<?=$id?>').toggle();"><?=$val->get("name")?></a>
					<div id="<?=$id?>" style="display:;padding-left:10px">
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
