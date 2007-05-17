<?php
/**
 * ArrayNap class<br>
 * This class bring ammazing features to work wth Maps
 * Licenced under GPLv2 read GPL.txt for details
 * @version 1
 * @copyright © 2007 ResPlace Team
 * @lastedit 12-05-07
 */
class ArrayMap {
	static function is($w){
		return is_a($w,ArrayMap);
	}
	var $arr=null;
	/**
	 * Creates a new ArrayMap
	 * @param Array $arr
	 * @return ArrayMap
	 */
	function ArrayMap($arr=array()){
		$this->arr=$arr;
	}
	/**
	 * Create a new Map and return it
	 * @param string $key
	 * @return ArrayMap
	 */
	function addMap($key){
		$this->arr[$key]=new ArrayMap();
		return $this->arr[$key];
	}
	function del($key){
		unset($this->arr[$key]);
	}
	function put($key,$value){
		return $this->arr[$key]=$value;
	}
	function ren($key,$nkey){
		$v=$this->get($key);
		$this->del($key);
		$this->put($nkey,$v);
	}
	function getKeyFromPath($path){
		$p=preg_split("/\./",$path);
		$cmap=$this;	
		if (count($p)==1){
			return array("map"=>$this,"key"=>$path);
		}
		foreach ($p as $k=>$item) {
			if ($k==count($p)-1){
				if (!$cmap->isMap($item)){
					return array("map"=>$cmap,"key"=>$item);
				}else{
					return null;
				}				
			}else{
				if ($cmap->isMap($item)){
					$cmap=$cmap->getMap($item);
				}else{
					return null;
				}
			}
		}	
	}
	function putPath($path,$value){
		$p=preg_split("/\./",$path);
		$cmap=$this;		
		foreach ($p as $k=>$item) {
			if ($k==count($p)-1){
				if (!$cmap->isMap($item)){
					$cmap->put($item,$value);
				}else{
					return;
				}				
			}else{
				$cmap=$cmap->getMap($item);
			}
		}		
	}
	function getPath($path){
		$k=$this->getKeyFromPath($path);
		if ($k){
			return $k["map"]->get($k["key"]);	
		}
		return null;
	}
	private function searchPath($map,&$path,$tree){
		foreach ($map->arr as $key => $value) {
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
	function delPath($path){
		$k=$this->getKeyFromPath($path);
		if ($k){
			$k["map"]->del($k["key"]);
			return true;
		}
		return false;
	}
	function renPath($path,$nkey){
		$k=$this->getKeyFromPath($path);
		if ($k){
			$map=$k["map"];
			$key=$k["key"];
			$v=$map->get($key);
			$map->del($key);
			$map->put($nkey,$v);
			return;
		}
	}
	/**
	 * Get an item
	 * @param string $key
	 * @return any
	 */
	function get($key,$default=null){
		$k=$this->arr[$key];
		if ($k!=null){
		  if (is_a($k,ArrayMap)){
        return $k;
      }else{
        return stripslashes($k);
      }	
		}
		return $default;		
	}
	/**
	 * Get or create a Map
	 * @param string $key
	 * @return ArrayMap
	 */
	function getMap($key){
		$k=$this->arr[$key];
		if ($k!=null && is_a($k,ArrayMap)){
			return $k;		
		}else{
			return $this->addMap($key);
		}
	}
	function isMap($key){
		$k=$this->arr[$key];
		return ($k!=null && is_a($k,ArrayMap));
	}
	/**
	 * Return the array with all itens
	 * @return Array
	 */
	function getArray(){
		return $this->arr;
	}
	function clean(){
		$this->arr=null;
		$this->arr=array();
	}
}
class ADB extends ArrayMap {
	var $file;
	function ADB($file=null){		
		if ($file!=null){
			$this->load($file);
		}
	}
	function load($file){
		$this->file=$file;
		if (is_readable($file)){
			$arr=unserialize(file_get_contents($file));
			if (is_array($arr)){
				$this->arr=$arr;
			}
		}		
		echo $f;
	}
	function save($file){
		$this->file=$file;
		file_put_contents($file,serialize($this->arr));
	}
	function close(){
		$this->save($this->file);
	}
}
?>
