<?php

include_once "Template.php";

$tpl=new Template("
	asd ${10} be
");

echo $tpl->parse(array());

?>