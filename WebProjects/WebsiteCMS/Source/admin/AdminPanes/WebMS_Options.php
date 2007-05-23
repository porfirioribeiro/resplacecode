<?php
	//multiple panes need to be called onto the page
	//shit it adds them before the main one xd
	$page->add(WebMS_Options);
	
class WebMS_Options extends Module {
	function WebMS_Options($page){
		parent::Module($page);
		$this->title="WebMS Options";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		Below you can change various options in WebMS, it would be a good idea to make a backup of your 'WebMSoptions.db' database file before you proceed.
		<?php
		}
		
	}
	
	//multiple panes need to be called onto the page
	//shit it adds them before the main one xd
	$page->add(WebMS_Options_collapse);
	
class WebMS_Options_collapse extends Module {
	function WebMS_Options_collapse($page){
		parent::Module($page);
		$this->title="Module Collapsing";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		Below are some options regarding how WebMS handles modules and how they collapse, you can choose to use javascript collapse effects or not, and what javascript effect you wish to use.<br /><br />
		<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<b>Use JavaScript for collapsing modules?</b>
		</form>
		<?php
		}
		
	}
	
	//multiple panes need to be called onto the page
	//shit it adds them before the main one xd
	$page->add(WebMS_Options_admin);
	
class WebMS_Options_admin extends Module {
	function WebMS_Options_admin($page){
		parent::Module($page);
		$this->title="Administration";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		Below you can change various options in WebMS, it would be a good idea to make a backup of your 'WebMSoptions' db file before you proceed.
		<?php
		}
		
	}
	
?>
