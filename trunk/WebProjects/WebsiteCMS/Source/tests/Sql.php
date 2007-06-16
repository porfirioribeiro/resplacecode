<?php
/**
 * Abstract class that all other class's extend
 */
abstract class SqlModel{
	abstract function insert($dunnowhatargshere);
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
	function insert($dunnowhatargshere){
		//your mysql work
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
	function insert($dunnowhatargshere){
		$this->model->insert($dunnowhatargshere);
	}
	//update
	//insert
	//etc...
	function close(){
		$this->model->close();
	}
}

$db=new Sql("test","localhost","root","porfirio");

$db->close();
?>