<?php
include_once "../data/Functions/ResDB.php";
include_once "Template.php";


preg_replace("/#\{iif:check,(.*),(.*)\}/",(false)?'${1}':'${2}',"#{iif:check,if true,if false}");

$tpl=new Template("
	I am #{iif:iscool,cool,not cool}!<br> 
	#{kk}
");

$map=new ArrayMap();
$map->put("iscool",false);
$map->put("kk","lolz");
echo $tpl->parse($map);
?>