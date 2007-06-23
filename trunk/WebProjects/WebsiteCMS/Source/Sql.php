<?php
/**
 * MySql Model
 */
class MySqlModel {
	var $conDb;
	function MySqlModel($db,$host,$user,$pass){
		$this->conDb=mysql_connect($host,$user,$pass) or die("Fuck, mysql is down again!");
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
 * This is our main class, is the class we use
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