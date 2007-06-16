<?php
/**
 * Abstract class that all other class's extend
 */
abstract class SqlModel{
	abstract function insert($table,$data);
	//update
	//insert
	//etc...
	abstract function close();
}
/**
 * MySql Model
 */
class MySqlModel extends SqlModel {
	var $conDb;
	function MySqlModel($db,$host,$user,$pass){
		$this->conDb=mysql_connect($host,$user,$pass) or die("Fuck, mysql is down again!");
		mysql_select_db($db,$this->conDb) or die("Cant open the db sorry...");//or die stuff
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
		mysql_query($sql,$this->conDb);
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
	//here we have functions like this
	//that just wrap arround the SqlModel
	function insert($table,$data){
		$this->model->insert($table,$data);
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