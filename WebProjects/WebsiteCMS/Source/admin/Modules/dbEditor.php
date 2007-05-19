<?php
class dbEditor extends Module {
  var $fd;
  var $fdO;
  var $fda;	
  var $fdaO;	
	function dbEditor($page){
		parent::Module($page);
		$this->title="Database editor";
		$this->is->side=Module::CENTER;
  $this->fd=$this->page->path."Style/menu/folder.gif";	
  $this->fdO=$this->page->path."Style/menu/folderOpen.gif";	
  $this->fda=$this->page->path."Style/menu/folderAniClose.gif";	
  $this->fdaO=$this->page->path."Style/menu/folderAniOpen.gif";
	 $this->page->addPreloadImg($this->fd);
	 $this->page->addPreloadImg($this->fdO); 
	 $this->page->addPreloadImg($this->fda); 
	 $this->page->addPreloadImg($this->fdaO); 
	}
	function extend($map,$path){
		foreach ($map as $key=>$value) {
			$p=$path.(($path=="")?"":".").$key;		
			$id =str_replace(".","_",$p);				
			?>
			 <div style="margin-top:0px;">
			<?php
			 if (is_a($value,ArrayMap)){
				?>
				<img class="dbEditExpCollHandle" src="<?=$this->fd?>" onclick="var el=$('<?=$id?>');el.toggle();this.src=(el.style.display=='')?'<?=$this->fdaO?>':'<?=$this->fda?>';" style="cursor:pointer;">
				<?php
			 }else{
			 	echo "<span style='width:16px;text-align:center;display:block;float:left;'>| </span>";
			 }
			 ?>
			<a href="javascript:void(0)" onclick="var _Path_='<?=$p?>';var _Key_='<?=$key?>';var _P_=_Path_.replace(_Key_,'');var _K_=prompt('Select the name for this key','<?=$key?>');if (_K_!==null){document.location=location.search+'&action=editKey&path=<?=$p?>&newPath='+_K_}">
			 	<img alt="Rename" title="Rename this key" border="0" style="vertical-align:middle" src="icons/editclear.png">
			 </a>
			<a href="javascript:void(0)" onclick="var _Path_='<?=$p?>';if (confirm('You sure you want to delete this key?\n<?=$key?>')){document.location=location.search+'&action=delKey&path=<?=$p?>'}">
			 	<img alt="Delete" title="Delete this key" border="0" style="vertical-align:middle" src="icons/button_cancel.png">
			 </a>		
			 <?php
			 if (!is_a($value,ArrayMap)){
			 ?>			
				 <a href="javascript:void(0)" onclick="$('<?=$id."_edit"?>').toggle();//var _Path_='<?=$p?>';document.location=location.search+'&action=editValue&path=<?=$p?>'">
				 	<img alt="Edit" title="Edit the value of this key" border="0" style="vertical-align:middle" src="icons/edit.png">
				 </a>
			 <?php 
			 }
			 ?>
			<?=$key?>
			</div>
			<?php
			if (is_a($value,ArrayMap)){		
				echo '<div class="dbEditExpCollContainer" style="display:none;padding-left:13px;" id="'.$id.'">		';			
				$this->extend($value,$p);	
				echo "</div>";			
			}else{
				?>
				<form id="<?=$id."_edit"?>" style="margin-left:20px;display:none;" action="">
					<input type="hidden" name="action" value="setKey">
					<input type="hidden" name="place" value="<?=$_GET["place"]?>">
					<input type="hidden" name="db" value="<?=$_GET["db"]?>">
					<input type="hidden" name="path" value="<?=$p?>">	
					<textarea name="value"><?=$value?></textarea><br>
					<input type="button" value="Close" onclick="$(this.form).hide()">
					<input type="submit" value="Save">
				</form>				
				<?php	
			}			
		}
		?>
		<?php		
	}
	function content(){
		$root=str_replace("data/","",$this->page->path);
		$dbFile="../".$_GET["place"]."/db/".$_GET["db"];
		$dbPath=$_GET["place"]."/db/".$_GET["db"];
		if ($_GET["action"]=="addDB"){	
			$db=new ResDB($dbFile);
			$db->put("aaa","ok");
			$db->del("aaa");	
			$db->close();		
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']."?manage=dbEditor&action=editdb&place=".$_GET["place"]."&db=".$_GET["db"]?>";
			</script>
			<?php
		}else if ($_GET["action"]=="delDB"){
			unlink($dbFile);
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']?>";
			</script>
			<?php			
		}else if ($_GET["action"]=="renDB"){	
			copy($dbFile,$root.$_GET["place"]."/db/".$_GET["newDBname"]);
			unlink($dbFile);
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']."?manage=dbEditor&action=editdb&place=".$_GET["place"]."&db=".$_GET["newDBname"]?>";
			</script>
			<?php		
		}else if ($_GET["action"]=="editKey"){
			$db=new ResDB($dbFile);
			$db->renPath($_GET["path"],$_GET["newPath"]);
			$db->close();
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']."?manage=dbEditor&action=editdb&place=".$_GET["place"]."&db=".$_GET["db"]?>";
			</script>
			<?php			
		}else if ($_GET["action"]=="delKey"){
			$db=new ResDB($dbFile);
			$db->delPath($_GET["path"],$_GET["newPath"]);
			$db->close();
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']."?manage=dbEditor&action=editdb&place=".$_GET["place"]."&db=".$_GET["db"]?>";
			</script>
			<?php			
		}else if ($_GET["action"]=="editValue"){
			$db=new ResDB($dbFile);		
			?>
			<form action="">
				<input type="hidden" name="action" value="setKey">
				<input type="hidden" name="place" value="<?=$_GET["place"]?>">
				<input type="hidden" name="db" value="<?=$_GET["db"]?>">
				<input type="hidden" name="path" value="<?=$_GET["path"]?>">
				Edit the value of the key.<br>
				<textarea cols="40" rows="10" name="value"><?=$db->getPath($_GET["path"]);?></textarea><br>
				<input type="button" value="Back" onclick="history.back();">
				<input type="submit" value="Save">
			</form>
			<?php			
			$db->close();
		}else if ($_GET["action"]=="setKey"){
			$db=new ResDB($dbFile);
			$db->putPath($_GET["path"],$_GET["value"]);
			$db->close();
			?>
			<script type="text/javascript" language="javascript">
				document.location="<?=$_SERVER['PHP_SELF']."?manage=dbEditor&action=editdb&place=".$_GET["place"]."&db=".$_GET["db"]?>";
			</script>
			<?php			
		}else if ($_GET["action"]=="editdb"){		
			if (is_file($dbFile)){
				$db=new ResDB($dbFile);
				$this->fd=$this->page->path."Style/menu/folder.gif";	
				$fdO=$this->page->path."Style/menu/folderOpen.gif";	
			   $fda=$this->page->path."Style/menu/folderAniClose.gif";	
			   $this->fdaO=$this->page->path."Style/menu/folderAniOpen.gif";	
				?>
				Editing: <br>
				<a href="javascript:void(0)" onclick="var _K_=prompt('Select the name for this database\nDont forget the final .db','<?=$_GET["db"]?>');if (_K_!==null && _K_!==''){if (!_K_.endsWith('.db')){_K_+='.db'} document.location=location.search+'&action=renDB&newDBname='+_K_}">
					 <img alt="Rename" title="Rename this Database" border="0" style="vertical-align:middle" src="icons/editclear.png">
				</a>
				<a href="javascript:void(0)" onclick="if (confirm('Delete this Database?\n<?=$_GET["db"]?>')){document.location='?manage=dbEditor&action=delDB&place=<?=$_GET["place"]?>&db=<?=$_GET["db"]?>'}">
					 <img alt="Delete" title="Delete this Database" border="0" style="vertical-align:middle" src="icons/button_cancel.png">
				</a><?=$dbPath?><br><br>	
				Data:<br>
				<a href="javascript:;" style="color:blue;text-decoration: none;" onclick="if (this.__c===undefined){this.__c=true}var els=$$('.dbEditExpCollHandle');for (var i=0;i<els.length;i++){els[i].src=(this.__c)?'<?=$this->fdaO?>':'<?=$this->fda?>'}var elc=$$('.dbEditExpCollContainer');for (var i=0;i<elc.length;i++){elc[i][(this.__c)?'show':'hide']()}this.__c=!this.__c">
					<img class="dbEditExpCollHandle" src="<?=$this->fd?>" style="cursor:pointer;" border="0">
				Expand\Collapse All</a> 	
				<br>
				<?php	
				$this->extend($db,"");
				?>
				<a style="color:blue;text-decoration: none;"  href="javascript:;" onclick="var el=$('ManualADD').toggle();$('ManualADD_i').src=(el.visible())?'<?=$this->fdaO?>':'<?=$this->fda?>'">
					<img id="ManualADD_i" src="<?=$this->fd?>" style="cursor:pointer;" border="0">
					Manual Add
				</a>
				<form action="" id="ManualADD" style="display:none;">
					<input type="hidden" name="action" value="setKey">
					<input type="hidden" name="place" value="<?=$_GET["place"]?>">
					<input type="hidden" name="db" value="<?=$_GET["db"]?>">
					Path:<br>
					<input type="text" name="path"><br>
					Value<br>
					<textarea name="value"></textarea><br>
					<input type="submit" value="Save">
				</form>			
				<?php
				$db->close();
			}else{
				echo "Not a valid database, select other!";
			}				
		}else{
			echo "Select a database to edit!";
		}	
	}
}
?>