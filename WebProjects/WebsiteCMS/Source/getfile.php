<?php
/**
 * $Id: getfile.php, v#.#.#, 2007-MAY-08
 * @Author: Dean Williams < email >
 * @Author: Porfirio Ribeiro < email >
 * @Build: 20070508
 * @Notes:
 * [05-08-07 @ 10:32PM PST] - Organized and added header to document < steve >
 */

 // Common Definitions
 define( "PATH", "OpenWebMS/" );

 // Initialize new session
 session_start();

 foreach ($_GET as $n => $val) {
 	$page=$n;
 	break;
 }
 
 if ($page=="p" && $_GET[$page]!=null){
 	$page=$_GET[$page];
 }
 
 echo $page;
 
/*
 $_SESSION['page'] = $Page;

 if( file_exists( PATH . "Pages/$Page.php" ) )
 {
 	include( PATH . "Pages/$Page.php" );
 }
*/
?>