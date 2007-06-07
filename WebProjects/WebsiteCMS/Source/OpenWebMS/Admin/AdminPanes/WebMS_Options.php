<?php

//Create the class
class WebMS_Options extends Module {
	function WebMS_Options($page){
		parent::Module($page);
		$this->title="WebMS Options";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $adminpassword, $themespath, $modulespath, $functionspath, $defaultskin;
		
		//open the db
		$db=new ResDB("WebMSoptions");
		//submits
		//administration
		if (isset($_POST['submit'])) {
			//change admin password...
			if (isset($_POST['password_new']) && isset($_POST['password_new_2'])) {
				if ($_POST['password_new']==$_POST['password_new_2']) {
					if (md5($_POST['password_old'])==$adminpassword) {
						//$m1=$db->addMap("1");
						$db->put("adminpassword",md5($_POST['password_new']));
						echo 'test';
					} else {
						echo'Error: Original admin password is incorrect!<br><br>';
					}
				} else {
					echo'Error: New admin passwords do not match!<br><br>';
				}
			}
			
			//change main options such as paths etc...
			if (isset($_POST['themespath'])) {
				$db->put("themespath",($_POST['themespath']));
				$db->put("modulespath",($_POST['modulespath']));
				$db->put("functionspath",($_POST['functionspath']));
				
				$db->put("defaultskin",($_POST['defaultskin']));
			}
			
			
		}
		
		//read it
		//$val=$db[1];
		$adminpassword=$db->get("adminpassword");
		$themespath=$db->get("themespath");
		$modulespath=$db->get("modulespath");
		$functionspath=$db->get("functionspath");
		$defaultskin=$db->get("defaultskin");
		
		if (isset($_POST['submit'])) { $db->close(); }
		
		?>
		Below you can change various options in WebMS, it would be a good idea to make a backup of your 'WebMSoptions.db' database file before you proceed.<br /><br />
		<a href="WebMSoptions.php?sesid=<?=$adminpassword; ?>" target="_blank">Download WebMSoptions.db</a> (right click save target)
		<?php
		}
		
	}

//call it into page
$page->add('WebMS_Options');
	
//create the class
class WebMS_Options_main extends Module {
	function WebMS_Options_main($page){
		parent::Module($page);
		$this->title="System";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $themespath, $modulespath, $functionspath, $defaultskin;
		?>
		Below you can edit some system options, be careful not to make a mistake with these options, it could land you with lots and lots of system errors ;).<br /><br />
		<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="managep" value="WebMS_Options" type="hidden" />
			<fieldset>
				<legend>Skin Preferences:</legend><br />
				<b>Default Skin</b><br />
				<i>Path for the skin to use as default, for your convienience below this input box you will see the path to the current skin you have set.</i><br />
				<input name="defaultskin" type="text" value="<?=$defaultskin; ?>" /><br />
				Current: <?=$_SESSION['currentskin']; ?>
			</fieldset><br />
			<input name="submit" type="submit" value="Save Changes" />
		</form>
		<?php
		}
		
	}
	
//call it into page
$page->add('WebMS_Options_main');
	

//create the class	
class WebMS_Options_module extends Module {
	function WebMS_Options_module($page){
		parent::Module($page);
		$this->title="Module's";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		Below are some options regarding how WebMS handles modules such as how they collapse and how they behave. Please note that some skins may not listen to these settings or may not offer them, this is the skins fault not ours.<br /><br />
		<form name="form1" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<b>Use effects when collapsing modules?</b><br />
			<i>If you would like some kind of effect when a module is collapsed then select "yes".</i><br />
			<label><input name="collapse_javascript" type="radio" value="yes" onclick="Effect.Appear('js_effects',{duration:0.3})/*$('js_effects').show()*/"> Yes</label><br />
			<label><input name="collapse_javascript" type="radio" value="no" onclick="Effect.Fade('js_effects',{duration:0.3})/*$('js_effects').hide()*/"  checked="checked"> No</label><br /><br />
			<div id="js_effects" style="display:none">
				<b>What effect would you like to use?</b><br />
				<label><input name="javascript_effects"  type="radio" value="slide" /> Slide In/Out</label><br />
				<label><input name="javascript_effects" type="radio" value="fade" /> Fade In/Out</label><br />
				<!-- 
				<label onclick="console.log($A(this.form.javascript_effects).filter(function(){return true;}));">See Live</label>
				 -->
			</div><br />
			<b>Remember module state?</b><br />
			<i>Would you like the system to create cookies on the users machine to remember the modules states?</i><br />
			<label><input name="remember_state"  type="radio" value="yes" /> Yes</label><br />
				<label><input name="remember_state" type="radio" value="no" /> No</label><br />
		</form>
		<?php
		}
		
	}
	
//call it into page
$page->add('WebMS_Options_module');
	
//create the class
class WebMS_Options_admin extends Module {
	function WebMS_Options_admin($page){
		parent::Module($page);
		$this->title="Administration";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $adminpassword;
		
		?>
		Below you can change various administration options.
		
		<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="managep" value="WebMS_Options" type="hidden" />
			<fieldset>
				<legend>Change admin password:</legend><br />
				<b>Old Password:</b><br />
					<input name="password_old" type="password"><br /><br />
				<b>New Password:</b><br />
					<input name="password_new" type="password"><br /><br />
				<b>New Password (retype):</b><br />
					<input name="password_new_2" type="password">
			</fieldset>
			<br /><br />
			<input name="submit" type="submit" value="Save Changes" />
		</form>
		<?php
		}
		
	}
	
//call it into page
$page->add('WebMS_Options_admin');
	
?>
