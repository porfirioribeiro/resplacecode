<?php
$path="OpenWebMS/";
include_once $path.'WebMS.php';
$page=new WebMS($path,"OpenWebMS - Help Us");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website,webms,openwebms,website,management,system'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	?>
	We utilize Google Code's FREE SVN Repository Service in order to maintain the OpenWebMS source code, you may obtain a copy of the current developments (as they are happening) by downloading an <a href="http://tortoisesvn.net/downloads" target="_blank">SVN Client</a> and obtaining the SVN source.<br />
	<br />
	OpenWebMS MUST be placed on a PHP server in order to operate at all, so you will either have to upload the system to your server (not recommended) or install a mini-server onto your computer and then run OpenWebMS from your machine (recommended) We recommend XAMPP as your personal Apache server.<br />
	<br />
	<b><u>Obtaining source using <a href="http://tortoisesvn.net/downloads" target="_blank">TortoiseSVN</a></u></b><br />
	Firstly create a directory on your computer (if you have a web server on your computer, create a directory in the root of the server). Then right-click on the folder and choose the option labeled &quot;SVN Checkout...&quot;.<br />
	<br />
	A window should appear asking for a URL to the repository, this is the URL to where you want to obtain the source code from, In our case you would put this URL into the box:<br />
	<div class="tbl" style="margin:5px;padding:5px">
	<i><b>http://resplacecode.googlecode.com/svn/trunk/WebProjects/WebsiteCMS/Source/</b></i></div><br />
	Each time you want to obtain the latest source just right click the same folder and choose the option "SVN Update".
	
	<br /><br />
	Have fun friends....
	<?php
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"How to get OpenWebMS");
$page->create();
?>








