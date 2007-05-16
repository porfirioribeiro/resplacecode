<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Admin Panel");
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
$page->addDefaults();
$page->addJS("lib/menuEditor.js");

class menuEditor extends Module {
	/** 
	 * @var ADB 
	 */
	var $db;
	function menuEditor($page){
		parent::Module($page);
		$this->title="Menu editor";
		$this->side=Module::CENTER;
		$this->db=new ADB($this->page->path."db/Menu.db");
	}
	function finish(){
		$this->db->close();
	}
	function extend($map,$level,$path){
		foreach ($map->arr as $key => $value) {
			echo $level;
			if (is_a($value,ArrayMap)){
				$level.="&nbsp;";
				$path.=".".$value;
				$this->extend($key,$level,$path);
			}else{
				?>
				<input type="radio" name="item" value="<?=$path?>" onclick="menuEditor.changeItem(this,'<?=$key?>','<?=$value?>')"><a href="">[X]</a><?=$key?> - <?=$value?><br>
				<?php
			}
		}
		echo $level;
		?>
		<input type="radio" name="item" value="<?=$path?>" onclick="menuEditor.addKey(this)">Add one key<br>
		<input type="radio" name="item" value="<?=$path?>" onclick="menuEditor.addItem(this)">Add one item
		<?php
	}
	function content(){
		switch ($_GET["act"]){
			case "addKey":
				$this->db->addMap($_GET["name"]);
			break;
			case "addItem":
				$this->db->put($_GET["name"],$_GET["url"]);
			break;
		}
		?>
		<form action="?">
			<input type="hidden" name="act" value="">
			<?php
			$this->extend($this->db,"","");
			?>		
			<br>
			Name:<input type="text" name="name"> URL:<input type="text" name="url"><br>
			<input type="submit" onclick="this.form.act='delete'" value="Delete Selected">
			<input type="submit">
		</form>
		<?php
	}
}

$page->add(menuEditor);
$page->create();
?>
