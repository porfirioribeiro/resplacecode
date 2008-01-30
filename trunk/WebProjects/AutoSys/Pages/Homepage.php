<?php

$path="AutoSys/";

$page=new WebMS($path,"Pagina Inicial");
$page->addMeta(array('name' => 'keywords','content' => 'FFAuto,carros,usados'));

$page->addModule("Menu");
$page->addModule("QuickSearch");

$page->addModule("Nada Ainda<br>".url("AboutAutoSys"),"Carros");

$page->create();
?>
