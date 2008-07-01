<?php
class Widget extends PWTag {
	function start($args){
		echo "<$this->name$args>";
	}
	function body($data){
		echo $data;
	}
	function end(){
		echo "</$this->name>";
	}
}
?>