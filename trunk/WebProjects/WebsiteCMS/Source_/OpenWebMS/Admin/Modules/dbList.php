<?php
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
				<img onclick="if (confirm('Delete this Database?\n<?=$file?>')){document.location='?manage=db&action=delDB&category=<?=$category?>&db=<?=$file?>'}" style="margin-left:10px;middle;cursor:pointer;vertical-align:middle;" alt="Delete" title="Delete this Database" src="icons/button_cancel.png">&nbsp;<a href="?manage=db&action=editDB&category=<?=$category?>&db=<?=$file?>"><?=$file?></a><br>
				<?php
			}
		}
		echo $tpl->get("dbList")->get("addDB")->parse(array("category"=>""));
		foreach (GetFiles($this->page->path."db/","*.db") as $file) {
			$file=str_replace(".db","",$file);
			?>
			<img onclick="if (confirm('Delete this Database?\n<?=$file?>')){document.location='?manage=db&action=delDB&place=&db=<?=$file?>'}" style="margin-left:10px;middle;cursor:pointer;vertical-align:middle;" alt="Delete" title="Delete this Database" border="0" src="icons/button_cancel.png">&nbsp;<a href="?manage=db&action=editDB&place=data&db=<?=$file?>"><?=$file?></a><br>
			<?php
		}			
	}
}
?>
