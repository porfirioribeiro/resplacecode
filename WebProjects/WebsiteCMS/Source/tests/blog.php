<?php
$path="../data/";
include_once $path.'site.php';
$page=new WebMS($path,"Blog");
$page->addDefaults();

include "ResDB2.php";


$db=new ResDB2("table.db",true);
$table=$db->addTable("cool",array("AI"=>"id","title","body"));//this will only add a table if it doesnt exist yet ;)

//$table->insert(array("title"=>"My first entry","body"=>"This is my first entry!"));
//$table->insert(array("title"=>"Opps, i did it again!","body"=>"Yes, i did, my secod blog post!"));
//$table->insert(array("title"=>"another","body"=>"just shit"));
$tpl=new TplFile("blog.tpl");
$rows=$table->getAll()->limit(1,2);
$posts="";
foreach ($rows as $row) {
	$posts.=$tpl->get("post")->parse($row);
}

$ct=$tpl->get("main")->parse(array("posts"=>$posts));
$page->addS($ct,"Blog");
$db->close();
$page->create();
?>