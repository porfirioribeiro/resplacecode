<?php
header("Content-type: application/javascript");
require_once("config.php");

$req=array_merge($_GET,$_POST);

if (isset($req["fn"])){
	$fn="svr_".$req["fn"];
	if (function_exists($fn)){
		array_shift($req);
		$fn($req);
	}
}


function svr_getModels($args){
	if (isset($args["model"])){
		die(Makes::modelsToJson($args["model"]));
	}
}


global $json;
die($json->encode(null));

//echo Makes::modelsToJson("Mercedes");
?>