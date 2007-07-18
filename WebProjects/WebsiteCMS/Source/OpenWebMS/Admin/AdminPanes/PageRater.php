<?php
//write and read all settings to DB when/if required
$db=new ResDB("PageRater");
//submits
//administration
if (isset($_POST['Submitit'])) {
	//change main options such as default skin etc...
	if (isset($_POST['select1'])) {
		$db->put("pageratebarbac",($_POST['select1'].'/'.$_POST['select2']));
		$db->put("pageratebar",($_POST['select1'].'/'.$_POST['select3']));
	}
	if (isset($_POST['pageratebg'])) {
		$db->put("pageratebg",($_POST['pageratebg']));
	}
	
}

//read it
$pageratebara=explode("/",$db->get("pageratebar"));
$pageratebarb=explode("/",$db->get("pageratebarbac"));

if (isset($_POST['Submitit'])) { $db->close(); }




//Create the class
class PageRater extends Module {
	function PageRater($page){
		parent::Module($page);
		$this->title="PageRate Module Options";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $WebMS, $path, $adminpassword, $pageratebara, $pageratebarb;
		
		?>
		Below you can change various options for the PageRate Module. Please make sure you have the latest version of this module BEFORE making any module changes.<br /><br />
		
		
		<?php
		//SETUP THE DROP-DOWN LISTS FOR BARS
		//SELECT BAR STYLE
		$BarStyleFiles=GetFolders($WebMS["ModulesPath"] ."PageRate/Bars/");
		$BarStyleCode="";
		$BacStyleCode="";
		$BarCnt=1;
		
		$BarStyleCode=$BarStyleCode.'<option selected value="">Select a style</option>'."\r\n";
		
		if (count($BarStyleFiles)) {
			foreach ($BarStyleFiles as $file) {
				
				$BarStyleCode=$BarStyleCode.'<option value="'.$file.'">'.$file.'</option>'."\r\n";
				$BacStyleFiles=GetFiles($WebMS["ModulesPath"] ."PageRate/Bars/".$file.'/');
				
				$BacStyleCode=$BacStyleCode."if (Indx==".$BarCnt.") { \r\n options[0]=new Option(\"Select Style.\",\"\"); \r\n";
				$BacCnt=1;
				if (count($BacStyleFiles)) {
					foreach ($BacStyleFiles as $file2) {
						$BacStyleCode=$BacStyleCode.'options['.$BacCnt.']=new Option("'.$file2.'","'.$file2.'");'."\r\n";
						$BacCnt=$BacCnt+1;
					}
				}
				$BacStyleCode=$BacStyleCode."} \r\n";
				$BarCnt=$BarCnt+1;
			}
		}
		
		//SELECT BAR COLOR
		?>
		<script language="javascript"> 
			function ldMenu(mySubject) {
				var Indx=mySubject;
				with (document.form2.select2) {
					document.form2.select2.options.length=0;
					if (Indx==0) {
						options[0]=new Option("Select Style First.","");
					}
					<?php
					echo $BacStyleCode;
					?>
					document.form2.select2.options[0].selected=true;
				}
				with (document.form2.select3) {
					document.form2.select3.options.length=0;
					if (Indx==0) {
						options[0]=new Option("Select Style First.","");
					}
					<?php
					echo $BacStyleCode;
					?>
					options[options.length]=new Option("None","none");
					document.form2.select3.options[0].selected=true;
				}
			}
			function goToPage() { 
				PageIndex2=document.form2.select2.selectedIndex 
				if (document.form2.select2.options[PageIndex2].value != "" && document.form2.select3.options[PageIndex2].value != "") { 
					document.form2.Submitit.disabled=false;
				} else {
					document.form2.Submitit.disabled=true;
				}
			}
		</script>
			<form name="form2" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input name="pane" value="PageRater" type="hidden" />
			<fieldset>
				<legend>Change ratings skin:</legend><br />
				<b>Rating bar style:</b><br />
					  <select name="select1" onChange="ldMenu(this.selectedIndex);" size="1">
							<?php
							echo $BarStyleCode;
							?>
					  </select><br />
					  Current: <?=$pageratebara[0]; ?>
					
					<br /><br />
				<b>Bar (Current Rating):</b><br />
						<select name="select2" onChange="goToPage()" size="1">
							<option selected value="Select Style First.">Select Style First.</option>
						</select><br />
					  Current: <?=$pageratebara[1]; ?><br /><br />
				<b>Bar (Background):</b><br />
						<select name="select3" onChange="goToPage()" size="1">
							<option selected value="Select Style First.">Select Style First.</option>
						</select><br />
					  Current: <?=$pageratebarb[1]; ?><br /><br />
						<input name="Submitit" value="Save Changes" type="submit" disabled="disabled" />
				<br /><br />
			</fieldset>
			</form>
			<br /><br />

		<?php
		}
		
	}

//call it into page
$page->add('PageRater');
	

	
?>
