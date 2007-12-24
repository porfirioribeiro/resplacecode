<?php
/**
* Module class
* Contains the code to build the Modules for the site
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 19-09-07
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
	var $title=null;
	var $side=Module::CENTER;
	var $Collapsed=false;
	var $ShowMinimize=true;
	var $ShowTitle=true;
	var $automated=false;
	var $timingshow=null;
	var $timinghide=null;
	var $moduleid=null;
	var $UseTPL=true;
	
	
	//TODO auto show/hiding
	
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
		if ($this->title==null) {
			$this->titleid='Untitled_'.mt_rand(1111,9999);
		} else {
			$this->titleid=$this->title;
		}
		$module="Module_".preg_replace("/\W*/","",$this->titleid);
		$minTitle=preg_replace("/[^a-z0-9_+& ]*/i","",$this->titleid);
  		$p=$this->page;
		ob_start();
		$this->content();
		$content=ob_get_contents();
		ob_end_clean();		
		$modcont=null;
		$tpl=$p->moduleTpl;
		//new
		//Get TPL template
		switch ($this->side) {
			case Module::TOP:
				$this->TPLt="T";
				break;
			case Module::LEFT:
				$this->TPLt="L";
				break;
			case Module::CENTER:
				$this->TPLt="C";
				break;
			case Module::RIGHT:
				$this->TPLt="R";
				break;
			case Module::BOTTOM:
				$this->TPLt="B";
				break;
			default:
				$this->TPLt="D";
				break;
		}


		//Use template?
		if ($this->UseTPL) {
			//show minimizer or not?
			$minimizecode="";
			if ($this->ShowMinimize) {
			   if ($this->ShowTitle) {
			      $stylz="SmallIcon";
			   } else {
			      $stylz="SmallIcon2";
				}
			   if ((isset($_COOKIE[$module."_Cookie"]) && ($_COOKIE[$module."_Cookie"]=="true")) || ($this->Collapsed==true)) {
					$mdd="CollapseIcon";
				} else {
					$mdd="UnCollapseIcon";
				}
				$minimizecode="<div style=\"float:right\" id=\"{$module}_icon\" class=\"{$stylz} {$mdd}\" onclick=\"collapseToogle(this,'{$module}','{$module}_Cookie')\"></div>";
			}
	      //titled or untitled?
	      if ($this->ShowTitle) {
	         $data=array(
	      		"title"=>$this->title,
	      		"id"=>$module,
	      		"cookie"=>$module."_Cookie",
	      		"minimizer"=>$minimizecode,
	      		"collapsed" =>((isset($_COOKIE[$module."_Cookie"]) && ($_COOKIE[$module."_Cookie"]=="true")) || ($this->Collapsed==true)),
	      		"content" =>$content
	      		);

	         $this->TPLd="Titled".$this->TPLt;
	         if (!$tpl->isPart($this->TPLd)) {
	         	$this->TPLd="TitledD";
	         }
	      } else {
	         $data=array(
	      		"title"=>$this->title,
	      		"id"=>$module,
	      		"cookie"=>$module."_Cookie",
	      		"minimizer"=>$minimizecode,
	      		"collapsed" =>((isset($_COOKIE[$module."_Cookie"]) && ($_COOKIE[$module."_Cookie"]=="true")) || ($this->Collapsed==true)),
	      		"content" =>$content
	      		);

	         $this->TPLd="Untitled".$this->TPLt;
	         if (!$tpl->isPart($this->TPLd)) {
	         	$this->TPLd="UntitledD";
	         }
	      }

	      //Call template
	      $modcont=$tpl->get($this->TPLd)->evaluate($data);
	 } else {
		$modcont=$content;
	 }

        //old
        /*
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
		*/
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