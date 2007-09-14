<?php
//write and read all settings to DB when/if required
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
			} else {
				echo'Error: Original admin password is incorrect!<br><br>';
			}
		} else {
			echo'Error: New admin passwords do not match!<br><br>';
		}
	}
	
	//change main options such as default skin etc...
	if (isset($_POST['defaultskin'])) {
		$db->put("defaultskin",($_POST['defaultskin']));
	}
	if (isset($_POST['collapse_javascript'])) {
		$db->put("collapse_javascript",($_POST['collapse_javascript']));
	}
	if (isset($_POST['javascript_effects'])) {
		$db->put("javascript_effects",($_POST['javascript_effects']));
	}
	if (isset($_POST['remember_state'])) {
		$db->put("remember_state",($_POST['remember_state']));
	}
	
	
}

//read it
$defaultskin=$db->get("defaultskin");
$collapse_javascript=$db->get("collapse_javascript");
$javascript_effects=$db->get("javascript_effects");
$remember_state=$db->get("remember_state");

if (isset($_POST['submit'])) { $db->close(); }




//Create the class
class WebMS_Options extends Module {
	function WebMS_Options($page){
		parent::Module($page);
		$this->title="WebMS Options";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $adminpassword;
		
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
		global $path, $defaultskin;
		?>
		Below you can edit some system options, be careful not to make a mistake with these options, it could land you with lots and lots of system errors ;).<br /><br />
		<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="pane" value="WebMS_Options" type="hidden" />
			<fieldset>
				<legend>Skin Preferences:</legend><br />
				<b>Default Skin:</b><br />
				<i>Path for the skin to use as default, for your convienience below this input box you will see the path to the current skin you have set.</i><br />
				<select name="defaultskin">
				<?php
				//get themes		
			$contents=GetFolders($this->page->themespath);
			if(is_array($contents)){
				foreach($contents as $item){
					$itemi=$item;
					$item=str_replace(array("-","_"),array(" "," "),$item);
					
					//start group
					if($item != '.' && $item != '..'){
						echo "<optgroup label='{$item}'>";
						
						//get styles for the theme...
						$contents2=GetFolders($this->page->themespath.$itemi."/");
						
						if(is_array($contents2)){
							foreach($contents2 as $item2){
								$itemi2=$item2;
								$item2=str_replace(array("-","_"),array(" "," "),$item2);
								
								if ($itemi.'/'.$itemi2.'/'==$this->page->defaultskin){
									echo "<option selected value='{$itemi}/{$itemi2}/'>{$item2}</option>";
								}else{
									if($item2 != '.' && $item2 != '..'){	
										echo "<option value='{$itemi}/{$itemi2}/'>{$item2}</option>";
									}
								}
							}
						}
						
						//end group
						echo"</optgroup>";
					}
				}
			}
			?>
		</select><br />
				
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
		global $path, $collapse_javascript, $javascript_effects, $remember_state;
		
		?>
		Below are some options regarding how WebMS handles modules such as how they collapse and how they behave. Please note that some skins may not listen to these settings or may not offer them, this is the skins fault not ours.<br /><br />
		<form name="form1" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="pane" value="WebMS_Options" type="hidden" />
			<b>Use effects when collapsing modules?</b><br />
			<i>If you would like some kind of effect when a module is collapsed then select "yes".</i><br />
			<label><input name="collapse_javascript" type="radio" value="yes" onclick="Effect.Appear('js_effects',{duration:0.3})/*$('js_effects').show()*/" <?php if ($collapse_javascript=="yes") echo'checked="checked"'; ?>> Yes</label><br />
			<label><input name="collapse_javascript" type="radio" value="no" onclick="Effect.Fade('js_effects',{duration:0.3})/*$('js_effects').hide()*/"  <?php if ($collapse_javascript=="no") echo'checked="checked"'; ?>> No</label><br /><br />
			<div id="js_effects" <?php if ($collapse_javascript=="no") echo'style="display:none"'; ?>>
				<b>What effect would you like to use?</b><br />
				<label><input name="javascript_effects"  type="radio" value="slide" <?php if ($javascript_effects=="slide") echo'checked="checked"'; ?> /> Slide In/Out</label><br />
				<label><input name="javascript_effects" type="radio" value="fade" <?php if ($javascript_effects=="fade") echo'checked="checked"'; ?> /> Fade In/Out</label><br />
				<!-- 
				<label onclick="console.log($A(this.form.javascript_effects).filter(function(){return true;}));">See Live</label>
				 -->
			</div><br />
			<b>Remember module state?</b><br />
			<i>Would you like the system to create cookies on the users machine to remember the modules states?</i><br />
			<label><input name="remember_state"  type="radio" value="yes" <?php if ($remember_state=="yes") echo'checked="checked"'; ?> /> Yes</label><br />
				<label><input name="remember_state" type="radio" value="no" <?php if ($remember_state=="no") echo'checked="checked"'; ?> /> No</label><br /><br />
				<input name="submit" type="submit" value="Save Changes" />
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
		$this->title="Super Admin Password";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $adminpassword;
		
		?>
		Below you can change various administration options.
		
		<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="pane" value="WebMS_Options" type="hidden" />
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
