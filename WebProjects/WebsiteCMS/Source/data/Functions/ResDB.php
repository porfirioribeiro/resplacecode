<?php
class ArrayMap extends ArrayObject{
	static function is($w){
		return is_a($w,ArrayMap);
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
	function ResDB($file=""){
		$this->load($file);
	}
	function load($file=""){
		$this->file=$file;
		if (is_file($this->file)) {
			include $this->file;
			if (!$this->data==null){
				ob_start();
				/*$serialized=gzuncompress($this->data);
				$err=ob_get_clean();
				if ($err!=""){
					return;
				}			*/
				$arr=unserialize($this->data);
				if (!is_a($arr,ResDB)){
					return;
				}
				parent::__construct($arr);
			}
			$this->data=null;
		}					
	}
	function save($file=""){
		$this->file=$file;
		file_put_contents($this->file,'<?php '.chr(10).'/*Do Not Hand Edit This file!!!! The DB may became corrupted!!!*/'.chr(10).' if (!isset($this)){die("You cant just came and see the data sorry");}$this->data=\''.serialize($this)."';?>");
	}
	function close(){
		$this->save($this->file);
	}
}
?>