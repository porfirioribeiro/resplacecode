<?php
/**
* Features & Options Panel
* A options panel
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 18-09-07
*/

//Handle Submits (UMS)
$db=new ResDB("WebMSoptions");

if (isset($_POST['submit2'])) {
	//change main options such as default skin etc...
	if (isset($_POST['ums_use']))
		if ($_POST['ums_use']=="no") {
			$_POST['ums_use']=false;
		} else {
			$_POST['ums_use']=true;
		}
	
	$db->put("ums_use",($_POST['ums_use']));
	
	if (isset($_POST['ums_which'])) {
		if ($_POST['ums_which']=="yes") {
			$_POST['ums_which']=true;
		} else {
			$_POST['ums_which']=false;
		}
		
		if (!$_POST['ums_use']) {
			$_POST['ums_which']=false;
			$_POST['int_scr']="";
		}
		
		$db->put("Integrate",		($_POST['ums_which']));
		$db->put("IntegrateScript",	($_POST['int_scr']));
	}
}
$ums_use=		$db->get("ums_use");
$ums_which=		$db->get("Integrate");
$int_scr=		$db->get("IntegrateScript");

//Handle Submits (options)

if (isset($_POST['submit'])) {
	//change main options such as default skin etc...
	if (isset($_POST['db_use'])) {
		if ($_POST['db_use']=="no") {
			$_POST['db_use']=false;
		} else {
			$_POST['db_use']=true;
		}
		$db->put("MySQL_use",	($_POST['db_use']));
	}
	
	$db->put("MySQL_host",		($_POST['mysqlhost']));
	$db->put("MySQL_db",		($_POST['mysqldb']));
	$db->put("MySQL_pass",		($_POST['mysqlpass']));
	$db->put("MySQL_pre",		($_POST['mysqlpre']));
	$db->put("MySQL_user",		($_POST['mysqluser']));
	
}
$db_use=		$db->get("MySQL_use");
$mysqlhost=		$db->get("MySQL_host");
$mysqldb=		$db->get("MySQL_db");
$mysqlpass=		$db->get("MySQL_pass");
$mysqlpre=		$db->get("MySQL_pre");
$mysqluser=		$db->get("MySQL_user");

$db->close();

class options extends Module {
	function options($page){
		parent::Module($page);
		$this->title="System Settings";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $WebMS, $path, $db_use, $ums_which, $mysqlhost, $mysqldb, $mysqlpass, $mysqlpre, $mysqluser;
		?>
			The system settings are settings regarding the system as a whole, it's pretty important you take a look at these, especially if you want to enable the UMS and etc.
			<br><br><br>
			<form name="form" enctype="multipart/form-data" action="<?=url(array("*","*")); ?>" method="post">
			
				<div class="fieldset">
				<div class="ftitle"><b>MySQL Setup:</b></div><br>
					
					<b>Use MySQL?</b><br>
					<i>Would you like to enable and use MySQL (Required for built-in UMS)?</i><br>
					<label><input name="db_use"  type="radio" value="yes" <?php echo (($db_use) ? 'checked="checked"':''); ?> onclick="Effect.Appear('js_db_use',{duration:0.3})/*$('js_db_use').show()*/" /> Yes</label><br>
					<label><input name="db_use"  type="radio" value="no" <?php echo ((!$db_use) ? 'checked="checked"':''); ?> onclick="Effect.Fade('js_db_use',{duration:0.3})/*$('js_db_use').hide()*/" /> No</label><br><br>
						
					<div id="js_db_use" <?php if (!$db_use) echo'style="display:none"'; ?>>
						<b>Host:</b><br>
						<i>The host address for MySQL, usually on the same server as the web server (localhost).</i><br>
						<input type="text" name="mysqlhost" value="<?=(($mysqlhost=="") ? 'localhost':$mysqlhost) ?>" /><br><br>
						<b>Database:</b><br>
						<i>The MySQL database to use (Make sure you create it as our scripts will not).</i><br>
						<input type="text" name="mysqldb" value="<?=(($mysqldb=="") ? 'OpenWebMS':$mysqldb) ?>" /><br><br>
						<b>Username:</b><br>
						<i>The username for administration privilages to the database.</i><br>
						<input type="text" name="mysqluser" value="<?=$mysqluser ?>" /><br><br>
						<b>Password:</b><br>
						<i>The password.</i><br>
						<input type="password" name="mysqlpass" value="<?=$mysqlpass ?>" /> <a href="javascript:var fields = document.getElementsByTagName('input'); for (var i = fields.length - 1; i >= 0; i--) {if (fields[i].type == 'password')alert(fields[i].value);}">Tell me.</a><br><br>
						<b>Table Prefix:</b><br>
						<i>The table prefix to use with table names, this is especially handy when you have many systems using the same database.</i><br>
						<input type="text" name="mysqlpre" value="<?=(($mysqlpre=="") ? 'OWMS_':$mysqlpre) ?>" /><br><br>
						
					
					</div>
					
				</div><br><br>
				<input name="submit" type="submit" value="Save Changes" />
			</form>
			
	<?php
	}
}

$page->add('options');

//Display options modules
class Integrations extends Module {
	function Integrations($page){
		parent::Module($page);
		$this->title="User Management Options";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $WebMS, $path, $db_use, $ums_use, $ums_which, $int_scr;
		?>
			A User Management System (UMS) is a great way to allow visitors to your site to register and become regular members of your website, this feature could help deliver "members only" information or just to keep track of frequent visitors to your website.<br>
			Below you can configure settings regarding the UMS.
			<br><br><br>
			<form name="form2" enctype="multipart/form-data" action="<?=url(array("*","*")); ?>" method="post">
			
				<div class="fieldset">
				<div class="ftitle"><b>Main Settings:</b></div><br>
					
					<b>Use UMS?</b><br>
					<i>Would you like to use a UMS in OpenWebMS (this includes integration)?</i><br>
					<label><input name="ums_use"  type="radio" value="yes" <?php echo (($ums_use) ? 'checked="checked"':''); ?> onclick="Effect.Appear('js_ums_use',{duration:0.3})/*$('js_ums_use').show()*/; Effect.Appear('js_ums_use2',{duration:0.3})/*$('js_ums_use2').show()*/" /> Yes</label><br>
					<label><input name="ums_use"  type="radio" value="no" <?php echo ((!$ums_use) ? 'checked="checked"':''); ?> onclick="Effect.Fade('js_ums_use',{duration:0.3})/*$('js_ums_use').hide()*/; Effect.Fade('js_ums_use2',{duration:0.3})/*$('js_ums_use2').hide()*/" /> No</label><br><br>
						
					<div id="js_ums_use" <?php if (!$ums_use) echo'style="display:none"'; ?>>
						<b>Use the Built in UMS or Integraged?</b><br>
						<i>You can use the UMS built for OpenWebMS, or you can integrate OpenWebMS so it uses another systems UMS (eg. <a href="http://simplemachines.org" title="SimpleMachines Forum software" target="_blank">SimpleMachines</a>)?</i><br>
						<label><input name="ums_which"  type="radio" value="no" <?php echo ((!$ums_which) ? 'checked="checked"':''); ?> onclick="Effect.Appear('js_ums_which',{duration:0.3})/*$('js_ums_which').show()*/; Effect.Fade('js_ums_which2',{duration:0.3})/*$('js_ums_which2').hide()*/" <?=(($db_use==true) ? '':'disabled') ?> /> OpenWebMS <?=(($db_use==true) ? '':'<b style="color:red">(Requires MySQL!)</b>') ?></label><br>
						<label><input name="ums_which"  type="radio" value="yes" <?php echo (($ums_which) ? 'checked="checked"':''); ?> onclick="Effect.Fade('js_ums_which',{duration:0.3})/*$('js_ums_which').hide()*/; Effect.Appear('js_ums_which2',{duration:0.3})/*$('js_ums_which2').show()*/" /> Integration</label><br><br>
					</div>
					
				</div><br><br>
				
				<div id="js_ums_use2" <?php if (!$ums_use) echo'style="display:none"'; ?>>
					<div id="js_ums_which" <?php if ($ums_which=="Integrate") echo'style="display:none"'; ?>>
						<div class="fieldset">
						<div class="ftitle"><b>Built-In UMS Settings:</b></div><br>
						
							<b>:</b><br>
							<i>The built in UMS requires a MySQL database, please fill in these details below:<br>
							Note: Tables and other things are created for you when you save these settings.</i><br>
						</div>
					</div>
					
					<div id="js_ums_which2" <?php if (!$ums_which=="Integrate") echo'style="display:none"'; ?>>
						<div class="fieldset">
						<div class="ftitle"><b>Integrated UMS:</b></div><br>
						
							<b>Integrate With?</b><br>
							<i>You can choose what system you wish to integrate OpenWebMS with below:<br>
							Note: there may be some options regarding this integration, after submit these options should appear below here.</i><br>
							<select name="int_scr">
								<?php
									//get integration scripts		
									$contents=GetFiles($WebMS["IntPath"]);
									if(is_array($contents)){
										foreach($contents as $item){
											$itemi=$item;
											$item=str_replace(array("-","_"),array(" "," "),$item);
											if ($item=="StandAlone.php") {} else {
												if ($int_scr==$item) {
													echo "<option selected value='{$itemi}'>{$item}</option>";
												} else {
													echo "<option value='{$itemi}'>{$item}</option>";
												}
											}
											
										}
									}
								?>
							</select>
						</div>
					</div><br><br>
				</div>
				<input name="submit2" type="submit" value="Save Changes" />
			</form>
			
	<?php
	}
}

$page->add('Integrations');
?>