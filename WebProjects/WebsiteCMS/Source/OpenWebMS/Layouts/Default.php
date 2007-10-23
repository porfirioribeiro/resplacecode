<?php
//this is the default layout for WebMS (also acts as an example).
//the purpose of a layout is to repeat the same "widgets" into many pages from one
//location which can easily be modified, these pages are included into a page using:
//$page->addLayout("name"); (name of this file, without .php)

$this->add("SkinChanger",Module::LEFT);
$this->add("PageRate",Module::LEFT);
?>