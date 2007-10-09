<?php
/**
 * $Id: getfile.php, v#.#.#, 2007-MAY-08
 * @Author: Dean Williams < email >
 * @Author: Porfirio Ribeiro < email >
 * @Build: 20070508
 * @Notes:
 * [05-08-07 @ 10:32PM PST] - Organized and added header to document < steve >
 */

define("WEBMS_ROOT","OpenWebMS/");

$pages=WEBMS_ROOT."Pages/";
$systems=WEBMS_ROOT."Systems/";
$admin=WEBMS_ROOT."Admin/";
include_once(WEBMS_ROOT."WebMS.php");

$page="";
 foreach ($_GET as $n => $val) {
 	$page=$n;
 	break;
 }
 
 if ($page=="p" && $_GET[$page]!=null){
 	$page=$_GET[$page];
 }
 
$page=preg_replace('/[^a-zA-Z0-9_-]/i', '-',$page);
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



if ($cat!=null && is_file($pages.$cat.$page.".php") ){
	include $pages.$cat.$page.".php";
}else if ($cat=="Admin" || $page=="Admin"){
	if ($page!=null && $page!="Admin"){
		define("ADMIN_NAVIGATE",$page);
	}
	if ($page=="Panes"){
		define("ADMIN_PANE",$pane);
	}
	include $admin."index.php";//devMODE
}else if ($cat==null && is_file($systems.$page.".php")){
	include $systems.$page.".php";
}else if ($cat==null && is_file($pages.$page.".php")){
	include $pages.$page.".php";
}else if ($cat==null && $page==null){
	//TODO=Default page including
	include "apage.php";
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
 

?>