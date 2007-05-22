<?php
include_once "../data/Functions/ResDB.php";
include_once "Template.php";

$tpl=new Template("
	#{start:tpl}
	cool
	#{end:tpl}
	I am #{use:tpl} and you are #{use:tpl}	
");

echo preg_replace("/#\{use:(.*)\}/",'${1}',$tpl->template);


?>