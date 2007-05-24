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
	$page->add(WebMS_Options_main);
	
class WebMS_Options_main extends Module {
	function WebMS_Options_main($page){
		parent::Module($page);
		$this->title="System";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path;
		
		?>
		Below you can edit some system options, be careful not to make a mistake with these options, it could land you with lots and lots of system errors ;).<br /><br />
		<form name="form1" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
		</form>
		<?php
		}
		
	}
	
	//multiple panes need to be called onto the page
	//shit it adds them before the main one xd
	$page->add(WebMS_Options_module);
	
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
		Below you can change various administration options.
		
		<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<b>Administration login password</b><br />
			<i>You can change the login password below.</i>
			<table width="400" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td>Old Password:</td>
				<td><input name="password_old" type="text"></td>
			  </tr>
			  <tr>
				<td>New Password:</td>
				<td><input name="password_new" type="text"></td>
			  </tr>
			  <tr>
				<td>New Password (retype):</td>
				<td><input name="password_new_2" type="text"></td>
			  </tr>
			</table>
		</form>
		<?php
		}
		
	}
	
?>
