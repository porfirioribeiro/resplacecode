<?php
class LManager extends Module {
	var $db;
    function LManager($page){
    	parent::Module($page);
    	$this->title="Manage layout";
    	$this->db=new ResDB("Layouts","core");
    }
    function content(){
        foreach ($this->db as $map => $key) {
    		echo $map;
    	}    	
    }
}

$page->add("LManager");
?>