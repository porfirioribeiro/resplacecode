<?php
/**
* SimpleMachines Integration Script 1.0
* A stand-alone model for which WebMS can use to manage user accounts
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 15-09-07
*/


//*login link
//*register link
//*logout link
//*profile link
//get logged in user info
//get user info by user id
//fetch user level 0 - guest, 1 - member, 2 - admin

$SSIPath=$WebMS["WebMSPath"]."../../../../../New Folder/Unsorted/smf105/SSI.php";
include($SSIPath);

	//$db=new ResDB("WebMSoptions");
	//	$SSIPath=$db->get("SSI_PATH");
		
	CurrentUser();

function RegisterLink() {
	//Info: Return a register link to the intergrated systems register page.
	
	//Return a link
	return "link";
}

function LoginLink() {
	//Info: Return a login link to the intergrated systems register page.
	
	//Return a link
	return "link";
}

function LogoutLink() {
	//Info: Return a logout link to the intergrated systems register page.
	
	//Return a link
	return "link";
}

function ProfileLink() {
	//Info: Return a profile link to the intergrated systems register page.
	
	//Return a link
	return "link";
}


function CurrentUser() {
	global $WebMS, $SSIPath, $memberContext, $context, $memberContext, $user_info;
	//Info: fetches user information for currently logged in user (if there is one) and stores details in the global variables of the system.
	
	
	loadMemberData($context['user']['id']);
	//foreach ($members_id as $id)
		loadMemberContext($context['user']['id']);

	//Fetch user permission (if guest set username etc to guest)
	if ($user_info['is_guest']) {
		$WebMS["User_Userlvl"]=0;
		$WebMS["User_Username"]="Guest";

	} else {
		//well there logged in :)
		if ($user_info['is_admin']) {
			$WebMS["User_Userlvl"]=2;
		} else {
			$WebMS["User_Userlvl"]=1;
		}
		//site mod code
		//in_array(2, $user_info['groups']);
		
		//Fetch user id
		$WebMS["User_ID"]=$context['user']['id'];
		
		//Fetch Username and name
		$WebMS["User_Username"]=$context['user']['username'];
		$WebMS["User_Name"]=$context['user']['username'];
		
		//user email
		$WebMS["User_Email"]=$context['user']['email'];
		
		//Fetch users avatar URL
		$WebMS["User_Avatar"]=$context['user']['avatar']['href'];
		
		//fetch users signature
		if (!empty($memberContext[$context['user']['id']]['signature'])){
			$WebMS["User_Sig"]=$memberContext[$context['user']['id']]['signature'];
		}
	}
}

function FetchUser($userid) {
	//Info: fetches user information depending on user id (NUMBERS only!)
	global $WebMS, $SSIPath, $memberContext;
	//Info: fetches user information for currently logged in user (if there is one) and stores details in the global variables of the system.
	
	include($SSIPath);
	
	if (loadMemberData($userid)){
		loadMemberContext($userid);
		
		//get admin privilages
		$memberContext[$userid]['is_admin'] = $memberContext[$userid]['group_id'] == 1 || allowedTo('admin_forum');
		
		if ($memberContext[$userid]['is_admin']) {
				$WebMS["FUser_Userlvl"]=2;
			} else {
				$WebMS["FUser_Userlvl"]=1;
			}
		
		//Fetch user id
		$WebMS["FUser_ID"]=$userid;
		
		//Fetch Username and name
		$WebMS["FUser_Username"]=$memberContext[$userid]['username'];
		$WebMS["FUser_Name"]=$memberContext[$userid]['username'];
		
		//user email
		$WebMS["FUser_Email"]=$memberContext[$userid]['email'];
		
		//Fetch users avatar URL
		$WebMS["FUser_Avatar"]=$memberContext[$userid]['avatar']['href'];
		
		//fetch users signature
		if (!empty($memberContext[$userid]['signature']))
			$WebMS["FUser_Sig"]=$memberContext[$userid]['signature'];
		
	} else {
		$WebMS["FUser_Userlvl"]=0;
		$WebMS["FUser_Username"]="Guest";
	}
}
?>