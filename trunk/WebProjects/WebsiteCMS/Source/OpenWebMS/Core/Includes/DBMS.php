<?php
/**
* SQL Model for MySQL - Postresql...
* A model for translation betweeen various database management systems (DBMS)
* Thanks to David for most of this code: veloFrame.bountysource.com
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 20-07-07
*/

class SQL{
	var $model;
	var $db		=null;
	var $query	="";

	function sql() {
		$this->connect();
	}

	function connect() {
		global $WebMS, $db;

		if ( isset($WebMS["MySQL_Host"]) && isset($WebMS["MySQL_UserName"]) && isset($WebMS["MySQL_Password"]) &&  isset($WebMS["MySQL_Database"]) ) {
			$this->db=mysql_connect($WebMS["MySQL_Host"],$WebMS["MySQL_UserName"],$WebMS["MySQL_Password"]);
			mysql_select_db($WebMS["MySQL_Database"],$this->db);
		} else {
			//error
		}
	}

	function disconnect() {
		global $WebMS;

		mysql_close($this->db);
	}

	function query($querys,$fetch) {
		$query = mysql_query($querys,$this->db) or die('Query failed: ' . mysql_error());;

		if(empty($GLOBALS['queries'])) $GLOBALS['queries'] = 0;
		$GLOBALS['queries']++;

		//Fetch the query if needed
		if($fetch) while($row = mysql_fetch_assoc($query)) {
			if(empty($key)) $data[] = $row;

			else $data[$row[$key]] = $row;
		}

		else $data = $query;

		//Return the result
		return $data;
	}
}

?>
