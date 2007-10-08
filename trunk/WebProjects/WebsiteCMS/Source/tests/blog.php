<?php
$path="../OpenWebMS/";
include_once "../OpenWebMS/WebMS.php";
$page=new WebMS($path,"Blog");
$page->addDefaults();




$db=new ResDB("Blog","",true);
$table=$db->addTable("cool",array("AI"=>"id","title","body"));//this will only add a table if it doesnt exist yet ;)

//$table->insert(array("title"=>"My first entry","body"=>"This is my first entry!"));
//$table->insert(array("title"=>"Opps, i did it again!","body"=>"Yes, i did, my secod blog post!"));
//$table->insert(array("title"=>"another","body"=>"just shit"));
$tpl=new TplFile("blog.tpl");

if (isset($_GET["admin"])){
	$ct=$tpl->get("addpost")->parse();
}else if (isset($_GET["addPost"])){
	$table->insert(array("title"=>$_GET["title"],"body"=>$_GET["body"]));
	header("Location: blog.php?admin");
}else if (isset($_GET["showPost"])){
	$post=$table->getBy("id=".$_GET["showPost"]);
	$post=$tpl->get("post")->parse($post[0]);
	$ct=$tpl->get("showpost")->parse(array("post"=>$post));
}else{
	$rows=$table->getAll()->getBy("body<>")->reverse();
	$posts="";
	foreach ($rows as $row) {
		$posts.=$tpl->get("post")->parse($row);
	}	
	$ct=$tpl->get("main")->parse(array("posts"=>$posts));
	
}



$page->addS('
<a href="blog.php">Home</a><br>
<a href="blog.php?admin">Admin</a>
',"Blog Menu",Module::LEFT);
$page->addS($ct,"Blog");
$page->addS(print_r($db,true),"Array dump");
$db->close();
$page->create();
?>