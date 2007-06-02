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
 define( "PATH", "data/" );
 
 // Initialize new session
 session_start();
 
 // Basic Definitions
 //$_REQUEST['page'] = preg_match("/[^a-z0-9_-]/", '', strtolower( $_REQUEST['page'] ));
 $Page = strtolower( $_REQUEST['page'] );
 //$Action = $_REQUEST['action'];

 // Do we have a page set?
 //if( !isset( $_REQUEST['page'] ) )
 //{
 	// If not load from a session
//	$Page = $_SESSION['page'];
 //}
 
 // Create a new session for our page
 $_SESSION['page'] = $Page;
 
 if( file_exists( PATH . "Pages/$Page.php" ) )
 {
 	include( PATH . "Pages/$Page.php" );
 }
?>