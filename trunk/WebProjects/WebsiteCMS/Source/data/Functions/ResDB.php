<?php
class ArrayMap extends ArrayObject{
	static function is($w){
		return ($w instanceof ArrayMap);
	}
	var $it;
	var $fn;
	/**
	 * Check if theres more to iterate and return teh iterator or false
	 * @return ArrayIterator
	 */
	function iterate(){
		if ($this->it==null){
			$this->it=$this->getIterator();
		}
		if ($this->it->valid()){
			return $this->it;
		}else{
			$this->it=null;
			return false;
		}
	}
	function each($arg0,$arg1=null){
		foreach ($this as $key => $value) {
			if (is_object($arg0)){
				$arg0->$arg1($this,$key,$value);
			}elseif (function_exists($arg0)){
				$arg0($this,$key,$value);
			}		
		}		
	}
	function toJSON(){
		$js=print_r($this,true);
		$js=str_replace("(","{",$js);
		$js=str_replace(")","}",$js);
		$js=str_replace("[",'"',$js);
		$js=str_replace("]",'"',$js);
		echo $js."<br>";
		$js=preg_replace("/(ArrayMap\sObject\s)*/",'',$js);
		$js=preg_replace("/=>(.*)/",':"${1}"',$js);
		$js=preg_replace("/(\s*)/",'',$js);
		$js=preg_replace("/\"\{\"/",'{',$js);
		$js=preg_replace("/(\"\")/",'","',$js);
		$js=preg_replace("/(\"}\")/",'"},"',$js);
		$js=preg_replace("/\}\"/",'},"',$js);
		//$js=str_replace("_#","(",$js);
		//$js=str_replace("#_",")",$js);
		return $js;
	}
	//Array functions
	/**
	 * Clean the ArrayMap
	 */
	function clean(){
		parent::__construct(array());
	}
	/**
	 * Check if teh specified key exists on this Map
	 * @param String $key
	 * @return Bool
	 */
	function contains($key){
		return isset($this[$key]);
	}
	/**
	 * Set or put the value of the specified value on the specified key.
	 * @param String $key
	 * @param mixed $value
	 */
	function put($key,$value){
		$this[$key]=$value;
	}
	/**
	 * Returns the value of teh specified key or the default value is jey not exist
	 * @param String $key
	 * @param mixed $default
	 * @return mixed
	 */
	function get($key,$default=null){
		return ($this->contains($key))?$this[$key]:$default;
	}
	/**
	 * Remove the specified key from the Map
	 * @param String $key
	 */
	function del($key){
		unset($this[$key]);
	}
	/**
	 * Move the value of the key to nkey and delete the key
	 * @param String $key
	 * @param String $nkey
	 */
	function ren($key,$nkey){
		if (isset($this[$key])){
			$v=$this[$key];
			$this[$nkey]=$v;
			unset($this[$key]);
		}
	}
	//Map functions
	/**
	 * Check if the specified key contains a map
	 * @param String $map
	 * @return Bool
	 */
	function isMap($map){
		return (isset($this[$map]) &&  ArrayMap::is($this[$map]));
	}
	/**
	 * Creates a new ArrayMap and add it to the current map
	 * @param String $map
	 * @param Bool $overwrite
	 * @return ArrayMap
	 */
	function addMap($map,$overwrite=false){
		return $this[$map]=($overwrite || !$this->isMap($map))?new ArrayMap():$this[$map];
	}
	function getMap($map){
		return ($this->isMap($map))?$this[$map]:$this->addMap($map);
	}
	//Path functions
	/**
	 * Check if this Map contains this map
	 * @param String $path
	 * @return Bool
	 */
	function containsPath($path){
		return ($this->getPath($path,null)!=null);
	}
	/**
	 * Get key value from a path
	 * a path is splited with dots map.map.key the string after the last dot is the key, others are maps
	 * @param String $path
	 * @param mixed $default
	 * @return miced
	 */
	function getPath($path,$default=null){
		$p=preg_split("/\./",$path);$k=array_pop($p);$map=$this;
		foreach ($p as $item) {
			if (!$map->isMap($item)){return $default;}
			$map=$map[$item];
		}
		return $map->get($k,$default);
	}
	/**
	 * Put or set the value of a key using a path
	 * @param String $path
	 * @param mixed $value
	 */
	function putPath($path,$value){
		$p=preg_split("/\./",$path);$k=array_pop($p);$map=$this;
		foreach ($p as $item) {
			$map=$map->addMap($item);
		}
		$map->put($k,$value);
	}
	/**
	 * Delete a key using a path
	 * @param String $path
	 */
	function delPath($path){
		$p=preg_split("/\./",$path);$k=array_pop($p);$map=$this;
		foreach ($p as $item) {
			if (!$map->isMap($item)){return;}
			$map=$map[$item];
		}
		$map->del($k);
	}	
	/**
	 * Rename the key on teh specified path to teh new key
	 * @param String $path
	 * @param String $nkey
	 */
	function renPath($path,$nkey){
		$p=preg_split("/\./",$path);$k=array_pop($p);$map=$this;
		foreach ($p as $item) {
			if (!$map->isMap($item)){return $default;}
			$map=$map[$item];
		}
		$v=$map->get($k);
		$map->put($nkey,$v);
		$map->del($k);
	}
	private function searchPath($map,&$path,$tree){
		foreach ($map as $key => $value) {
			if (ArrayMap::is($value)){
				$tree.=$key;		
				$this->searchPath($map->get($key),$path,$tree);
			}else {
				$path[]=$tree.(($tree=="")?"":".").$key;
			}
		}
	}
	function listPaths(){
		$paths=array();
		$this->searchPath($this,$paths,"");
		return $paths;
	}
}

class ResDB extends ArrayMap {
	var $path;
	var $file;
	var $cat;
	var $data;
	var $error;
	static $resdbopen=0;
	static $resdbclose=0;
	static function is($w){
		return $w instanceof ResDB;
	}
	function ResDB($file="",$cat="",$tabled=false){
		$this->path=dirname(__FILE__)."/../db/";
		$this->load($file,$cat);
		ResDB::$resdbopen++;
		if ($tabled==true){
			$this["isTabled"]=$tabled;
			$this->addMap("tables");
		}	
	}
	function delete(){
		$f=$this->path;
		if ($this->cat!=""){
			$f.=$this->cat."/";
		}
		$f.=$this->file;
		if (is_file($f)) {
			unlink($f);		
		}
	}
	function load($file="",$cat=""){
		$this->cat=$cat;
		$this->file=$file.".db";
		$f=$this->path;
		if ($this->cat!=""){
			$f.=$this->cat."/";
		}
		$f.=$this->file;
		if (is_file($f)) {
			//ob_start();
			$serialized=gzuncompress(file_get_contents($f));
			if ($serialized!==false){
				$arr=unserialize($serialized);
				if (!ResDB::is($arr)){
					echo ("Error unserializing");
				}
				parent::__construct($arr);				
			}
			//ob_clean();
		}					
	}
	function save($file="",$cat=""){
		$this->cat=$cat;
		if (strpos($file,".db")!=(strlen($file)-strlen(".db"))){
			$file.=".db";
		}
		$this->file=$file;		
		$f=$this->path;
		if ($this->cat!=""){
			$f.=$this->cat."/";
		}
		$f.=$this->file;	
		$serialized=serialize($this);
		$out=gzcompress($serialized);		
		file_put_contents($f,$out);
		ResDB::$resdbclose++;
	}
	function close(){
		$this->save($this->file,$this->cat);
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