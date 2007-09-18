<?php
//needs modifying
/**
* User Login Management (NON INTEGRATED)
* This script validates sessions created when a user logs into the website (when system is not running integration).
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 09-09-07
*/

if ((!$WebMS["Integrate"]) && (isset($_SESSION["username"]))) {
		//Not using integration, run script...
		
		//grab user data
		$db= new sql();
		$result=$db->query("SELECT * FROM ".$WebMS["MySQL_Prefix"]."users WHERE usrname='".$_SESSION["username"]."'",true);
		
		//user exists?
		if (!count($result)) {
			//no? remove session
			$_SESSION["username"]="";
			$_SESSION["psswrd"]="";
		} else {
			//does password match?
			if ((strcmp($_SESSION["psswrd"],$result['0']['psswrd'])==0)) {
				//yes? then log that were logged in :)
				
				$WebMS["User_ID"]=$result['0']['id'];
				$WebMS["User_Username"]=$result['0']['usrname'];
				$WebMS["User_Password"]=$result['0']['psswrd'];
				$WebMS["User_Email"]=$result['0']['email'];
				$WebMS["User_Name"]=$result['0']['name'];
				$WebMS["User_Userlvl"]=$result['0']['usrlvl'];
				$WebMS["User_Datereg"]=$result['0']['datereg'];
				$WebMS["User_Datelog"]=$result['0']['datelog'];
				$WebMS["User_Sig"]=$result['0']['sig'];
				$WebMS["User_Avatar"]=$result['0']['avatar'];

			} else {
				//no? remove session
				$_SESSION["username"]="";
				$_SESSION["psswrd"]="";
			}
		}
	}
?>