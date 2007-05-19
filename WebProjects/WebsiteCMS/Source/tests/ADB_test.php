<?php

include dirname(__FILE__)."/../data/functions/ResDB.php";


$db=new ArrayMap();
$db->put("cool",10);
$db->putPath("ok.nice","xd");
$db->putPath("nah",5);
$db->putPath("oks.oh.isee.coolz","xd");
$db->putPath("nal",5);
echo $db->toJSON();


?>
