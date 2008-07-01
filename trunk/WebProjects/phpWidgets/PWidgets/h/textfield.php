<?php
class h_textfield extends Widget {
	var $wrap;
	function start($args){
		$this->wrap=$this->tag("span",array("style"=>"background-color:red"));
		$label=$args->get("label");
		$value=$args->get("value");		
		$side=$args->getValid("side","left|right|top|bottom","left");
		
		if ($side=="left"){
			$this->tagEnd("label",null,$label);
			$this->tagEnd("input",array("value"=>$value));
		}else if ($side=="right"){
			$this->tagEnd("input",array("value"=>$value));		
			$this->tagEnd("label",null,$label);
		}else if ($side=="top"){
			?>
			<label><?=$label ?></label><br/>
			<input value="<?=$value ?>"/>
			<?php
		}
	}
	
	function end(){
		$this->wrap->end();
	}
}
?>