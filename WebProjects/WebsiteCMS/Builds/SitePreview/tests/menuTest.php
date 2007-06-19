<?php
$path="../OpenWebMS/";
include_once $path.'WebMS.php';
$page=new WebMS($path,"resplace.net, the home to under construction :)");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
$page->addDefaults();
$page->add("Menu");

function someContent($mod){
	
	$db=new ResDB("Menu");
	
	$m1=$db->addMap("1");
	$m1->put("name","Home");
	$m1->put("url","http://resplace.net/index.php?page=index");
	
	$m2=$db->addMap("2");
	$m2->put("name","Blog");
	$m2->put("url","http://blog.resplace.net/");
	
	$m3=$db->addMap("3");
	$m3->put("name","Forum");
	$m3->put("url","http://forum.resplace.net/");
	
	$m4=$db->addMap("4");
		$m4->put("name","Projects");
			
			$wpm1=$m4->addMap("1");
			$wpm1->put("name","Web Projects");
			
				$wpm12=$wpm1->addMap("1");
				$wpm12->put("name","OpenWebMS");
				
					$wpm13=$wpm12->addMap("1");
					$wpm13->put("name","About...");
					$wpm13->put("url","http://resplace.net/index.php?page=about");
					
					$wpm13=$wpm12->addMap("2");
					$wpm13->put("name","Help Us?");
					$wpm13->put("url","http://resplace.net/index.php?page=help");
					
					$wpm13=$wpm12->addMap("3");
					$wpm13->put("name","Obtain Source");
					$wpm13->put("url","http://resplace.net/index.php?page=source");
		
		$db->close();
}

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"Welcome");
$page->create();
?>








