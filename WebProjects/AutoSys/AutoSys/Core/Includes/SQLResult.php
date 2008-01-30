<?php
class SQLResult{
	var $result;
	function SQLResult($result){
		$this->result=$result;
	}
	/**
	 * Check if the result of the query is ok
	 * @return unknown
	 */
	function isOK(){
		return !!$this->result;
	}
	/**
	 * Count rows on SQL result
	 * @return number
	 */
	function count(){
		if (!$this->result){
			return -1;
		}
		return mysql_num_rows($this->result);
	}
	/**
	 * Count fields on SQL result
	 * @return number
	 */
	function countFields(){
		if (!$this->result){
			return -1;
		}
		return mysql_num_fields($this->result);
	}
	/**
	 * Fetch SQL results and return numeric array
	 * @param boolean $arrayobject
	 * @return ArrayObject
	 */
	function fetchArray($arrayobject=true){
		if (!$this->result){
			return false;
		}
		$arr = mysql_fetch_array($this->result);
		return ($arrayobject)?new ArrayObject($arr):$arr;
	}
	/**
	 * Fetch SQL results and returne assoiative array
	 * @param Boolean $arrayobject
	 * @return ArrayObject
	 */
	function fetchAssoc($arrayobject=true){
		if (!$this->result){
			return false;
		}
		$arr = mysql_fetch_assoc($this->result);
		return ($arrayobject)?ArrayObject::__construct((array)$arr):$arr;		
	}	
	/**
	 * Fetch SQL results returning objects
	 * @return object
	 */
	function fetchObject(){
		if (!$this->result){
			return false;
		}
		return mysql_fetch_object($this->result);
	}		
	/**
	 * @see SQLResult::fetchAssoc
	 * @return ArrayObject
	 */
	function fetch(){
		return $this->fetchAssoc();
	}
	/**
	 * Returns an array with all results
	 * @param Boolean $arrayobject
	 * @return ArrayObject
	 */
	function toArray($arrayobject=true){
		$arr=array();
		while ($row=$this->fetchAssoc(false)){
			$arr[]=($arrayobject)?new ArrayObject($row):$row;
		}	
		return ($arrayobject)?new ArrayObject($arr):$arr;		
	}
	
	function toJSON($sanitize=false){
		$json="[";
		while ($row=$this->fetchAssoc(false)){
			$json.="{";
			foreach ($row as $key => $value) {
				$json.='"'.$key.'" : "'.$value.'",'."";
			}
			$json=preg_replace("/,$/","",$json);
			$json.="},";
		}		
		$json=preg_replace("/,$/","",$json);	
		return $json."]";
	}
	
	function __destruct(){
		if (!$this->result || !is_resource($this->result)){
			return; 
		}
		mysql_free_result($this->result);
	}
}

?>