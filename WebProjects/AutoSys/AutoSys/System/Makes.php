<?php
class Makes{
	static function have($name){
		return SQL::select("Makes","name = '$name'")->count()==1;
	}	
	static function add($name){
		if (Makes::have($name)){
			return false;			
		}		
		SQL::insert("Makes",array("name"=>$name,"models"=>'[]'));
		return true;
	}
	/**
	 * Get all Makes as an array
	 * @return ArrayObject
	 */
	static function getMakes(){
		return SQL::select("Makes")->toArray();
	}
	/**
	 * Get SQLResult
	 *
	 * @return SQLResult
	 */
	static function getAll(){
		return SQL::select("Makes");
	}	
	
	static function makesToJson(){
		global $json;
		$q=SQL::select("Makes");
		$j=array();
		while (($r=$q->fetchAssoc(false))){
			$j[]=$r["name"];
		}
		return $json->encode($j);
	}
	
	static function delete($name){
		SQL::remove("Makes","name = '$name'");
	}
	static function rename($name,$nname){
		SQL::update("Makes","name = '$name'",array("name"=>$nname));
	}
	//Models
	
	
	static function getModels($make){
		global $json;
		$q=SQL::select("Makes","name = '$make'");
		if ($q->count()>0){
			$res=$q->fetchAssoc(false);
			return $json->decode($res["models"]);
		}
		return array();
	}
	
	static function haveModel($make,$model){
		return in_array($model,Makes::getModels($make));
	}
	
	static function addModel($make, $model){
		global $json;
		$models=Makes::getModels($make);
		if (!in_array($model,$models)){
			$models[]=$model;
			sort($models);
			SQL::update("Makes","name = '$make'",array("models"=>$json->encode($models)));
		}
	}
	
	static function renameModel($make, $model, $nname){
		global $json;
		$models=Makes::getModels($make);
		if (($s=array_search($model,$models))!==false){
			unset($models[$s]);
		}
		if (($s=array_search($nname,$models))!==false){
			unset($models[$s]);
		}		
		$models[]=$nname;
		sort($models);
		SQL::update("Makes","name = '$make'",array("models"=>$json->encode($models)));
	}
	
	static function deleteModel($make, $model){
		global $json;
		$models=Makes::getModels($make);
		if (($s=array_search($model,$models))!==false){
			unset($models[$s]);
		}	
		sort($models);
		SQL::update("Makes","name = '$make'",array("models"=>$json->encode($models)));					
	}
	static function modelsToJson($make){
		global $json;
		$q=SQL::select("Makes","name = '$make'");
		if ($q->count()>0){
			$res=$q->fetchAssoc(false);
			return $res["models"];
		}
		return "[]";
	}
	
	static function toJson(){
		global $json;
		return $json->encode(Makes::toArray());
	}	
	
	static function toArray(){
		$q=SQL::select("Makes");
		$j=array();
		while (($r=$q->fetchAssoc(false))){
			$j[]=array(
				"name"=>$r["name"],
				"models"=>Makes::getModels($r["name"])
			);
		}
		sort($j);
		return $j;		
	}
}
?>