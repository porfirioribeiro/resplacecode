<?php
include_once "setup.php";
session_start();

class WebMS{
	static $self;
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
	var $defaultskin="Rigid/Blue/";
	var $CSS_files=Array();
	var $JS_files=Array();
	var $JS_filez=Array();
	var $JS_codes=Array();
	var $Metas=Array();
	var $OnLoads="";
	var $RSS=Array();
	var $imgPreload=array();
	var $NoScript=false;
	var $ShowNSWarn=true;
	var $ModulesTop=array();
	var $ModulesLeft=array();
	var $ModulesCenter=array();
	var $ModulesRight=array();
	var $ModulesBottom=array();
	var $alerts=array();
	//templates
	var $module_main;
	var $module_left;
	var $module_right;
	var $module_center;
	var $module_top;
	var $module_bottom;
	var $page_content;
	function WebMS($_path="data/",$_title=""){
		$this->self=$this;
		$AbsRootPath=preg_replace("/data(\/|\\\)site.php/","",__FILE__);
		$AbsRootPath=preg_replace("/\\\/","/",$AbsRootPath);
		$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);	
		$this->absRoot=$AbsRootPath;
		$this->root=$RootPath;	
	    $this->id=str_replace(array("/","\\","-"," ","."),"_",$_SERVER['PHP_SELF']);
	    $this->path=$_path;
	    $this->themespath=$this->path.$this->themespath;
	    $this->modulespath=$this->path.$this->modulespath;
	    $this->functionspath=$this->path.$this->functionspath;
	    $this->libpath=$this->path.$this->libpath;
	    $this->stylepath=$this->path.$this->stylepath;
		$this->title=$_title." - tpvgames.co.uk";
		$this->modulesSearchPath[]=$this->modulespath;
		$this->functionsSearchPath[]=$this->functionspath;
		if (isset($_GET["NoScript"])){	
			$this->NoScript=true;			
		}elseif (isset($_GET["Script"])){
			$this->NoScript=false;
		}else {
			$this->NoScript=($_COOKIE["NoScript"]=="true");
		}
		setcookie("NoScript",$this->NoScript?"true":"false");
		if (isset($_GET["CloseNoScript"])){
			setcookie("ShowNSWarn","false");		
			$this->ShowNSWarn=false;
		}else {
			$this->ShowNSWarn=($_COOKIE["ShowNSWarn"]!="false");
		}
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
			$this->JS_files[]=$lib;
		}		
	}
	function addJSCode($code){
		$this->JS_codes[]=$code;
	}
	function embedJS($file){
		$lib=$this->findFilesOnPath(array($this->libpath,""),$file);
		if ($lib!=null){
			$this->JS_filez[]=$lib;
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
		$this->addJS("cookie.js");	
		$this->addJS("site.js");	
		$this->addOnLoad("el=$('AjaxLoader');if (el){el.hide();Ajax.Responders.register({onCreate: function(){el.show();},onComplete: function(){if(Ajax.activeRequestCount==0){el.hide();}}})}");
		foreach ($this->functionsSearchPath as $fpath) {
			$this->loadFunctions($fpath);
		}					
	}
	function create(){
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
	if ($this->NoScript){
	?>
		document.location="<?=$_SERVER['PHP_SELF'];?>?Script";
	<?php	
	}
	?>		
	</script>
    <title><?php echo $this->title; ?></title>        
  </head> 
  <body onload="__preload_images();<?php echo $this->OnLoads?>"> 
	<?php 				
	if ($this->ShowNSWarn){
	?>		
		<noscript>
			<div class="AlertBox">		
				<div class="warn"></div>	
				<a class="close" href="<?=$_SERVER['PHP_SELF'];?>?CloseNoScript&amp;NoScript"></a>	
				Your browser does not seem to support JavaScript which is required for some features of this website, please enable JavaScript or update your browser, then refresh the page.			
				<?php
				if (!$this->NoScript){									
				?>
				<a href="<?=$_SERVER['PHP_SELF'];?>?NoScript">Go to NoScript page</a>
				<?php
				}
				?>
			</div>		
		</noscript> 
	<?php
	}
	?>		
	<?php 				
	if ($this->NoScript){									
	?>
	<script type="text/javascript" language="JavaScript">
		document.location="<?=$_SERVER['PHP_SELF'];?>?Script";
	</script> 
	<?php
	}
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
		echo $this->page_title->evaluate(array());
		
		//place the page content as desired
		//theme_shell($this->ModulesTop,$this->ModulesLeft,$this->ModulesCenter,$this->ModulesTop,$this->ModulesRight,$this->ModulesBottom);
		
		ob_start();
		
		foreach ($this->ModulesTop as $value){
			$value->write();
		}
		$modulestopout=ob_get_clean();
		ob_start();
		
		$modulestopstyle=count($this->ModulesTop)==0?"display: none":"";
		
		foreach ($this->ModulesLeft as $value){
			$modulesleftout=$value->write();
		}
		$modulesleftout=ob_get_clean();
		ob_start();
		
		$modulesleftstyle=count($this->ModulesLeft)==0?"display: none":"";
		
		foreach ($this->ModulesRight as $value){
			$modulesrightout=$value->write();
		} 
		$modulesrightout=ob_get_clean();
		ob_start();
		
		$modulesrightstyle=count($this->ModulesRight)==0?"display: none":"";
		
		foreach ($this->ModulesCenter as $value){
			$modulescenterout=$value->write();
		}
		$modulescenterout=ob_get_clean();
		ob_start();
		
		$modulescenterstyle=count($this->ModulesCenter)==0?"display: none":"";
		
		foreach ($this->ModulesBottom as $value){
			$modulesbottomout=$value->write();
		}
		$modulesbottomout=ob_get_clean();
		//ob_end_clean();
		
		$modulesbottomstyle=count($this->ModulesBottom)==0?"display: none":""; 
		//var_dump($modulesbottomout);
		
		echo $this->page_content->evaluate(array(
			"write_modulestop"=>$modulestopout,"display_modulestop"=>$modulestopstyle,
			"write_modulesleft"=>$modulesleftout,"display_modulesleft"=>$modulesleftstyle,
			"write_modulesright"=>$modulesrightout,"display_modulesright"=>$modulesrightstyle,
			"write_modulescenter"=>$modulescenterout,"display_modulescenter"=>$modulescenterstyle,
			"write_modulesbottom"=>$modulesbottomout,"display_modulesbottom"=>$modulesbottomstyle));
		
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
		}else if (class_exists($mod) && is_subclass_of($mod,Module)){
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
			($sortorder == 0) ? asort($contents) : rsort($contents);
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
