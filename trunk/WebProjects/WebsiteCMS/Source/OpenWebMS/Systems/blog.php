<?php
$path="../";
include_once $path.'WebMS.php';
$page=new WebMS($path,"Blog");

$page->addMeta(array('name' => 'keywords','content' => 'blog,personal,'));
$page->addDefaults();
$ct="";

//Start the database
$db=new ResDB("Blog","Blog",true);
//Define the table (created if not exist)
$table=$db->addTable("entrys",array("AI"=>"id","userid","title","sub","body","date"));
$tpl=new TplFile("blog.tpl");

//Check if the system is using a UMS:
$ums=0;
if ($WebMS["UMS"]) {
	//Yes, now are we using the built in UMS or integrated?
	if ($WebMS["Integrate"]) {
		//Using integrated system.
		$ums=2;
	} else {
		//Using built in UMS, make sure the MySQL is enabled since it requires this (optional check)
		if ($WebMS["MySQL_Use"]) {
			//using bult in system.
			$ums=1;
		} else {
			//umm you need MySQL?
			//TODO generate warning here
			$ums=0;
		}
	}
}

//If your admin allow for posting...
if ($WebMS['User_Userlvl']==2) {
	//admin stuff here
	if (isset($_GET["add"])) {
		$ct=$tpl->get("addpost")->parse(array("action"=>$_SERVER['PHP_SELF']));
	}else if (isset($_POST["add"])) {
		$date=date("d-m-y g:i a");
		$table->insert(array("userid"=>$WebMS['User_ID'],"title"=>$_POST["title"],"sub"=>$_POST["des"],"body"=>$_POST["body"],"date"=>$date));
		header("Location: ".$_SERVER['PHP_SELF']);
		
	}
}

$bp=0;
if (!isset($_GET["add"])) {
	if (isset($_GET['bp']))
		$bp=(int)$_GET['bp'];
		
	if ($bp) {
		//show blog entry
		$post=$table->getBy("id=".$_GET["bp"]);
		$post=$tpl->get("showpost")->parse($post[0]);
		$ct=$tpl->get("showing")->parse(array("showpost"=>$post));
	} else {
		//show list of blog entrys
		$rows=$table->getAll()->getBy("body<>")->reverse();
		$posts="";
		foreach ($rows as $row) {
			$posts.=$tpl->get("post")->parse($row);
		}	
		$ct=$tpl->get("main")->parse(array("posts"=>$posts));
	}
}

//add the page
$page->addS($ct,"Blog");
$db->close();
$page->create();
?>