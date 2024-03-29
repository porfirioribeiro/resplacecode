<?php
/**
* Module class
* Contains the code to build the Modules for the site
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright � 2007 ResPlace Team
* @lastedit 12-05-07
*/

class Module{
	const TOP="top";
	const LEFT="left";
	const CENTER="center";
	const RIGHT="right";
	const BOTTOM="bottom";
	/**
	 * @var WebMS
	 */
	var $page=null;
	var $title="Def Title";
	var $side=Module::CENTER;
	var $collapseAble=true;
	var $minimizeAble=true;
	
	/**
	 * Creates a module, this function is mostly called internal
	 * @param WebMS $page
	 * @return Module
	 */
	function Module($page){
		$this->page=$page;
	}
	function addContent($fn){
		$this->content2=$fn;
	}
	function setContentS($s){
		$this->contentS=$s;
	}
	function write(){
		$module="MODULE_".preg_replace("/\W*/","",$this->title);
		$minTitle=preg_replace("/[^a-z0-9_+& ]*/i","",$this->title);
		$p=$this->page;
		ob_start();
		$this->content();
		$content=ob_get_contents();
		ob_end_clean();
		$data=array(
			"title"=>$this->title,
			"id"=>$module,
			"cookie"=>$module."_Cookie",
			"collapsed" =>(isset($_COOKIE[$module."_Cookie"]) && ($_COOKIE[$module."_Cookie"]=="true")),
			"content" =>$content
		);		
		$modcont=null;
		$tpl=$p->moduleTpl;
        if ($this->side==Module::LEFT){
        	if ($tpl->isPart("left")){
        		$modcont=$tpl->get("left")->evaluate($data); 
        	}	                 
        }elseif ($this->side==Module::CENTER){  
        	if ($tpl->isPart("center")){
        		$modcont=$tpl->get("center")->evaluate($data); 
        	} 	      	
        }elseif ($this->side==Module::TOP){  
        	if ($tpl->isPart("top")){
        		$modcont=$tpl->get("top")->evaluate($data); 
        	}   	
        }elseif ($this->side==Module::BOTTOM){  
        	if ($tpl->isPart("bottom")){
        		$modcont=$tpl->get("bottom")->evaluate($data); 
        	}    	
        }elseif ($this->side==Module::RIGHT){        
        	if ($tpl->isPart("right")){
        		$modcont=$tpl->get("right")->evaluate($data); 
        	}	   
        }
		if ($modcont==null){
			$modcont=$tpl->get("default")->evaluate($data);
		}
		echo $modcont;
		$this->finish();
	}
	function content(){		
		if (isset($this->content2)){
			$fn=$this->content2;
			if (function_exists($fn)){
				$fn($this);	
			}			
		}
		if (isset($this->contentS)){
			echo $this->contentS;
		}
	}	
	function finish(){
		//code to be executed on the end
	}
}
?>
