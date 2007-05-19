<?php
//Set path to the data/ directory FIRST:
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Admin Panel");
$page->addFunctionSearchPath("Functions/");
$page->addModuleSearchPath("Modules/");
$page->addDefaults();



$page->add("dbEditor");
$page->add("dbList");
$page->create();
?>
