<?php
/**
* PageRater Pane (Admin)
* Allows user to set PageRater options.
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-10-07
*/

//write and read all settings to DB when/if required
$db=new ResDB("PageRater");
//submits
//administration

//change main options such as default skin etc...
if (isset($WebMS["URLArray"][3]) && $WebMS["URLArray"][3]=="Back") {
	$db->put("pageratebarbac",($WebMS["URLArray"][4].'/'.str_replace("-D0T-",".",$WebMS["URLArray"][5])));
}
if (isset($WebMS["URLArray"][3]) && $WebMS["URLArray"][3]=="Fore") {
	$db->put("pageratebar",($WebMS["URLArray"][4].'/'.str_replace("-D0T-",".",$WebMS["URLArray"][5])));
}
if (isset($_POST['pageratebg'])) {
	$db->put("pageratebg",($_POST['pageratebg']));
}


//read it
$pageratebara=explode("/",$db->get("pageratebarbac"));
$pageratebarb=explode("/",$db->get("pageratebar"));
 $db->close();




//Create the class
class PageRater extends Module {
	function PageRater($page){
		parent::Module($page);
		$this->title="PageRate Module Options";
		$this->side=Module::CENTER;
	}
	function content() {
		global $WebMS, $path, $adminpassword, $pageratebara, $pageratebarb;
		?>
		Below you can change various options for the PageRate Module. Please make sure you have the latest version of this module BEFORE making any module changes.<br><br>

		<div style="height:200px;">
		<div class="fieldset" style="float: left; margin-left: 10px; margin-top: 10px;">
			<div class="ftitle"><b>Bar background style:</b></div><br>
			<div style="overflow:scroll; width:200px; height:150px; border:2px inset #ccc">
				<div style="padding:10px">
					<?php
					//NEW CODE
					//Create list of styles for user to choose
					$BarStyleFolders=GetFolders($WebMS["ModulesPath"] ."PageRate/Bars/");

					if (count($BarStyleFolders)) {
						foreach ($BarStyleFolders as $folder) {
							echo "<div style='text-decoration:underline;'><b>$folder</b></div>";
							$BarStyleFiles = GetFiles($WebMS["ModulesPath"]."PageRate/Bars/$folder/");
							echo "<div style='padding-left:10px'>";

							foreach ($BarStyleFiles as $file) {
								$filen=explode(".",$file);
								if (strcmp($folder.'/'.$file,$pageratebara[0].'/'.$pageratebara[1])==0) {
									echo "<div style='border:1px solid black'><img src='".$WebMS['ModulesUrl']."PageRate/Bars/$folder/$file' /><a href='".url(array("*","*","*",$folder,str_replace(".","-D0T-",$file)))."' style='position:relative; top: -0.50em; left: 0.5em;'>$filen[0]</a></div>";
								} else {
									echo "<img src='".$WebMS['ModulesUrl']."PageRate/Bars/$folder/$file' /><a href='".url(array("*","*","*","Back",$folder,str_replace(".","-D0T-",$file)))."' style='position:relative; top: -0.50em; left: 0.5em;'>$filen[0]</a><br>";
								}
							}

							echo "</div><br>";
						}
					}
					?>
				</div>
			</div>
		</div>
		<div class="fieldset" style="float: left; margin-left: 10px; margin-top: 10px;">
			<div class="ftitle"><b>Bar foreground style:</b></div><br>
			<div style="overflow:scroll; width:200px; height:150px; border:2px inset #ccc">
				<div style="padding:10px">
				<?php
				//NEW CODE
				//Create list of styles for user to choose
				$BarStyleFolders=GetFolders($WebMS["ModulesPath"] ."PageRate/Bars/");

				if (count($BarStyleFolders)) {
					foreach ($BarStyleFolders as $folder) {
						echo "<div style='text-decoration:underline;'><b>$folder</b></div>";
						$BarStyleFiles = GetFiles($WebMS["ModulesPath"]."PageRate/Bars/$folder/");
						echo "<div style='padding-left:10px'>";

						foreach ($BarStyleFiles as $file) {
							$filen=explode(".",$file);
							if (strcmp($folder.'/'.$file,$pageratebarb[0].'/'.$pageratebarb[1])==0) {
								echo "<div style='border:1px solid black'><img src='".$WebMS['ModulesUrl']."PageRate/Bars/$folder/$file' /><a href='".url(array("*","*","*",$folder,str_replace(".","-D0T-",$file)))."' style='position:relative; top: -0.50em; left: 0.5em;'>$filen[0]</a></div>";
							} else {
								echo "<img src='".$WebMS['ModulesUrl']."PageRate/Bars/$folder/$file' /><a href='".url(array("*","*","*","Fore",$folder,str_replace(".","-D0T-",$file)))."' style='position:relative; top: -0.50em; left: 0.5em;'>$filen[0]</a><br>";
							}
						}

						echo "</div><br>";
					}
				}
				?>
				</div>
			</div>
		</div>
		
		<div class="fieldset" style="float: left; margin-left: 10px; margin-top: 10px;">
			<div class="ftitle"><b>Preview:</b></div><br>
			<div style="width:200px; height:154px;">
				<div style="padding:10px">
					<img src="<?=$WebMS['ModulesUrl']."PageRate/Bars/".$pageratebarb[0].'/'.$pageratebarb[1]?>">
					<img src="<?=$WebMS['ModulesUrl']."PageRate/Bars/".$pageratebarb[0].'/'.$pageratebarb[1]?>">
					<img src="<?=$WebMS['ModulesUrl']."PageRate/Bars/".$pageratebarb[0].'/'.$pageratebarb[1]?>">
					<img src="<?=$WebMS['ModulesUrl']."PageRate/Bars/".$pageratebara[0].'/'.$pageratebara[1]?>">
					<img src="<?=$WebMS['ModulesUrl']."PageRate/Bars/".$pageratebara[0].'/'.$pageratebara[1]?>">
				</div>
			</div>
		</div>
		</div>
		<?php
	}
}

//call it into page
$page->add('PageRater');



?>