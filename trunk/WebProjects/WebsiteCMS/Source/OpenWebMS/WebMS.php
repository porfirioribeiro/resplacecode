<?php

/**
* System Shell
* The system shell (the centre of WebMS)
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-10-07
*/

//ob_start("ob_gzhandler");

include_once dirname(__FILE__).'/config.php';
global $WebMS;
WebMS::$_config=$WebMS;
class WebMS{
	private $cr_clmn="";
	static $_config;
	var $config;
	var $devMode=false;
	var $title="";
	var $content_type="text/html; charset=utf-8";
	var $favicon="favicon.ico";
	var $description="OpenWebMS Driven Website";
	var $keywords="OpenWebMS, resplace, resplace.net";
	var $id="";
	var $root="";
	var $absRoot="";
	
	//system vars (some overwritten by DB values later)
	var $path="OpenWebMS/";
	var $themespath="Themes/";
	var $corepath="Core/";
	var $modulespath="Modules/";
	var $modulesSearchPath=array();
	var $pagebegin=0;
	var $functionsSearchPath=array();
	var $functionspath="Functions/";
	var $JSSearchPath=array();
	var $credits=Array();
	var $selectedskin="";
	var $defaultskin="";
	var $CSS_files=Array();
	var $JS_files=Array();
	var $JS_filez=Array();
	var $JS_codes=Array();
	var $Metas=Array();
	var $OnLoads="";
	var $RSS=Array();
	var $imgPreload=array();
	var $ShowNSWarn=true;
	var $ModulesTop=array();
	var $ModulesLeft=array();
	var $ModulesCenter=array();
	var $ModulesRight=array();
	var $ModulesBottom=array();
	var $alerts=array();
	var $globallogo="no";

	//templates
	var $moduleTpl;
	var $pageTpl;
	var $menuTpl;
	function WebMS($_path="data/",$_title=""){
		global $WebMS;
		$this->config=WebMS::$_config;
		
		//start site timer
		$starttime = explode(' ', microtime());
		$this->pagebegin=$starttime[1] + $starttime[0];
		
		$adminpassword=$WebMS["AdminPassword"];
		$this->defaultskin=$WebMS["DefaultSkin"];
		$this->globallogo=$WebMS["GlobalLogo"];
		
		//activate/deactivate dev mode
		//dev mode can leak sensitive data, so lets MAKE SURE they can access it!
		//Ok first lets load non UMS permissions
		if (!$WebMS['Integrate'] && !$WebMS['UMS']) {
			$db=new ResDB("WebMSoptions");
			$psswd=$db->get("adminpassword");
			if ($psswd=="") {
				$psswd=md5($WebMS["FailSafeLogin"]);
			}
			
			if ((isset($_SESSION['admin_session'])) && ($_SESSION['admin_session']==$psswd)) {
				$WebMS["User_Userlvl"]=2;
			}
		}
		
		//Are they an administrator?
		if ($WebMS["User_Userlvl"]==2) {
			if (isset($WebMS["URLArray"][1]) && $WebMS["URLArray"][1]=="DevMode") {
				$_SESSION['developer_mode']=(((!isset($_SESSION['developer_mode'])) || ($_SESSION['developer_mode']==false)) ? true:false);
			}
		}
		
		$this->devMode=isset($_SESSION['developer_mode']) && $_SESSION['developer_mode'];
		$this->self=$this;
		$this->id=$_SERVER['PHP_SELF'];
		//TODO is this replacement corrent?
		//if (isset($_REQUEST['page'])){
		//	$this->id.=$_REQUEST['page'];
		//}
		$tid="";
		foreach($WebMS["URLArray"] as $i) {
			$tid.=$i;
		}
		$this->id=$tid;
		
	   $this->id=str_replace(array("/","\\","-"," ","."),"_",$this->id);
	   $this->path=$_path;
	   $this->themespath=$this->path.$this->themespath;
	   $this->modulespath=$this->path.$this->modulespath;
	   $this->functionspath=$this->path.$this->functionspath;
		$this->corepath=$this->path.$this->corepath;
//	    $this->libpath=$this->path.$this->libpath;
//	    $this->stylepath=$this->path.$this->stylepath;
		$this->title=$_title." - resplace.net";
		$this->JSSearchPath[]="";
		$this->modulesSearchPath[]=$this->config["UserModulesPath"];
		$this->modulesSearchPath[]=$this->config["ModulesPath"];
		$this->functionsSearchPath[]=$this->functionspath;
		$_css=GetFiles($WebMS["CorePath"]."Styles/","*.css");
		

	   foreach ($_css as $_c){
			$this->addCSS($WebMS["CoreUrl"]."Styles/".$_c);
	   }
		
	    //LOAD DEFAULTS
		$this->addJS("prototype.js");	
		$this->addJS("protoExt.js");
		$this->addJS("cookie.js");	
		$this->addJS("site.js");
		$this->addJS("menu.js");	
		$this->addOnLoad("el=$('AjaxLoader');if (el){el.hide();Ajax.Responders.register({onCreate: function(){el.show();},onComplete: function(){if(Ajax.activeRequestCount==0){el.hide();}}})}");		
	}
	function addCSS($file){
		//$style=$this->findFilesOnPath(array(""),$file);
		$style=$file;
		if ($style!=null){
			$this->CSS_files[]=$style;
		}		
	}
	private function findJS($file){
		$lib=$this->findFilesOnPath($this->JSSearchPath,$file);
		if ($lib){
			return $lib;
		}else if (is_file($this->config["JSPath"].$file)){
			return $this->config["JSUrl"].$file;
		}else if ($this->config["UserJSPath"].$file) {
			return $this->config["UserJSUrl"].$file;
		}
	}
	function addJS($file){
		$lib=$this->findJS($file);
		if ($lib!=null){
			if (array_search($lib,$this->JS_files)===false){
				$this->JS_files[]=$lib;			
			}		
		}		
	}
	function addJSCode($code){
		$this->JS_codes[]=$code;
	}
	function embedJS($file){
		$lib=$this->findFilesOnPath(array($this->libpath,""),$file);
		if ($lib!=null){
			if (array_search($lib,$this->JS_filesz)===false){
				$this->JS_filesz[]=$lib;			
			}				
		}	
	}
	function addMeta($meta){
		$this->Metas[]=$meta ;
	}
	function addRSS($title,$href){
		$this->RSS[]=Array("title"=>$title,"href"=>$href);
	}
	function addOnLoad($js){
		$this->OnLoads.=$js.";";
	}
	function addPreloadImg($img){
		$this->imgPreload=array_merge($this->imgPreload,(array)$img);
	}
	function addModuleSearchPath($p){
		$this->modulesSearchPath[]=$p;
	}
	function addFunctionSearchPath($p){
		$this->functionsSearchPath[]=$p;
	}

	function create(){
	global $browser, $WebMS;
	
	//Add any requested functions
	foreach ($this->functionsSearchPath as $fpath) {
			$this->loadFunctions($fpath);
		}	
	
    ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
   <meta http-equiv="content-type" content="<?=$this->content_type; ?>">
   <meta name="generator" content="PSPad+Aptana+ZendStudio+Eclipse+Notepad2">
   <meta name="description" content="<?php echo $this->description; ?>">
   <meta name="keywords" content="<?php echo $this->keywords; ?>">
   <link rel="shortcut icon" href="<?php echo $WebMS["WebMSUrl"].'/'.$this->favicon; ?>">
   <?php
   foreach ($this->Metas as $key=>$meta) {
		$str="";
    	foreach ($meta as $key=>$value){
    		$str.=' '.$key.'="'.$value.'"';
   	}
    	echo "<meta".$str.">"."\n";
   }
   foreach ($this->RSS as $key=>$value) {
    	echo '    <link rel="alternate" type="application/rss+xml" title="'.$value["title"].'" href="'.$value["href"].'">'."\n";
   }
   ?>
   <?php
   foreach ($this->CSS_files as $key=>$value) {
   	echo '<link rel="stylesheet" href="'.$value.'" type="text/css">'."\n";
   }
   ?>
	<script type="text/javascript" language="javascript">
		var htcpath="<?=$WebMS['JSPath']; ?>";
		var WebMS_JS_URL="<?=$WebMS['JSUrl']; ?>";
	</script>
    <?php
    foreach ($this->JS_files as $key=>$value) {
    	echo '<script src="'.$value.'" type="text/javascript" language="JavaScript"></script>'."\n";
    }
    //$br = new Browser;
	if (($browser->Name=="MSIE") && ((int)$browser->Version>=5) && ((int)$browser->Version<=6)) {
		?>
		<style>
			.alpha { behavior: url(<?=$this->path.'Core/JS/'; ?>iepngfix.htc); }
		</style>
		<?php
		}
	?>
    <script type="text/javascript" language="JavaScript">
    	function __onloads(){
    		<?php echo $this->OnLoads."\n"?>
    	}
    	var Site={
    		path:"<?=$this->path?>"
    	};
    	var __preload__images=[];
    	function __preload_images(){
   	<?php
	foreach ($this->imgPreload as $key => $value) {
		?>
		__preload__images[<?=$key?>]=new Image();
		__preload__images[<?=$key?>].src='<?=$value?>';
		<?php
	}
	?>
    	}
	<?php
	foreach ($this->JS_filez as $key=>$value) {
    	include $value;
    }
	foreach ($this->JS_codes as $key=>$value) {
    	echo $value."\n";
    }    
	?>
	</script>
    <title><?php echo $this->title; ?></title>        
  </head> 
  <body onload="<?=count($this->alerts)?"Effect.SlideDown('AlertBox');$('AlertBox').setOpacity(0.8);":""?>__preload_images();__onloads();"> 
	<?php 				
	if ($this->ShowNSWarn){
	?>		
		<noscript>
			<div class="AlertBox">		
				<div class="warn"></div>	
				Your browser does not seem to support JavaScript which is required for some features of this website, please enable JavaScript or update your browser, then refresh the page.			
			</div>		
		</noscript> 
	<?php
	}
	if (count($this->alerts)>0){
		
		?>		
		<div class="AlertBox" id="AlertBox" style="display: none;" onmouseover="$(this).setOpacity(1);" onmouseout="$(this).setOpacity(0.8);">
			<div>
				<div class="warn"></div>
				<div class="box">
				<?php 				
				foreach ($this->alerts as $ale => $alert) {
					echo $alert["text"];
					if ($ale<count($this->alerts)-1){
						echo "<hr>";
					}
				}
				?>
				</div>
				<a href="javascript:;" class="close" onclick="Effect.Fade('AlertBox');Effect.SlideUp('AlertBox')">&nbsp;</a>
			</div>
		</div>
		<?php
	}
	?>			  
    <div class="MainFrame">            
        <?php
		
		//place title code
		//echo $this->theme_title;
		if ($this->globallogo=="yes"){
			$globallogo=true;
		} else {
			$globallogo=false;
		}
        
		echo $this->pageTpl->get("title")->evaluate(array("GlobalLogo"=>$globallogo,
			"GlobalLogoPath"=>$WebMS["ThemesUrl"].'sitelogo.png'));
		
		//place the page content as desired
		//theme_shell($this->ModulesTop,$this->ModulesLeft,$this->ModulesCenter,$this->ModulesTop,$this->ModulesRight,$this->ModulesBottom);
		
		ob_start();
		
		foreach ($this->ModulesTop as $value){
			$value->write();
		}
		$modulestopout=ob_get_contents();
		ob_end_clean();
		ob_start();
		
		$modulestopstyle=count($this->ModulesTop)==0?"display: none":"";
		
		foreach ($this->ModulesLeft as $value){
			$modulesleftout=$value->write();
		}
		$modulesleftout=ob_get_contents();
		ob_end_clean();
		ob_start();
		
		$modulesleftstyle=count($this->ModulesLeft)==0?"display: none":"";
		
		foreach ($this->ModulesRight as $value){
			$modulesrightout=$value->write();
		} 
		$modulesrightout=ob_get_contents();
		ob_end_clean();
		ob_start();
		
		$modulesrightstyle=count($this->ModulesRight)==0?"display: none":"";
		
		foreach ($this->ModulesCenter as $value){
			$modulescenterout=$value->write();
		}
		$modulescenterout=ob_get_contents();
		ob_end_clean();
		ob_start();
		
		$modulescenterstyle=count($this->ModulesCenter)==0?"display: none":"";
		
		foreach ($this->ModulesBottom as $value){
			$modulesbottomout=$value->write();
		}
		$modulesbottomout=ob_get_contents();
		ob_end_clean();
		//ob_end_clean();
		
		$modulesbottomstyle=count($this->ModulesBottom)==0?"display: none":""; 
		//var_dump($modulesbottomout);
		
		echo $this->pageTpl->get("content")->evaluate(array(
			"write_modulestop"=>$modulestopout,"display_modulestop"=>$modulestopstyle,
			"write_modulesleft"=>$modulesleftout,"display_modulesleft"=>$modulesleftstyle,
			"write_modulesright"=>$modulesrightout,"display_modulesright"=>$modulesrightstyle,
			"write_modulescenter"=>$modulescenterout,"display_modulescenter"=>$modulescenterstyle,
			"write_modulesbottom"=>$modulesbottomout,"display_modulesbottom"=>$modulesbottomstyle));
		
		//send out the footer
		$starttime = explode(' ', microtime());
		
		
		
		echo $this->pageTpl->get("footer")->evaluate(array(
			"imgpath"=>$this->themespath.$this->selectedskin."Images/",
			"ResDB_queries"=>ResDB::$resdbopen+ResDB::$resdbclose,
			"WebMS_load"=>round(($starttime[1] + $starttime[0])-$this->pagebegin,2)));
		
		//developer mode
		if ($this->devMode) {
			?><div class="ErrorO ErrorRel">
			<div class="Title">Debug:</div>
			<div class="Content">
			<a name="goto1"> </a>
			<b><a href="#goto1" style="text-decoration: none;" onclick="$('WEBMS_DEBUG_1').toggle()">$_REQUEST:</a></b><br>
			<table style="display: none;" id="WEBMS_DEBUG_1"><?php
			foreach ($_REQUEST as $key=>$value):
				?>
				<tr>
					<td align="left"><?=$key ?></td>
					<td align="center" width="25"><b>=&gt;</b></td>
					<td align="left"><?=$value ?></td>
				</tr>
				<?php	
			endforeach;
			?></table>
			<br>
			<a name="goto2"> </a>
			<b><a href="#goto2" style="text-decoration: none;" onclick="$('WEBMS_DEBUG_2').toggle()">$WebMS:</a></b><br>
			<table style="display: none;" id="WEBMS_DEBUG_2"><?php
			foreach ($WebMS as $key=>$value):
				?>
				<tr>
					<td align="left"><?=$key ?></td>
					<td align="center" width="25"><b>=&gt;</b></td>
					<td align="left"><?=$value ?></td>
				</tr>
				<?php	
			endforeach;
			?></table>
			</div></div><?php
		}
		?> 
		                			
    </div>        
  </body>
</html>
    <?php
	}
	
	function addModule($in,$title,$side=null,$allowminimized=true,$collapsed=false,$titled=true,$automated=false,$timingshow=null,$timinghide=null,$pos="bottom"){
		if (is_object($in)) {
	   	//this is an object
	   	$mod=$in;
		} else if (class_exists($in) && is_subclass_of($in,"Module")) {
			$mod=new $in($this);
		} else if (function_exists($in)) {
			//this is a function
			$mod=new Module($this);
			$mod->addContent($in);
		} else {
			$m=$this->findFilesOnPath($this->modulesSearchPath,$in.".php");
			if ($m!=null) {
				include_once $m;
				$mod=new $in($this);
			} else {
				//this must be a string...
				$mod=new Module($this);
				$mod->setContentS($in);
			}
		}

      if (!$title==null) {
			$mod->title=$title;
		}
		$mod->allowminimized=$allowminimized;
		$mod->collapsed=$collapsed;
		$mod->titled=$titled;
		$mod->automated=$automated;
		$mod->timingshow=$timingshow;
		$mod->timinghide=$timinghide;
		
		if (!$side){
			$side=$mod->side;
		}else{
			$mod->side=$side;
		}
		switch ($side) {
			case Module::TOP:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesTop,$mod);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesTop,$mod);
				}
			break;
			case Module::LEFT:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesLeft,$mod);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesLeft,$mod);
				}
			break;
			case Module::CENTER:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesCenter,$mod);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesCenter,$mod);
				}
			break;
			case Module::RIGHT:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesRight,$mod);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesRight,$mod);
				}
			break;
			case Module::BOTTOM:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesBottom,$mod);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesBottom,$mod);
				}
			break;
		}
  }
  
  
  function addF($fn,$title,$side=Module::CENTER,$allowminimized=true,$collapsed=false,$titled=true,$automated=false,$timingshow=null,$timinghide=null,$pos="bottom"){
		$mod=new Module($this);
		$mod->addContent($fn);
		$mod->title=$title;
		$mod->allowminimized=$allowminimized;
		$mod->collapsed=$collapsed;
		$mod->titled=$titled;
		$mod->automated=$automated;
		$mod->timingshow=$timingshow;
		$mod->timinghide=$timinghide;
		$this->add($mod,$side,$pos);
	}
	function addS($s,$title,$side=Module::CENTER,$allowminimized=true,$collapsed=false,$titled=true,$automated=false,$timingshow=null,$timinghide=null,$pos="bottom"){
		$mod=new Module($this);
		$mod->setContentS($s);
		$mod->title=$title;
		$mod->allowminimized=$allowminimized;
		$mod->collapsed=$collapsed;
		$mod->titled=$titled;
		$mod->automated=$automated;
		$mod->timingshow=$timingshow;
		$mod->timinghide=$timinghide;
		$this->add($mod,$side,$pos);
	}
	function add($mod,$side=null,$allowminimized=true,$collapsed=false,$titled=true,$automated=false,$timingshow=null,$timinghide=null,$pos="bottom"){
		if (is_object($mod)){
			$modl=$mod;
		}else if (class_exists($mod) && is_subclass_of($mod,"Module")){
			$modl=new $mod($this);		
		}else{
			$m=$this->findFilesOnPath($this->modulesSearchPath,$mod.".php");
			if ($m!=null){
				include_once $m;
				$modl=new $mod($this);	
			}
		}
		$modl->allowminimized=$allowminimized;
		$modl->collapsed=$collapsed;
		$modl->titled=$titled;
		$modl->automated=$automated;
		$modl->timingshow=$timingshow;
		$modl->timinghide=$timinghide;

		if (!$side){
			$side=$modl->side;
		}else{
			$modl->side=$side;
		}
		switch ($side) {
			case Module::TOP:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesTop,$modl);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesTop,$modl);
				}
			break;
			case Module::LEFT:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesLeft,$modl);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesLeft,$modl);
				}
			break;
			case Module::CENTER:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesCenter,$modl);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesCenter,$modl);
				}
			break;
			case Module::RIGHT:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesRight,$modl);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesRight,$modl);
				}
			break;
			case Module::BOTTOM:
				if ($pos==Module::BOTTOM){
					array_push($this->ModulesBottom,$modl);
				}else if ($pos==Module::TOP){
					array_unshift($this->ModulesBottom,$modl);
				}
			break;
		}
		
	}
	function addLayout($name){
		global $WebMS;
		if (file_exists($WebMS['UserLayoutsPath'].$name.".php")){
			include($WebMS['UserLayoutsPath'].$name.".php");
		}
	}
	function addAlert($name,$text){
		$this->alerts[]=array("name"=>$name,"text"=>$text);
	}
	function makeStringVertical($text){
		$ttext=str_split($text);
		foreach ($ttext as $each){
			$toreturn=$toreturn.$each."<br>";
		}	
		return $toreturn;
	}
	function loadFunctions($dir){
		global $WebMS;
		
		if(is_dir($dir)){
			$dirlist = opendir($dir);
            while( ($file = readdir($dirlist)) !== false){
				if(!is_dir($file)){
					$contents[] = $file;
				}
			}
			asort($contents);
		}
		
		if(is_array($contents)){
			foreach($contents as $item)	{
				if($item != '.' && $item != '..'){
					$ext = explode('.',$item);
					if($ext[count($ext)-1]=="php")	{
						include_once $dir.$item;
					}
				}
			}
		}
	}
	function findFilesOnPath($arr,$file){
        foreach ($arr as $index => $folder) {    
        	$f=	$folder.$file;
        	if (file_exists($folder.$file)){
        		return $f;
        	}
        }
        return null;
    }
}
?>
