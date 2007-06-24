<?php
/**
* Stand-alone model for user management
* A stand-alone model for which WebMS can use to manage user accounts
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 24-06-07
*/
class UserManage {
	//what we will need to handle (* = started ; ** = done)
	
	//System Constraints (what is and isnt supported)
	//*User registration
	//User login
	//User logout
	//User profile/settings
	//Is user logged in
	//Is user a member or admin
	//Get users profile image/avatar
	//Users information
	
	function RegisterUser($mode=1) {
		$mode=(int)$mode;
		//Info: $mode is the mode to send to this function:
		//1 = Return a link to register page (Default).
		//2 = Return a "Register" code block, or return FALSE if not possible.
		//3 = Process a "Register" submit (on failure we process error).
		
		//Return a link
		if ($mode==1) {
			return "link";
		}
		else if ($mode==2) {
			return FALSE;
		}
		else if ($mode==3) {
		
		}
	}
	
	function UserLogin($mode=1) {
		$mode=(int)$mode;
		//Info: $mode is the mode to send to this function:
		//1 = Return a link to the login page (Default).
		//2 = Return a "quick login" code block, or return FALSE if not possible.
		//3 = Process a "login" request.
	}
}
?>