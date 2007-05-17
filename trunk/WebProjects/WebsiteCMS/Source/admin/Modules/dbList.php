<?php
class dbList extends Module {
	function dbList($page){
		parent::Module($page);
		$this->title="Database List";		
		$this->side=Module::LEFT;
	}
	function content(){
		$arr=GetFiles($this->page->path."db/");
		if ($arr){
			foreach ($arr as $file) {
				?>
				<a href="javascript:void(0)" onclick="if (confirm('Delete this Database?\n<?=$file?>')){document.location='?action=delDB&place=data&db=<?=$file?>'}"><img alt="Delete" title="Delete this Database" border="0" style="vertical-align:middle" src="icons/button_cancel.png"></a>&nbsp;<a href="?action=editdb&place=data&db=<?=$file?>"><?=$file?></a><br>
				<?php
			}			
		}
		?>
		<br>
		<form action="">
			<input type="hidden" name="action" value="addDB">
			<input type="hidden" name="place" value="data">
			<input type="text" name="db" onkeydown="if (event.keyCode==13){if (!this.value.endsWith('.db.php') && this.value!==''){this.value+='.db.php';}}" value="" onblur="if (!this.value.endsWith('.db.php') && this.value!==''){this.value+='.db.php'}"><br>
			<input type="submit" onclick="this.form.db.blur();" value="Add Database">
		</form>
		<?php
	}
}
?>
