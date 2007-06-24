<?php
/**
* SQL Model for MySQL - Postresql...
* A model for translation betweeen various database management systems (DBMS)
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 24-06-07
*/
class MySqlModel {
	var $conDb;
	function MySqlModel($db,$host,$user,$pass){
		$this->conDb=mysql_connect($host,$user,$pass) or die("Maybe we should provoke the error handler to handle this ;)!");
		mysql_select_db($db,$this->conDb) or die("Cant open the db sorry...");//or die stuff
	}
	function query($sql){
		return mysql_query($sql,$this->conDb);
	}
	function close(){
		mysql_close($this->conDb);
	}
}
/**
 * This is our main class, is the class we use (why we have two classes? we dont need :P)
 */
class Sql{
	static $ModelClass=MySqlModel;
	var $model;
	function Sql($db,$host,$user,$pass){
		$this->model=new Sql::$ModelClass($db,$host,$user,$pass);
	}
	function insert($table,$data){
		$sql="INSERT INTO $table (";
		$keys=array_keys($data);
		foreach ($keys as $n=>$k) {
			$sql.="$k";
			if ($n<(count($keys)-1)){
				$sql.=",";
			}
		}
		$sql.=") VALUES (";
		$values=array_values($data);
		foreach ($values as $n=>$v) {
			$sql.="'$v'";
			if ($n<(count($values)-1)){
				$sql.=",";
			}
		}
		$sql.=");";
		echo $sql;
		$this->model->query($sql);
	}
	//update
	//insert
	//etc...
	function close(){
		$this->model->close();
	}
}

$db=new Sql("test","localhost","root","porfirio");
$db->insert("users",array("name"=>"Porfirio","age"=>26));
$db->close();
?>