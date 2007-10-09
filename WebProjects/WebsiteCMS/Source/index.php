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

$pages="OpenWebMS/Pages/";
$systems="OpenWebMS/Systems/";

include_once(WEBMS_ROOT."WebMS.php");

 foreach ($_GET as $n => $val) {
 	$page=$n;
 	break;
 }
 
 if ($page=="p" && $_GET[$page]!=null){
 	$page=$_GET[$page];
 }
 
$page=preg_replace('/[^a-zA-Z0-9_-]/i', '-',$page);
$page=preg_split("/_/",$page);

$cat="";
if (count($page)>=2){
	$cat=$page[0];
	$page=$page[1];	
}else{
	$cat=null;
	$page=$page[0];
}



if ($cat!=null && is_file($pages.$cat.$page.".php") ){
	include $pages.$cat.$page.".php";
}else if ($cat==null && is_file($systems.$page.".php")){
	include $systems.$page.".php";
}else if ($cat==null && is_file($pages.$page.".php")){
	include $pages.$page.".php";
}else if ($cat==null && $page==null){
	//TODO=Default page including
	include "apage.php";
}else{
	//TODO=Error Page including
	$page= new WebMS("OpenWebMS/","Error, Page not found!!");
	$st="<b>Page Not Found</b><br>";
	$st.="Could not find $page";
	if ($cat){
		$st.=" on category <b>$cat</b> !!";
	}else{
		$st.="either on pages or systems!!";
	}
	$page->addS($st,"Error",Module::TOP);
	$page->create();
}
 

?>