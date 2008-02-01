<?php
/**
 * Returns a well formed url depending on wish url system we are using
 * Usage: 
 * $u=url(array("Admin","DB"));
 * $u=url("Admin/DB");
 * You can put * to use the same part as we have on current url
 * so if we are at /Admin/DB we can put * /Test and it will give url to Admin/Test
 * @param String|Array $arr
 * @return unknown
 */
function url($arr=null) {
	global $WebMS;
	if (!is_array($arr)){
		$arr=explode("/",$arr);
	}
	$frm="";
	if (count($arr)) {
		if (isset($arr[0]) && $arr[0]=="**") {
			for($i=0;$i<=count($WebMS["URLArray"])-1;$i++) {
				if (!$i==0)
				$frm.="/";
				$frm.=$WebMS["URLArray"][$i];
			}
		} else {
			for($i=0;$i<=count($arr)-1;$i++) {
				if (!$i==0)
				$frm.="/";
				if ($arr[$i]=="*")
				if (isset($WebMS["URLArray"][$i])) {
					$arr[$i]=$WebMS["URLArray"][$i];
				} else {
					$arr[$i]='';
				}
				$frm.=$arr[$i];
			}
		}
	}
	if ($WebMS["mod_rewrite"]){
		return $WebMS["RootUrl"].$frm;
	}
	return $WebMS["ScriptUrl"]."/".$frm;
}

$q=preg_replace("/index\.php/","",array($_SERVER['REQUEST_URI'],$_SERVER['SCRIPT_NAME']));
$q=str_replace($q[1],"",$q[0]);
$q=str_replace("?".$_SERVER["QUERY_STRING"],"",$q);
$q=preg_replace("/^\//","",$q);


$page=explode("/",$q);
//set array to variable
$WebMS["URLParts"]=count($page);
$WebMS["URLArray"]=$page;

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

//begin deciding events!
if ($WebMS["URLParts"]==0 || $WebMS["URLArray"][0]=="") {
	//nothing set, load default homepage
	$WebMS['URLPage']="Homepage.php";
	$WebMS['URLArray']=array("Homepage");
	include $pages."Homepage.php";
} else {
	if ($WebMS["URLArray"][0]=="Admin") {
		//load admin page
		$WebMS["URLPage"]=$WebMS["URLArray"][0];
		if (isset($WebMS["URLArray"][1])) {
			$WebMS["URLCat"]=$WebMS["URLArray"][1];
		}
		include $admin."index.php";
	} else if ($WebMS["URLArray"][0]=="Test") {
		if ($WebMS["URLParts"]>=2){
			if (is_file($tests.$WebMS["URLArray"][1].".php")){
				$WebMS["URLCat"]=$WebMS["URLArray"][0];
				$WebMS["URLPage"]=$WebMS["URLArray"][1];
				include $tests.$WebMS["URLArray"][1].".php";
			}else{
				//TODO=Test Page including
				$p= new WebMS("Error, Test Page not found!!");
				$p->addModule("<b>Test Page Not Found</b><br>Could not find Test Page : $page ","Error",Module::TOP);
				$p->create();
			}
		}else{
			//TODO=Test Pages Browsing
			$p= new WebMS("Browse Test pages");
			$st="<b>Browse Test pages</b><br><br><ul>";
			$tf=GetFiles($tests,"*.php");
			foreach ($tf as $f) {
				$f=str_replace(".php","",$f);
				$st.="<li><a href='?Test.$f'>$f</a></li>";
			}
			$st.="</ul>";
			$p->addModule($st,"Browser",Module::TOP);
			$p->create();
		}
	} else if (is_file($users.$WebMS["URLArray"][0].".php")) {
		//include a users file
		$WebMS["URLPage"]=$WebMS["URLArray"][0];
		include $users.$WebMS["URLArray"][0].".php";
	} else if (is_file($systems.$WebMS["URLArray"][0].".php")) {
		//include a system file
		$WebMS["URLPage"]=$WebMS["URLArray"][0];
		include $systems.$WebMS["URLArray"][0].".php";
	} else if (($WebMS["URLParts"]>=2 && is_file($pages.$WebMS["URLArray"][0].'/'.$WebMS["URLArray"][1].".php")) && (is_dir($pages.$WebMS["URLArray"][0]))) {
		//include a page (sub)
		$WebMS["URLPage"]=$WebMS["URLArray"][0];
		$WebMS["URLCat"]=$WebMS["URLArray"][1];
		include $pages.$WebMS["URLArray"][0]."/".$WebMS["URLArray"][1].".php";
	} else if (is_file($pages.$WebMS["URLArray"][0].".php")) {
		//include a page
		$WebMS["URLPage"]=$WebMS["URLArray"][0];
		include $pages.$WebMS["URLArray"][0].".php";
		//TODO fix for pages in categorys?
	} else {
		//TODO=Error Page including
		$p= new WebMS("Error, Page not found!!");
		$st="<b>Page Not Found</b><br>";
		$st.="Could not find $page ";
		if ($cat){
			$st.=" on category <b>$cat</b> !!";
		}else{
			$st.="either on pages or systems!!";
		}
		$p->addModule($st,"Error",Module::TOP);
		$p->create();
	}
}
?>