<?php
/**
* LoadSkin Script<br>
* This script manages the loading of the default, the selected, or finds an existing skin.
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright © 2007 ResPlace Team
* @lastedit 14-05-07
*/

if (isset($_POST['SkinMenu'])){
	$_SESSION['currentskin']=$_POST['SkinMenu'];
}

//is a skin selected?
if (isset($_SESSION['currentskin'])){
	//does it exist?
	if (file_exists($this->themespath.$_SESSION['currentskin']."/style.css")){
		$patt=apply_skin($this->themespath,$_SESSION['currentskin']);
		$this->selectedskin=$_SESSION['currentskin'];
		include($this->themespath.$patt."theme.php");
		$skindone=1;
	}
}

//load default or find if no skin was in session
if (!$skindone==1){

	//try and load the default skin
	if (file_exists($this->themespath.$this->defaultskin."/style.css")){
		$patt=apply_skin($this->themespath,$this->defaultskin);
		$this->selectedskin=$this->defaultskin;
		include($this->themespath.$patt."theme.php");
	}else{
		//load a skin we can find :)
		$contents=GetFolders($this->themespath);

		if(is_array($contents))	{
			foreach($contents as $item){
			
				//echo "-->".$this->themespath.$item."/<br>";
				$contents2=GetFolders($this->themespath.$item."/");
				
				if(is_array($contents2))	{
					foreach($contents2 as $item2){
						
						//echo "<br>".$this->themespath.$item."[".$item2."]"."/theme.php"."<br>";
						if (file_exists($this->themespath.$item."/".$item2."/style.css") && (!$done==1))	{
							
							//$this->addCSS($this->themespath.$item."/theme.php");
							$this->selectedskin=$item."/".$item2."/";
							$patt=apply_skin($this->themespath,$this->selectedskin);
							$this->selectedskin=$this->selectedskin;
							include($this->themespath.$patt."theme.php");
							$skindone=1;
							break;
						}
					}
				}	
			}
		}

		if (!$done==1){
			//Well we tryed our best, time to DIE!!
			die("The default skin is missing and no other skins could be found in the themes/ directory. Without a skin this system does not work...");
		}
	}
}

function apply_skin($themespath,$skinpath) {
	//global WebMS::page;
	$ex=explode("/",$skinpath);
	if (file_exists($themespath.$ex[0]."/theme.php")){
		return $ex[0].'/';
		
	}else if (file_exists($themespath.$skinpath."theme.php")){
		return $skinpath;
		
	}else{
		die("Fatal error, theme.php was not found when loading skin: ".$themespath.$skinpath);
	}
	
}


?>
