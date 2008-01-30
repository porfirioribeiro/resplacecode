<?php
require_once("SQLResult.php");
class SQL{
	var $sqlink;
	static $sql;
	var $prefix;
	function SQL(){
		global $WebMS;
		$this->prefix=$WebMS["db"]["prefix"];
		$this->sqlink=mysql_connect($WebMS["db"]["server"],$WebMS["db"]["username"],$WebMS["db"]["password"]) or $this->throwError("Impossivel ligar á base de dados");
		mysql_select_db($WebMS["db"]["database"],$this->sqlink) or $this->throwError("Could not open database");
	}
	function throwError($message){
		die($message);
	}
	/**
	 * Gets the current SQL singleton
	 * @return SQL
	 */
	static function getSQL(){
		if (!SQL::$sql instanceof SQL){
			SQL::$sql = new SQL();
		}
		return SQL::$sql;
	}
	static function getSQLink(){
		return SQL::getSQL()->sqlink;
	}
	function __destruct(){
		mysql_close(SQL::getSQLink());
	}
	
	static function close(){
		 unset(SQL::$sql);	 
	}
	static function escape($q){
		return mysql_real_escape_string($q, SQL::getSQLink());
	}
	/**
	 * Query the database
	 * @param String $q
	 * @return SQLResult
	 */
	static function query($q){
		return new SQLResult(mysql_query($q, SQL::getSQLink()));
	}
	
	static function insert($table,$values){
		$in="";
		$val="";
		foreach ($values as $key => $value) {
			$in.="`$key`,";
			$val.="'$value',";
		}
		$in=preg_replace("/,$/","",$in);
		$val=preg_replace("/,$/","",$val);
		return SQL::query("INSERT INTO `".SQL::getSQL()->prefix.$table."` ($in) VALUES ($val);")->isOK();
	}
	
	static function convertWhere($where){
		/*$result = preg_split('/\\s+(AND|OR)+\\s+/', $where);
		foreach ($result as $res) {
			echo $res."<br>";
		}*/
		
		//print_r($result);
		/*if (preg_match('/^(.*)\\s*(>=|<=|=|>|<)\\s*([0-9]*[.|,]?[0-9]+)$/', $where, $regs)) {
			print_r($regs);
		} else if (preg_match('/^(.*)\\s*(=|~|LIKE)\\s*(.+)$/', $where, $regs)) {
			print_r($regs);
		} else {
			
		}*/
		//TODO implement converter for where
		return $where;//do nothing yet
	}
	static function remove($table, $where, $limit=null){
		$where = SQL::convertWhere($where);
		$limit=($limit!=null)?"LIMIT $limit":"";
		return SQL::query("DELETE FROM `".SQL::getSQL()->prefix.$table."` WHERE $where $limit")->isOK();
	}
	
	/**
	 * Gets results from database
	 * @param String $table
	 * @param String $where
	 * @param String $limit
	 * @return SQLResult
	 */
	static function select($table, $where=null, $limit=null){
		$where = ($where!=null)?" WHERE ".SQL::convertWhere($where):"";
		$limit = ($limit!=null)?" LIMIT $limit":"";
		
		/*$res=new ArrayObject();
		if ($result){
			while ($row = mysql_fetch_assoc($result)) {
				$res[]=$row;
			}
			mysql_free_result($result);			
		}*/
		return SQL::query("SELECT * FROM `".SQL::getSQL()->prefix.$table."`$where$limit");
	}
	static function update($table, $where=null, $values){
		$where = ($where!=null)?" WHERE ".SQL::convertWhere($where):"";
		$in="";
		foreach ($values as $key => $value) {
			$in.="`$key` = '$value',";
		}
		$in=preg_replace("/,$/","",$in);
		return SQL::query("UPDATE `".SQL::getSQL()->prefix.$table."` SET $in $where")->isOK();
	}	
}
?>