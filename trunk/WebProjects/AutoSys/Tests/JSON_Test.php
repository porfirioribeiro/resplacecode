<?php
require_once (dirname(__FILE__)."/../Core/Includes/JSON.php");
require_once (dirname(__FILE__)."/../Core/Includes/ResDB.php");
// create a new instance of Services_JSON
//global $json;
 
// convert a complexe value to JSON notation, and send it to the browser
$value=array("Corsa","Vectra");



$output = $json->encode($value);
 
print("<script>var a=$output</script>");
// prints: ["foo","bar",[1,2,"baz"],[3,[4]]]

// accept incoming POST data, assumed to be in JSON notation

$value = $json->decode($output);

print_r($value);
?>