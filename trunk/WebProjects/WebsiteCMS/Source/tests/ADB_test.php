<?php
include_once "ADB.php";
$db=new ADB("test.db","porf");
//print_r($db->errors);

echo $db->get("cool","no key seted yet");
$db->put("cool","nic");


$db->close("porf",true);
//print_r($db->errors);
?>