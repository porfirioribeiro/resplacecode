<?php
/**
* Features & Options Panel
* A options panel
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 18-09-07
*/

//Handle Submits

//Display options modules
class Integrations extends Module {
	function Integrations($page){
		parent::Module($page);
		$this->title="Logo Designer";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $WebMS, $path;
		?>
			<br><br>
			<div class="fieldset">
			<div class="ftitle"><b>Theme Logo:</b></div><br>
			Below you can configure your website logo, you can either define/construct a global logo used on all themes (best with alpha-blended logo's), or use the logo image defined by the themes (good if you require a different logo for each theme).
			<br><br>
				<form name="form2" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
					<input name="nav" value="ThemesAndLayout" type="hidden" />
					
					<b>Use Global Logo?</b><br>
					<i>Would you like to setup a logo used by all themes, or use the themes defined logo?</i><br>
					<label><input name="logo_use"  type="checkbox" value="yes" <?php if ($logo_use=="yes") echo'checked="checked"'; ?> /> Yes</label><br><br>
					
					<b>Logo and/or text?</b><br>
					<i>You can construct your logo by defining an image (PNG), defining some text, or both. Which would you like?</i><br>
					<label><input name="logo_define" type="radio" value="LogoAndText" onclick="Effect.Appear('js_effects2',{duration:0.3})/*$('js_effects').show()*/; Effect.Appear('js_effects3',{duration:0.3})/*$('js_effects').show()*/" <?php if ($logo_define=="LogoAndText") echo'checked="checked"'; ?>> Logo &amp; Text</label><br>
					<label><input name="logo_define" type="radio" value="Logo" onclick="Effect.Fade('js_effects3',{duration:0.3})/*$('js_effects').hide()*/; Effect.Appear('js_effects2',{duration:0.3})/*$('js_effects').show()*/"  <?php if ($logo_define=="Logo") echo'checked="checked"'; ?>> Logo</label><br>
					<label><input name="logo_define" type="radio" value="Text" onclick="Effect.Fade('js_effects2',{duration:0.3})/*$('js_effects').hide()*/; Effect.Appear('js_effects3',{duration:0.3})/*$('js_effects').show()*/"  <?php if ($logo_define=="Text") echo'checked="checked"'; ?>> Text</label><br><br>
					
					<div id="js_effects2" <?php echo(($logo_define=="Text" || !$logo_define=="LogoAndText") ? 'style="display:none"':''); ?>>
						<b>Upload Logo:</b><br>
						<i>You can upload a logo below, standard image height is 65px, PNG only.</i><br>
						<input type="hidden" name="MAX_FILE_SIZE" value="30000" /><br> 
						<input name="logofile" type="file" /><br>
						
						<?php
						if (file_exists($this->page->themespath.'logo.png')) {
							echo "<div style='padding-left:15px;'>Current Logo:<br>
							<img class='alpha' src='{$this->page->themespath}logo.png' border='0' alt='Logo' title='Logo'></div><br>";
						}
						if (isset($fileupload))
							echo(($fileupload=="yes") ? '<i>File Uploaded!</i>':'<i>Upload Failed!</i><br>');
						
						?><br>
					</div>
					
					<div id="js_effects3" <?php echo(($logo_define=="Logo" || !$logo_define=="LogoAndText") ? 'style="display:none"':''); ?>>
						<b>Set Title Text:</b><br>
						<i>You can setup some text to appear next to your logo, for example you may wish to have your website name appear here.</i><br>
						<input type="text" name="logo_text" value="<?=((!isset($logo_text) || $logo_text=="reset:me") ? 'OpenWebMS Powered Website':$logo_text) ?>" />
					</div>
					
					<br><input name="submit2" type="submit" value="Save Changes" />
				</form>
				
			</div><br><br>
			
			<div class="fieldset">
			<div class="ftitle"><b>Theme Layout:</b></div><br>
			
			</div>
			
	<?php
	}
}
?>