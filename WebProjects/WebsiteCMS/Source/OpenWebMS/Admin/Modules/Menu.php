<?php

class Menu extends Module {
	/** 
	 * @var ResDB 
	 */
	var $db;
	function Menu($page){
		parent::Module($page);
		$this->title="Menu editor";
		$this->side=Module::CENTER;
		$this->db=new ResDB("Menu");
		$this->page->addCSS("/owms/OpenWebMS/Core/Modules/Menu/Menu.css");
		global $WebMS;
		if (isset($WebMS['URLArray'][2])){
			switch ($WebMS['URLArray'][2]) {
				case "Ren":
					$this->page->addAlert("ba","Rename not impemented yet<br>".$_GET["text"]);
				break;
				
				default:
					;
				break;
			}			
		}

		
	}
	function finish(){
		$this->db->close();
	}
	function expandMenu($mnu,$path,$pad){
		for ($i=1;$i<=count($mnu);$i++){
			if (isset($mnu[$i])){
				$val=$mnu[$i];
				$p=(($path=="")?"":$path.".").$i;
				if (ArrayMap::is($val)){
					if ($val->isMap("1")){
						$id=preg_replace(array("/-/","/ /"),"_",$val->get("name"));
						?>
						<tr>
							<td style="padding-left: <?=$pad ?>px">
								<a class="section" onclick="alert('<?=$p?>')"><?=$val->get("name")?></a>
							</td>
							<td>
							</td>
						</tr>
						
						
						<?php
						
							$this->expandMenu($val,$p,$pad+13);
						?>
						<!--div id="<?=$id?>" class="section" style="display:;padding-left:10px">
						</div-->
						<?php				
					}else{
						$name=$val->get("name");
						$url =$val->get("url"); 			
						?>
						<tr>
							<td style="padding-left: <?=$pad ?>px">
									<?php
										if (isset($val["icon"])){
											?>
											<img src="<?=$val["icon"]?>">
											<?	
										}else{
											?>
											<div style="width:15px;float:left;">&nbsp;</div>
											<?	
										}
										$u=preg_split("/\./",$p.".text");
										$u=array_merge(array("*","Menu","Ren"),$u);
									?>
								<a onclick="var m=$('ID_MENU_<?=$p ?>');b=$(this).getBounds();b.y-=3;b.x-=3;b.width=80;m.setBounds(b);m.value=this.innerHTML;m.show();setTimeout(function(){m.activate();},1);"><?=$val->get("name")?></a>
								<input name="text" id="ID_MENU_<?=$p ?>" style="display: none;position: absolute;" onblur="$(this).hide();" onkeydown="e=doEvent(event);if(e.key==27){this.blur()}if(e.key==13){this.form.action='<?=url($u) ?>';this.blur();this.form.submit()}">
							</td>
							<td>	
								<?=$url?>
							</td>
						</tr>
						<?php	
					}
				}				
			}

		}
	}
	function content(){
	?>
		<table class="Menu tbl" border="0" cellpadding="3" cellspacing="0">
		<form method="post" action="<?=url(array("*","Menu")) ?>" id="MENU_EDIT_FORM">
		<?=$this->expandMenu($this->db,"",0)?>
		</form>
		</table>
	<?php
	}
}

$page->add("Menu");

?>
