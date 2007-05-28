<?php

include dirname(__FILE__)."/../data/functions/ResDB.php";

class ResDB2 extends ResDB {
	function ResDB2($name="",$tabled=false){
		parent::ResDB($name);
		if ($tabled==true){
			$this["isTabled"]=$tabled;
			$this->addMap("tables");
		}	
	}
	function isTabled(){
		return ($this->contains("isTabled") && $this["isTabled"]);
	}
	private function checkTabled(){
		if (!$this->isTabled()){
			die("<b>ERROR: </b>Trying to Table acess to a non Table db");
		}
	}
	function tableExists($tname){
		return isset($this["tables"][$tname]);
	}
	function addTable($tname,$columns){
		$this->checkTabled();
		if (!$this->tableExists($tname)){
			return $this["tables"][$tname]=new ResDB_Table($columns);
		}
		return $this->getTable($tname);
	}
	function getTable($tname){
		$this->checkTabled();
		if ($this->tableExists($tname)){
			return $this["tables"][$tname];
		}		
	}
}
class ResDB_Table extends ArrayMap {
	var $validOperators=array("<>",">=","<=",">","<","=","~=");
	function ResDB_Table($columns=null){
		if ($columns!=null){
			$this["collumns"]=new ArrayMap();
			$this["AI"]="";
			$this["AIV"]=0;
			foreach ($columns as $k => $column) {
				if ($k==="AI" || $k==="AutoIncrement"){
					$this["AI"]=$column;
				}
				$this["collumns"][]=$column;
			}
			$this["rows"]=new ArrayMap();			
		}
	}
	function insert($r){
		$row=new ArrayMap();
		if ($this["AI"]!=""){
			$this["AIV"]++;
			$row[$this["AI"]]=$this["AIV"];
		}
		foreach ($this["collumns"] as $k) {
			if ($k!=$this["AI"]){
				$row[$k]=$r[$k];
			}
		}
		$this["rows"][]=$row;
	}
	/**
	 * Get all rows that match the query, can be used recursive
	 * @param String $q
	 * @return ResDB_Row
	 */
	function getBy($q){
		$result=new ResDB_Row();
		$result->__construct($this["rows"]);
		return $result->getBy($q);
	}
	function getAll(){
		$result=new ResDB_Row();
		$result->__construct($this["rows"]);
		return $result;		
	}
}
class ResDB_Row extends ArrayMap {
	var $validOperators=array("<>",">=","<=",">","<","=","~");
	function isEmpty(){
		return ($this->count()==0);
	}
	/**
	 * Get all rows that match the query, can be used recursive
	 * @param String $q
	 * @return ResDB_Row
	 */
	function getBy($q){
		$operator=null;
		$result=new ResDB_Row();
		foreach ($this->validOperators as $op){
			if (strpos($q,$op)!==false){
				$kk=preg_split("/".preg_quote($op)."/",$q);
				$k0=$kk[0];	
				$k1=$kk[1];		
				switch ($op) {
					case "~":
						$k1=preg_replace("/%/",".*",$k1);		
						foreach ($this as $row) {
							if (preg_match("/^$k1$/",$row[$k0])){
								$result[]=$row;
							}
						}
					break;
					case "<>":
						foreach ($this as $row) {
							if ($k1<>$row[$k0]){
								$result[]=$row;
							}
						}						
					break;
					case ">=":
						foreach ($this as $row) {
							if ($row[$k0]>=$k1){
								$result[]=$row;
							}
						}						
					break;
					case "<=":
						foreach ($this as $row) {
							if ($row[$k0]<=$k1){
								$result[]=$row;
							}
						}							
					break;	
					case ">":
						foreach ($this as $row) {
							if ($row[$k0]>$k1){
								$result[]=$row;
							}
						}							
					break;	
					case "<":
						foreach ($this as $row) {
							if ($row[$k0]<$k1){
								$result[]=$row;
							}
						}							
					break;	
					case "=":
						foreach ($this as $row) {
							if ($k1==$row[$k0]){
								$result[]=$row;
							}
						}							
					break;							
				}
				break;
			}
		}
		unset($this);
		return $result;
	}
	/**
	 * Get all rows that match the query, can be used recursive
	 * @param String $q
	 * @return ResDB_Row
	 */
	function _($q){
		return $this->getBy($q);
	}
}



?>
