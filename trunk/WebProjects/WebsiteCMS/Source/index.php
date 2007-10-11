<?php
/**
* System Content Provider
* Handles all requests (or should) in the system
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright (c) 2007 ResPlace Team
* @lastedit 10-10-07
*/
include_once("OpenWebMS/config.php");
define("WEBMS_ROOT","OpenWebMS/");

//TODO remove...
$pages=WEBMS_ROOT."Pages/";
$systems=WEBMS_ROOT."Systems/";
$admin=WEBMS_ROOT."Admin/";
$tests=WEBMS_ROOT."Tests/";
include_once(WEBMS_ROOT."WebMS.php");

//check what format we are using to load pages!
if ($WebMS["URLFormat"]=="CleanDots") {
	//CleanDots method...
}

$page="";
//Get the first $_GET that exists...
 foreach ($_GET as $n => $val) {
 	$page=$n;
 	break;
 }
 
 //if $_GET is "p" we are using the ?p=blah
 if ($page=="p" && $_GET[$page]!=null){
 	$page=$_GET[$page];
 }

//replace all bad characters!
$page=preg_replace('/[^a-zA-Z0-9_-]/i', '-',$page);
define("URL_PART_COMPLETE",$page);

$page=preg_split("/_/",$page);
define("URL_PART_N",count($page));
foreach ($page as $n=>$urlpart) {
	$nn=$n+1;
	define("URL_PART_$nn",$urlpart);
}


if (sizeof($page)>1){
	$cat=$page[0];
	if (isset($page[2])){
		$pane=$page[2];
	}
	$page=$page[1];	
}else{
	$cat=null;
	$page=$page[0];
	$pane=null;
}


if (URL_PART_1=="Admin"){
	include $admin."index.php";//devMODE
}else if (URL_PART_1=="Test"){
	if (defined("URL_PART_2")){
		if (is_file($tests.URL_PART_2.".php")){
			include $tests.URL_PART_2.".php";
		}else{
			//TODO=Test Page including
			$p= new WebMS("OpenWebMS/","Error, Test Page not found!!");
			$p->addS("<b>Test Page Not Found</b><br>Could not find Test Page : $page ","Error",Module::TOP);
			$p->create();
		}
	}else{
		//TODO=Test Pages Browsing
		$p= new WebMS("OpenWebMS/","Browse Test pages");
		$st="<b>Browse Test pages</b><br><br><ul>";
		$tf=GetFiles($tests,"*.php");
		foreach ($tf as $f) {
			$f=str_replace(".php","",$f);
			$st.="<li><a href='?Test.$f'>$f</a></li>";
		}
		$st.="</ul>";
		$p->addS($st,"Browser",Module::TOP);
		$p->create();
	}
	//include $admin."index.php";//devMODE
}else if (URL_PART_1==""){
	//TODO=Default page including
	include "apage.php";
}else if (is_file($systems.URL_PART_1.".php")){
	include $systems.URL_PART_1.".php";
}else if (is_file($pages.URL_PART_1.".php") && (defined("URL_PART_2") && is_dir($pages.URL_PART_1) ) ){
	include $pages.URL_PART_1.".php";
}else{
	//TODO=Error Page including
	$p= new WebMS("OpenWebMS/","Error, Page not found!!");
	$st="<b>Page Not Found</b><br>";
	$st.="Could not find $page ";
	if ($cat){
		$st.=" on category <b>$cat</b> !!";
	}else{
		$st.="either on pages or systems!!";
	}
	$p->addS($st,"Error",Module::TOP);
	$p->create();
}

function url() {
	
}
 

?>