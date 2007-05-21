<?php
/**
* Module class<br>
* Contains the code to build the Modules for the site
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright © 2007 ResPlace Team
* @lastedit 12-05-07
*/

class Module{
	const TOP="top";
	const LEFT="left";
	const CENTER="center";
	const RIGHT="right";
	const BOTTOM="bottom";
	var $page=null;
	var $title="Def Title";
	var $side=Module::CENTER;
	var $collapseAble=true;
	var $minimizeAble=true;
	function Module($page){
		$this->page=$page;
	}
	function addContent($fn){
		$this->content2=$fn;
	}
	function write(){
		$module="MODULE_".preg_replace("/\W*/","",$this->title);
		$moduleContainerID=$module."_CT";
		$moduleCALeft=$module."_CAL";
		$moduleCARight=$module."_CAR";
		$minTitle=preg_replace("/[^a-z0-9_+& ]*/i","",$this->title);
		$p=$this->page;
		$display=$this->NoScript?"":$_COOKIE[$module."_CL"];
		$isDisplay=($display=="none");
		$data=array(
			"module_title"=>$this->title,
			"module_id"=>$module,
			"module_id_right" =>$moduleCARight,
			"module_id_left"  =>$moduleCALeft,
			"module_id_container"=>$moduleContainerID,
			"module_display"=>$display,
			"module_collapsed" =>($_COOKIE[$module."_CL"]=="none")
		);
		$tpl=$p->moduleTpl;
        if ($this->side==Module::LEFT){
			$modcont=$tpl->get("left")->evaluate($data);                  
        }elseif ($this->side==Module::CENTER){  
           $modcont=$tpl->get("center")->evaluate($data);  	      	
        }elseif ($this->side==Module::TOP){  
           $modcont=$tpl->get("top")->evaluate($data);      	
        }elseif ($this->side==Module::BOTTOM){  
           $modcont=$tpl->get("bottom")->evaluate($data);     	
        }elseif ($this->side==Module::RIGHT){        
           $modcont=$tpl->get("right")->evaluate($data);	   
        }			
		ob_start();
		echo'<div>';
		$this->content();
		echo'</div>';
		$woot=ob_get_contents();
		ob_end_clean();
		$data["module_header"]=$modcont;
		$data["module_content"]=$woot;
		echo $modcont=$tpl->get("main")->evaluate($data);
		$this->finish();
	}
	function content(){		
		$fn=$this->content2;
		$fn($this);	
	}	
	function finish(){
		//code to be executed on the end
	}
}
?>
