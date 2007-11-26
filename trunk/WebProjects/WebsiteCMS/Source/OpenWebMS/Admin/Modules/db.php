<?php 
class dbEditor extends Module {
	var $fd;
	var $fdO;
	var $dbFile;
	var $cat="";
	var $db="";
	var $action="";
	function dbEditor($page){
		parent::Module($page);
		$this->title="Database editor";
		$this->side=Module::CENTER;
		$this->fd=$this->page->path."Style/menu/folder.gif";	
		$this->fdO=$this->page->path."Style/menu/folderOpen.gif";	
		$this->page->addJSCode("
function toggleEl(el,ct){
	el=$(el);ct=$(ct);
	if (el){
		if (el.visible()){
			Effect.Fade(el);
		}
	}
}"); 
		$this->dbFile=$this->page->path."db/";
		if (isset($_GET["category"]) && $_GET["category"]!=""){
			$this->dbFile.=$_GET["category"]."/";
			$this->cat=$_GET["category"];
		}
		if (isset($_GET["db"]) && $_GET["db"]!=""){
			$this->dbFile.=$_GET["db"];
			$this->db=$_GET["db"];
		}	
		$this->dbFile.=".db";
		if (isset($_GET["action"])){
			$this->action=$_GET["action"];
		}
		$url="index.php?nav=db&action=editDB&category=".$this->cat."&db=".$this->db;
		$urlNoAct="index.php?nav=db&category=".$this->cat."&db=".$this->db;
		switch ($this->action) {
			case "addDB":
				$tabled=(isset($_GET["tabled"]) && $_GET["tabled"]=="on");
				$db=new ResDB($this->db,$this->cat,$tabled);
				$db->close();
				header("Location: ".$url."&message=Database <b>".$this->db."</b> Created!");
			break;
			case "delDB":
				$db=new ResDB($this->db,$this->cat);
				$db->delete();
				header("Location: ".$urlNoAct."&message=Database <b>".$this->db."</b> Deleted!");
			break;
			case "delKey":
				$db=new ResDB($this->db,$this->cat);
				$db->del($_GET['path']);
				$db->close();
				header("Location: ".$urlNoAct."&message=Key <b>".$_GET['path']."</b> Deleted!");
			break;
		}
	}
	function exTree($map,$path){
		foreach ($map as $key=>$value) {
			$p=$path.(($path=="")?"":".").$key;		
			$id =str_replace(".","_",$p);				
			?>
			 <div style="margin-top:0px;">
			<?php
			 if (ArrayMap::is($value)){
				?>
				<img class="dbEditExpCollHandle" src="<?=$this->fd?>" onclick="var el=$('<?=$id?>');el.toggle();this.src=(el.style.display=='')?'<?=$this->fdO?>':'<?=$this->fd?>';" style="cursor:pointer;">
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
			 if (!ArrayMap::is($value)){
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
			if (ArrayMap::is($value)){		
				echo '<div class="dbEditExpCollContainer" style="display:none;padding-left:13px;" id="'.$id.'">		';			
				$this->exTree($value,$p);	
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
		/*if ($this->message!=""){
			echo '<div style="border:1px solid gray;padding:5px;">'.$this->message.'</div>';
		}*/
		if ($this->action=="editDB"){
			if (!is_file($this->dbFile)){
				echo "Invalid database!!";
				return;
			}		
			$db=new ResDB($this->db,$this->cat);
			?>
			Editing <?=$this->db?> on <?=$this->cat?>
			<br><br>
			<?php
			if ($db->get("isTabled")){
				echo "Tabled database editor unemplemented yet sorry!";
			}else{
				$this->exTree($db,"");
			}
		}else{
			echo "Select a database to edit!";
		}
	}
}

class dbList extends Module {
	function dbList($page){
		parent::Module($page);
		$this->title="Database List";		
		$this->side=Module::LEFT;
	}
	function content(){
		$tpl=new TplFile("tpl/db.tpl");
		foreach (GetFolders($this->page->path."db/") as $category) {
			echo $tpl->get("dbList")->get("addDB")->parse(array("category"=>$category));
			foreach (GetFiles($this->page->path."db/".$category."/","*.db") as $file) {
				$file=str_replace(".db","",$file);
				?>
				<img onclick="if (confirm('Delete this Database?\n<?=$file?>')){document.location='?nav=db&action=delDB&category=<?=$category?>&db=<?=$file?>'}" style="margin-left:10px;middle;cursor:pointer;vertical-align:middle;" alt="Delete" title="Delete this Database" src="icons/button_cancel.png">&nbsp;<a href="?nav=db&action=editDB&category=<?=$category?>&db=<?=$file?>"><?=$file?></a><br>
				<?php
			}
		}
		echo $tpl->get("dbList")->get("addDB")->parse(array("category"=>""));
		foreach (GetFiles($this->page->path."db/","*.db") as $file) {
			$file=str_replace(".db","",$file);
			?>
			<img onclick="if (confirm('Delete this Database?\n<?=$file?>')){document.location='?nav=db&action=delDB&place=&db=<?=$file?>'}" style="margin-left:10px;middle;cursor:pointer;vertical-align:middle;" alt="Delete" title="Delete this Database" border="0" src="icons/button_cancel.png">&nbsp;<a href="?nav=db&action=editDB&place=data&db=<?=$file?>"><?=$file?></a><br>
			<?php
		}			
	}
}

$page->addModule("dbEditor");
$page->addModule("dbList",null,Module::RIGHT);
?>
