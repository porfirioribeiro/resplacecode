<?php
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
	?>
		<div id="<?=$module?>" class="Module">                  
            <div class="TitleMid">                            
                <div class="TitleLeft">                            
                </div>           
                <?php                    
	            if ($this->side==Module::LEFT){        
	            ?>     
	                <!--div class="SmallIcon MinimizeLeftIcon" style="float:left;display:<?=$this->nsDisplay()?>" onmouseover="this.className='SmallIcon MinimizeLeftIconOver'" onmouseout="this.className='SmallIcon MinimizeLeftIcon'" onclick=""></div-->
	                <div class="TitleRight">                            
	                </div>       	
	                <div style="float:right;display:<?=$this->nsDisplay()?>" id="<?=$moduleCARight?>" <?=$this->collapseCreate($module)?>></div>     	                                
	            <?php  
	            }elseif ($this->side==Module::CENTER || $this->side==Module::TOP || $this->side==Module::BOTTOM){  
	            ?> 
	               <div style="float:left;display:<?=$this->nsDisplay()?>" id="<?=$moduleCALeft?>" <?=$this->collapseCreate($module)?>></div>  
	                <div class="TitleRight">                            
	                </div>   
	                <div style="float:right;display:<?=$this->nsDisplay()?>" id="<?=$moduleCARight?>" <?=$this->collapseCreate($module)?>></div>  	 
	            <?php            	
	            }elseif ($this->side==Module::RIGHT){        
	            ?>     
	                <div style="float:left;display:<?=$this->nsDisplay()?>" id="<?=$moduleCALeft?>" <?=$this->collapseCreate($module)?>></div>
	                <div class="TitleRight">                            
	                </div>   
					<!--div class="SmallIcon MinimizeRightIcon" onmouseover="this.className='SmallIcon MinimizeRightIconOver'" onmouseout="this.className='SmallIcon MinimizeRightIcon'" style="float:right;display:<?=$this->nsDisplay()?>" onclick=""></div-->                   	                
	            <?php   
	            }		
                ?>                                                                       
                <div class="TitleText">
                    <?=$this->title?>                            
                </div>                        
            </div> 			                      
            <div class="BoxContent" id="<?=$moduleContainerID?>" style="display:<?=($this->NoScript)?"block":$_COOKIE[$module."_CL"]?>">  
	<?php
	}
	function content(){
	?>
		<!-- Empty Module -->
	<?php
		/*if (isset($this->content2)){
			$this->content2();
		}*/
		
		$fn=$this->content2;
		$fn($this);
	}	
	function finish(){
		//code to be executed on the end
	}
	function end(){
	?>
            </div>	
		</div> 
	<?php
		$this->finish();
	}
	function write(){
		$this->start();
		$this->content();
		$this->end();	
	}
}
?>