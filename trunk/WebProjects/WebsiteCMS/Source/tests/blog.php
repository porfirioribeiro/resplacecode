<?php
include "ResDB2.php";
include dirname(__FILE__)."/../data/functions/Template.php";
$db=new ResDB2("table.db",true);
$table=$db->addTable("cool",array("AI"=>"id","title","body"));//this will only add a table if it doesnt exist yet ;)

//$table->insert(array("title"=>"My first entry","body"=>"This is my first entry!"));
//$table->insert(array("title"=>"Opps, i did it again!","body"=>"Yes, i did, my secod blog post!"));
$tpl=new TplFile("blog.tpl");
$rows=$table->getAll();
$posts="";
foreach ($rows as $row) {
	$posts.=$tpl->get("post")->parse($row);
}
echo $tpl->get("main")->parse(array("posts"=>$posts));

$db->close();
?>