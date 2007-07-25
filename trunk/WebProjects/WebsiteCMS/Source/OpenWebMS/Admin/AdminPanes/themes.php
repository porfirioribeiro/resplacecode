<?php
//write and read all settings to DB when/if required
$db=new ResDB("WebMSoptions");

if (isset($_POST['submit'])) {
	//change main options such as default skin etc...
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
	
if (isset($_POST['submit2'])) {
	//change main options such as default skin etc...
	if (!isset($_POST['logo_use']))
		$_POST['logo_use']="no";
	
	$db->put("logo_use",($_POST['logo_use']));
	
	if (isset($_POST['logo_define'])) {
		$db->put("logo_define",($_POST['logo_define']));
	}
	if (isset($_POST['logo_text'])) {
		$db->put("logo_text",($_POST['logo_text']));
		//$txt=serialize($_POST['logo_text']);
	}
	
	if (isset($_FILES['logofile']['name']) && !$_FILES['logofile']['name']=="") {
		if (move_uploaded_file($_FILES['logofile']['tmp_name'], $WebMS["ThemesPath"].'logo.png')) {
				$fileupload="yes";
			} else {
				$fileupload="no";
			}
	}
}
//read it
$defaultskin=$db->get("defaultskin");
$collapse_javascript=$db->get("collapse_javascript");
$javascript_effects=$db->get("javascript_effects");
$remember_state=$db->get("remember_state");

$logo_use=$db->get("logo_use");
$logo_define=$db->get("logo_define");
$logo_text=$db->get("logo_text");

if (isset($_GET['skin1'])) {
	$db->put("defaultskin",($_GET['skin1'].'/'.$_GET['skin2'].'/'));
	$page->addMeta(array('http-equiv' => 'refresh','content' => '3;'.$_SERVER['PHP_SELF']."?pane=themes"));
	$page->addAlert("Page Reloading...","Skin Applied!<br>This page should refresh in 3 seconds...");
}
	
$db->close();

	$txt=$logo_text;
//GENERATE THE IMAGE!
	if (isset($_POST['logo_use'])) {
		//check if we are adding a logo
		if (isset($_POST['logo_define']) && ($_POST['logo_define']=="LogoAndText" || $_POST['logo_define']=="Logo")) {
			if (file_exists($WebMS["ThemesPath"].'logo.png')) {
				$logosize=getimagesize($WebMS["ThemesPath"].'logo.png');
			} else { $logosize=array(0,0,0,0); }
		}
		
		
		if (isset($_POST['logo_define']) && ($_POST['logo_define']=="LogoAndText" || $_POST['logo_define']=="Text")) {
			//get dimensions
			$g=new GDLib(5,5);
			$g->CreateStyle('Big','Eunjin',30,'#BB','#F0F0F0');
			$textdim=$g->GetTextSize(0,$txt);
			
			//$g->Destroy();
		} else { $textdim=array(0,0,0,0); }
		
		//make final image
		$gl=new GDLib(10+$logosize[0]+10+$textdim[0]+10,65);
			if ($logosize[0]>>0) {
				
				$logoimg=imagecreatefrompng($WebMS["ThemesPath"].'logo.png');
				imagecopy($gl->image,$logoimg,10,(65-$logosize[1])/2,0,0,$logosize[0],$logosize[1]);
				$offset=10+$logosize[0];
			} else { $offset=0; }
			
			if ($textdim[0]>>0) {
				$gl->CreateStyle('Big','Eunjin',30,'#BB','#F0F0F0');
				//$gl->fontSize=80;
				$gl->CreateText(0,0-$textdim[2]+$offset+10,$textdim[1]-$textdim[3]+((65-$textdim[1])/2),$txt);
			}
		$gl->out($WebMS["ThemesPath"].'sitelogo.png');

	}

//Create the class
class themes extends Module {
	function themes($page){
		parent::Module($page);
		$this->title="Warning!";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $adminpassword;
		
		?>
		Before making important changes to your WebMS system, please make a complete backup of your ResDB database directory. Just incase.<?php
		}
		
	}

//call it into page
$page->add('themes');
	
//create the class
class themes_main extends Module {
	function themes_main($page){
		parent::Module($page);
		$this->title="Themes &amp; Layout Settings";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $WebMS, $path, $defaultskin, $collapse_javascript, $logo_text, $javascript_effects, $remember_state, $logo_use, $logo_define, $fileupload;
		?>
		<br /><br />
			<div class="fieldset">
				<div class="ftitle"><b>Default Theme:</b></div><br />
				<i>This is the theme you wish to use to render your website as default.</i><br />
				<div style="overflow:scroll; height:250px;">
					<table><tr>
					<?php
					$contents=GetFolders($this->page->themespath);
					if(is_array($contents)){
						foreach($contents as $item){
							$itemi=$item;
							$item=str_replace(array("-","_"),array(" "," "),$item);
							
							//start group
							if($item != '.' && $item != '..') {
								//echo "<optgroup label='{$item}'>";
								
								//get styles for the theme...
								$contents2=GetFolders($this->page->themespath.$itemi."/");
								
								if(is_array($contents2)) {
									//echo'<td class="main"></td>';
									foreach($contents2 as $item2) {
										$itemi2=$item2;
										$item2=str_replace(array("-","_"),array(" "," "),$item2);
										
										if (file_exists($this->page->themespath."{$itemi}/{$itemi2}/preview.png")) {
											
											if ($itemi.'/'.$itemi2.'/'==$defaultskin){
												//echo "<option selected value='{$itemi}/{$itemi2}/'>{$item2}</option>";
												echo "
												<td align='center'><img src='".$this->page->themespath."{$itemi}/{$itemi2}/preview.png' border='1'>
												<br><b>{$item} - {$item2}</b></a></td>";
											}else{
												if($item2 != '.' && $item2 != '..'){	
													//echo "<option value='{$itemi}/{$itemi2}/'>{$item2}</option>";
													echo "
													<td align='center'><a href='".$_SERVER['PHP_SELF']."?pane=themes&amp;skin1={$itemi}&amp;skin2={$itemi2}'><img src='".$this->page->themespath."{$itemi}/{$itemi2}/preview.png' border='0'>
													<br>{$item} - {$item2}</a></td>";
												}
											}
										}
									}
								}
								
								//end group
								//echo"</optgroup>";
							}
						}
					}	
					?>
					</tr>
					</table>
				</div></div>
				<br /><br />
				
				<div class="fieldset">
				<div class="ftitle"><b>Theme Preferences:</b></div><br />
					Below are some options regarding how WebMS handles modules such as how they collapse and how they behave. Please note that some skins may not listen to these settings or may not offer them, this is the skins fault not ours.<br /><br />
					<form name="form1" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
						<input name="pane" value="themes" type="hidden" />
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
				</div><br /><br />
				
				<div class="fieldset">
				<div class="ftitle"><b>Theme Logo:</b></div><br />
				Below you can configure your website logo, you can either define/construct a global logo used on all themes (best with alpha-blended logo's), or use the logo image defined by the themes (good if you require a different logo for each theme).
				<br /><bR />
					<form name="form2" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
						<input name="pane" value="themes" type="hidden" />
						
						<b>Define/Construct Global Logo?</b><br />
						<i>Would you like to setup a logo used by all themes, or use the themes defined logo?</i><br />
						<label><input name="logo_use"  type="checkbox" value="yes" <?php if ($logo_use=="yes") echo'checked="checked"'; ?> /> Yes</label><br /><br />
						
						<b>logo and/or text?</b><br />
						<i>You can construct your logo by defining an image (PNG), defining some text, or both. Which would you like?</i><br />
						<label><input name="logo_define" type="radio" value="LogoAndText" onclick="Effect.Appear('js_effects2',{duration:0.3})/*$('js_effects').show()*/; Effect.Appear('js_effects3',{duration:0.3})/*$('js_effects').show()*/" <?php if ($logo_define=="LogoAndText") echo'checked="checked"'; ?>> Logo &amp; Text</label><br />
						<label><input name="logo_define" type="radio" value="Logo" onclick="Effect.Fade('js_effects3',{duration:0.3})/*$('js_effects').hide()*/; Effect.Appear('js_effects2',{duration:0.3})/*$('js_effects').show()*/"  <?php if ($logo_define=="Logo") echo'checked="checked"'; ?>> Logo</label><br />
						<label><input name="logo_define" type="radio" value="Text" onclick="Effect.Fade('js_effects2',{duration:0.3})/*$('js_effects').hide()*/; Effect.Appear('js_effects3',{duration:0.3})/*$('js_effects').show()*/"  <?php if ($logo_define=="Text") echo'checked="checked"'; ?>> Text</label><br /><br />
						
						<div id="js_effects2" <?php echo(($logo_define=="Text" || !$logo_define=="LogoAndText") ? 'style="display:none"':''); ?>>
							<b>Upload Logo:</b><br />
							<i>You can upload a logo below, make sure the height does not exceed 65px and that the file format is PNG.</i><br />
							<input type="hidden" name="MAX_FILE_SIZE" value="30000" /><br /> 
							<input name="logofile" type="file" /><br />
							
							<?php
							if (file_exists($this->page->themespath.'logo.png')) {
								echo "<div style='padding-left:15px;'>Current Logo:<br />
								<img class='alpha' src='{$this->page->themespath}logo.png' border='0' alt='Logo' title='Logo'></div><br>";
							}
							if (isset($fileupload))
								echo(($fileupload=="yes") ? '<i>File Uploaded!</i>':'<i>Upload Failed!</i><br>');
							
							?><br>
						</div>
						
						<div id="js_effects3" <?php echo(($logo_define=="Logo" || !$logo_define=="LogoAndText") ? 'style="display:none"':''); ?>>
							<b>Set Title Text:</b><br />
							<i>You can setup some text to appear next to your logo, for example you may wish to have your website name appear here.</i><br />
							<input type="text" name="logo_text" value="<?=((!isset($logo_text) || $logo_text=="reset:me") ? 'OpenWebMS Powered Website':$logo_text) ?>"
						</div>
						
						<br /><input name="submit2" type="submit" value="Save Changes" />
					</form><br /><br />
					<img src="<?=$WebMS["ThemesUrl"].'sitelogo.png'; ?>" border=0 alt="gg"/>
				</div><br /><br />
				
				<div class="fieldset">
				<div class="ftitle"><b>Theme Layout:</b></div><br />
				
				</div>
				
		<?php
		}
		
	}
	
//call it into page
$page->add('themes_main');
	
?>
