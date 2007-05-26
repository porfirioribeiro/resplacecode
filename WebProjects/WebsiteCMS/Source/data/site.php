<?php

session_start();
include_once "lib/error_reporter.php";
include_once "setup.php";
class WebMS{
	
	private $cr_clmn="";
	var $title="";
	var $content_type="text/html; charset=windows-1250";
	var $favicon="http://tpvgames.co.uk/favicon.ico";
	var $description="tpvgames and shit";
	var $keywords="tpvgames,shit";
	var $id=""; //?what is this
	var $root=""; //?what is this
	var $absRoot="";
	var $path="data/";
	var $themespath="Themes/";
	var $modulespath="Modules/";
	var $modulesSearchPath=array();
	var $functionsSearchPath=array();
	var $functionspath="Functions/";
	var $libpath="lib/";
	var $stylepath="Style/";
	var $credits=Array();
	var $selectedskin="";
	var $defaultskin="Bubble/RoyalBlue/";
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
	var $resdbq=0;
	//templates
	var $moduleTpl;
	var $pageTpl;
	var $menuTpl;
	function WebMS($_path="data/",$_title=""){
		$this->self=$this;
		$AbsRootPath=preg_replace("/data(\/|\\\)site.php/","",__FILE__);
		$AbsRootPath=preg_replace("/\\\/","/",$AbsRootPath);
		$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);	
		$this->absRoot=$AbsRootPath;
		$this->root=$RootPath;	
		$this->id=$_SERVER['PHP_SELF'];
		if (isset($_REQUEST['page'])){
			$this->id.=$_REQUEST['page'];
		}
	    $this->id=str_replace(array("/","\\","-"," ","."),"_",$this->id);
	    $this->path=$_path;
	    $this->themespath=$this->path.$this->themespath;
	    $this->modulespath=$this->path.$this->modulespath;
	    $this->functionspath=$this->path.$this->functionspath;
	    $this->libpath=$this->path.$this->libpath;
	    $this->stylepath=$this->path.$this->stylepath;
		$this->title=$_title." - resplace.net";
		$this->modulesSearchPath[]=$this->modulespath;
		$this->functionsSearchPath[]=$this->functionspath;
	}
	function addCSS($file){
		$style=$this->findFilesOnPath(array($this->stylepath,""),$file);
		if ($style!=null){
			$this->CSS_files[]=$style;
		}		
	}
	function addJS($file){
		$lib=$this->findFilesOnPath(array($this->libpath,""),$file);
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
	function addDefaults(){		
		$this->addJS("prototype.js");	
		$this->addJS("protoExt.js");
		$this->addJS("cookie.js");	
		$this->addJS("site.js");	
		$this->addOnLoad("el=$('AjaxLoader');if (el){el.hide();Ajax.Responders.register({onCreate: function(){el.show();},onComplete: function(){if(Ajax.activeRequestCount==0){el.hide();}}})}");
		foreach ($this->functionsSearchPath as $fpath) {
			$this->loadFunctions($fpath);
		}					
	}
	function create(){
	
	//developer mode alert
	if ($_SESSION['developer_mode']==true) {
		$this->addAlert("Developer Mode","You are currently in Developer Mode, any errors that occur will cause an automatic halt of the system. Also you can view some useful variables at the bottom of the page. <br><b>Note:</b><i>developer mode is only active on the machine + browser you activated it on via a session.</i>");
	}
    ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="<?=$this->content_type; ?>">
    <meta name="generator" content="PSPad+Aptana+ZendStudio">
    <meta name="description" content="<?php echo $this->description; ?>">
    <meta name="keywords" content="<?php echo $this->keywords; ?>">
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
    <?php
    foreach ($this->JS_files as $key=>$value) {
    	echo '<script src="'.$value.'" type="text/javascript" language="JavaScript"></script>'."\n";
    }
    ?>
    <script type="text/javascript" language="JavaScript">
    	function __onloads(){
    		<?php echo $this->OnLoads?>
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
  <body onload="__preload_images();__onloads();"> 
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
	?>		
	<?php 				
	foreach ($this->alerts as $ale => $alert) {
		?>
		<div class="AlertBox">
		<div class="warn"></div>	
		<?=$alert["text"]?>
		</div>
		<?php
	}
	
	
	?>			  
    <div class="MainFrame">            
        <?php
		
		//place title code
		//echo $this->theme_title;
		echo $this->pageTpl->get("title")->evaluate(array());
		
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
		echo $this->pageTpl->get("footer")->evaluate(array("ResDB_queries"=>$this->resdbq));
		
		//developer mode
		if ($_SESSION['developer_mode']==true) {
			echo'<br><br><hr><div align="left"><b>$_REQUEST:</b><br>';
			foreach($_REQUEST as $key=>$value) 
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$key => $value<br>";
			echo'</div>';
		}
		?> 
		                			
    </div>        
  </body>
</html>
    <?php
	}
	function addF($fn,$title,$side=Module::CENTER ,$pos="bottom"){		
		$mod=new Module($this);
		$mod->addContent($fn);
		$mod->title=$title;
		$this->add($mod,$side,$pos);
	}
	function add($mod,$side=null,$pos="bottom"){	
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
						include $dir.$item;
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
