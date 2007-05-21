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
	private function collapseCreate($module){
		$classe="SmallIcon ";
		if ($_COOKIE[$module."_CL"]=="none"){
			$classe.="Un";
		}	
		return 'class="'.$classe.'CollapseIcon" onmouseover="collapseOverOut(&#39;'.$module.'&#39;,this,true)" onmouseout="collapseOverOut(&#39;'.$module.'&#39;,this,false)" onclick="collapseToogle(&#39;'.$module.'&#39;,this)"';
	}
	private function nsDisplay(){
		return $this->NoScript?"none":"block";
	}
	function addContent($fn){
		$this->content2=$fn;
	}
	function start(){
		$module="MODULE_".preg_replace("/\W*/","",$this->title);
		$moduleContainerID=$module."_CT";
		$moduleCALeft=$module."_CAL";
		$moduleCARight=$module."_CAR";
		$minTitle=preg_replace("/[^a-z0-9_+& ]*/i","",$this->title);
		$p=$this->page;
	            if ($this->side==Module::LEFT){
					$modcont=$p->module_left->evaluate(array("module_nsdisplay"=>$this->nsDisplay(),"module_id_right"=>$moduleCARight,"module_collapse"=>$this->collapseCreate($module)));        
	              
	            }elseif ($this->side==Module::CENTER){  
	               $modcont=$p->module_center->evaluate(array("module_nsdisplay"=>$this->nsDisplay(),"module_id_right"=>$moduleCARight,"module_id_left"=>$moduleCALeft,"module_collapse"=>$this->collapseCreate($module)));  
				      	
	            }elseif ($this->side==Module::TOP){  
	               $modcont=$p->module_top->evaluate(array("module_nsdisplay"=>$this->nsDisplay(),"module_id_right"=>$moduleCARight,"module_id_left"=>$moduleCALeft,"module_collapse"=>$this->collapseCreate($module)));  
				      	
	            }elseif ($this->side==Module::BOTTOM){  
	               $modcont=$p->module_bottom->evaluate(array("module_nsdisplay"=>$this->nsDisplay(),"module_id_right"=>$moduleCARight,"module_id_left"=>$moduleCALeft,"module_collapse"=>$this->collapseCreate($module)));  
				      	
	            }elseif ($this->side==Module::RIGHT){        
	               $modcont=$p->module_right->evaluate(array("module_nsdisplay"=>$this->nsDisplay(),"module_id_left"=>$moduleCALeft,"module_collapse"=>$this->collapseCreate($module))); 
				   
	            }	
				$mic= ($this->NoScript)?"block":$_COOKIE[$module."_CL"];
				
				ob_start();
				$this->content();
				$woot=ob_get_contents();
				ob_end_clean();
				
				echo $p->module_main->evaluate(array("module_id"=>$module,"module_type"=>$modcont,"module_title"=>$this->title,"module_container_id"=>$moduleContainerID,"module_control"=>$mic,"module_content"=>$woot));

	}
	function content(){
		echo'<div>';
		$fn=$this->content2;
		$fn($this);
		echo'</div>';
	}	
	function finish(){
		//code to be executed on the end
	}
	function end(){
	?>
		</div> 
	<?php
		$this->finish();
	}
	function write(){
		$this->start();
		
		$this->end();	
	}
}
?>
