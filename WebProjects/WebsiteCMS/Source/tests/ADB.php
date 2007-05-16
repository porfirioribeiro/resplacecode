<?php
include_once "Encryption.php";
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
	var $passw;
	var $prefs=array();
	var $crpt;
	var $errors;
	function ADB($file=null,$passw=""){		
		$this->crpt=new Encryption();
		if ($file!=null){
			$this->load($file,$passw);
		}
	}
	function load($file,$passw=""){
		$this->errors=array();
		$this->file=$file;
		$this->passw=$passw;		
		if (is_readable($file)){		
			$ct=file_get_contents($file);
			$start=strpos($ct,"#|");
			$start=($start!==false)?$start+2:$start;
			$end=strpos($ct,"|#",$start);
			if ($start==2 && $end!==false){
				$p=substr($ct,$start,$end-2);			
				$this->prefs["gzip"]=(strpos($p,"gzip")===false)?false:true;
				$this->prefs["encrypt"]=(strpos($p,"encrypt")===false)?false:true;				
			}else{
				$this->prefs["gzip"]=false;
				$this->prefs["encrypt"]=false;
			}
			$ct=preg_replace("/#\|(gzip|encrypt|encrypt,gzip|)\|#\n/","",$ct);
			if ($this->prefs["gzip"]){
				$oct=$ct;
				$ct=gzuncompress($oct);
				if ($ct==$oct){
					$this->errors[]="Gzip uncompression failed!";
					return false;
				}
			}						
			if ($this->prefs["encrypt"]){
				$ct=$this->crpt->decrypt($this->passw,$ct);
				if (count($this->crpt->errors)){
					$this->errors=$this->crpt->errors;
					return false;
				}
			}
			$ct=str_replace("#quot#",'"',$ct);	
			$ct=unserialize($ct);	
			if ($ct===false){
				$this->errors[]="Unserialization failed!";
				return false;				
			}
			if (!is_array($ct)){
				$this->errors[]="Unespected Error!";
				return false;					
			}
			$this->arr=$ct;
			return true;
		}		
	}
	function save($file,$passw="",$gzip=false){
		$this->errors=array();		
		$this->file=$file;
		$this->passw=$passw;
		$ps="#|";
		$ct=serialize($this->arr);
		$ct=str_replace('"',"#quot#",$ct);		
		if ($this->prefs["encrypt"] || $passw!=""){
			$ps.="encrypt";
			$ct=$this->crpt->encrypt($passw,$ct);
			if (count($this->crpt->errors)){
				$this->errors=$this->crpt->errors;
				return false;				
			}
		}		
		if ($this->prefs["gzip"] || $gzip){
			$ps.=($ps=="#|")?"":",";
			$ps.="gzip|#";
			$oct=$ct;
			$ct=gzcompress($oct);
			if ($oct==$ct){
				$this->errors[]="Failed to compress Data!";
				return false;
			}
		}
		$ct=$ps."\n".$ct;
		file_put_contents($file,$ct);
		return true;
	}
	function close($passw="",$gzip=false){
		return $this->save($this->file,$passw,$gzip);
	}
}
?>
