<?php
class ArrayMap extends ArrayObject{
	static function is($w){
		return is_a($w,ArrayMap);
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
		return is_a($this[$map],ArrayMap);
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
}

class ResDB extends ArrayMap {
	var $file;
	var $data;
	var $error;
	function ResDB($file=""){
		$this->load($file);
	}
	function load($file=""){
		$this->file=$file;
		if (is_file($this->file)) {
			//ob_start();
			$serialized=gzuncompress(file_get_contents($this->file));
			if ($serialized!==false){
				$arr=unserialize($serialized);
				if (!is_a($arr,ResDB)){
					echo ("Error unserializing");
				}
				parent::__construct($arr);				
			}
			//ob_clean();
		}					
	}
	function save($file=""){
		$this->file=$file;
		$serialized=serialize($this);
		$out=gzcompress($serialized);		
		file_put_contents($this->file,$out);
	}
	function close(){
		$this->save($this->file);
	}
}
?>