<?php

$page=new WebMS(WEBMS_ROOT,"Blog");

$page->addMeta(array('name' => 'keywords','content' => 'blog,personal,'));
$ct="";
$ct2="";
$title="Blog";
$catarray=array();	

//Start the database
$db=new ResDB("Blog","Blog",true);
//Define the table (created if not exist)
$table=$db->addTable("entrys",array("AI"=>"id","catid","userid","title","sub","body","date"));
$tableCat=$db->addTable("categorys",array("AI"=>"id","name","description"));
$tpl=new TplFile(dirname(__FILE__)."\blog.tpl");

//Generate Category list
$rows=$tableCat->getAll();
$posts="";
$ct2="<a href='?blog'>Blog Homepage</a><br><br><b>Category's</b><br>";
foreach ($rows as $row) {
	$ct2.=$tpl->get("cat")->parse(array('id'=>$row['id'],'des'=>$row['description'],'title'=>$row['name']));
	$catarray[$row['id']]=array('id'=>$row['id'],'name'=>$row['name'],'des'=>$row['description']);
}

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
	if (isset($WebMS['URLArray'][1]) && $WebMS['URLArray'][1]=="Add") {
		//add WYSIWYG js
		$page->addJS("wyzz/wyzz.js");
		//$page->addCSS($WebMS['JSPath']."wyzz/wyzzstyles/style.css");
		//echo'
		//<script language="javascript1.2">
		//    editstyle = \''.$WebMS['JSPath'].'wyzz/wyzzstyles/editarea.css\';
		//</script>';
		//add new entry
		//create category list
			$cats="";
			//print_r($catarray);
			foreach ($catarray as $i) {
				$cats.=$tpl->get("SelectCat")->parse($i);
			}
		$ct=$tpl->get("addpost")->parse(array("CATS"=>$cats,"action"=>url(array("*"))));
	}else if (isset($WebMS['URLArray'][1]) && $WebMS['URLArray'][1]=="AddCat") {
		//add new category
		
		$ct=$tpl->get("addcat")->parse(array("action"=>url(array("*"))));
	}else if (isset($_POST["add"])) {
		//submit entry
		$date=date("d-m-y g:i a");
		
		$table->insert(array("catid"=>$_POST["catid"],"userid"=>$WebMS['User_ID'],"title"=>$_POST["title"],"sub"=>$_POST["des"],"body"=>$_POST["body"],"date"=>$date));
		header("Location: ".url(array("*")));
	}else if (isset($_POST["add2"])) {	
		$tableCat->insert(array("name"=>$_POST["title"],"description"=>$_POST["des"]));
		header("Location: ".url(array("*")));
	}
}

$bp=0;

//show category
if (isset($WebMS['URLArray'][1]) && $WebMS['URLArray'][1]=="Cat") {
	//show blog entrys in category
	$title="Category: ".$catarray[$WebMS['URLArray'][1]]['name'];
	$rows=$table->getAll()->getBy("catid=".(int)$WebMS['URLArray'][1])->reverse();
	$posts="";
	foreach ($rows as $row) {
		$posts.=$tpl->get("post")->parse($row);
		$id=$row['catid'];
		//echo $id;
		$row['cat']="<a href='?cat=".$id."'>".$catarray[$id]['name']."</a>";
		//print_r($catarray);
	}	
	$ct=$tpl->get("list")->parse(array("posts"=>$posts));
}

if (!isset($WebMS['URLArray'][1]) || (!$WebMS['URLArray'][1]=="Add" && !$WebMS['URLArray'][1]=="AddCat" && !$WebMS['URLArray'][1]=="Cat")) {
	if (isset($WebMS['URLArray'][2]))
		$bp=(int)$WebMS['URLArray'][2];
		
	if ($bp) {
		//show blog entry
		$post=$table->getBy("id=".(int)$WebMS['URLArray'][2]);
		$posti=$tpl->get("showpost")->parse($post[0]);
		$ct=$tpl->get("showing")->parse(array("showpost"=>$posti));
		$title=$post[0]['title'];
	} else {
		//show list of blog entrys
		$rows=$table->getAll()->getBy("body<>")->reverse();
		$posts="";
		foreach ($rows as $row) {
			
			if ($WebMS['User_Userlvl']==2) {
				$row['del']="<a href='?del=".$row['id']."'><img src='".$WebMS['AdminUrl']."icons/button_cancel.png' style='vertical-align:middle' border='0' /></a>";
			} else {
				$row['del']="";
			}
			$posts.=$tpl->get("post")->parse($row);
			$id=$row['catid'];
			//echo $id;
			$row['cat']="<a href='?cat=".$id."'>".$catarray[$id]['name']."</a>";
			//print_r($catarray);
		}	
		$ct=$tpl->get("main")->parse(array("posts"=>$posts));
	}
}

//add default layout
$page->addLayout("Default");
//add the page
$page->addS($ct,$title);
//add the categorys
$page->addS($ct2,"Blog Menu","right");
$db->close();
$page->create();
?>