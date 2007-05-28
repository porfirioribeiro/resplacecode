<?php

//include dirname(__FILE__)."/../data/functions/ResDB.php";

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
	/**
	 * Check if a table exists and returns it, or else create it
	 * @param String $tname
	 * @param Array $columns
	 * @return ResDB_Table
	 */
	function addTable($tname,$columns){
		$this->checkTabled();
		if (!$this->tableExists($tname)){
			return $this["tables"][$tname]=new ResDB_Table($columns);
		}
		return $this->getTable($tname);
	}
	/**
	 * Get a table if it exists
	 * @param String $tname
	 * @return ResDB_Table
	 */
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
	/**
	 * Get all rows 
	 * @return ResDB_Row
	 */	
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
	/**
	 * Limit the rows
	 * @param Number $start
	 * @return ResDB_Row
	 */
	function limitFrom($start){
		$arr=(Array)$this;
		$arr=array_splice($arr,$start,count($arr));
		unset($this);
		return new ResDB_Row($arr);
	}
	/**
	 * Limit the rows
	 * @param Number $end
	 * @return ResDB_Row
	 */
	function limitTo($end){
		$arr=(Array)$this;
		$arr=array_splice($arr,0,$end);
		unset($this);
		return new ResDB_Row($arr);		
	}
	/**
	 * Limit the rows
	 * @param Number $start
	 * @param Number $end
	 * @return ResDB_Row
	 */
	function limit($start,$end){
		$arr=(Array)$this;
		$arr=array_splice($arr,$start,$end);
		unset($this);
		return new ResDB_Row($arr);				
	}
	/**
	 * Reverse
	 * @return ResDB_Row
	 */
	function reverse(){
		$arr=(Array)$this;
		$arr=array_reverse($arr);
		unset($this);
		return new ResDB_Row($arr);	
	}
}



?>
