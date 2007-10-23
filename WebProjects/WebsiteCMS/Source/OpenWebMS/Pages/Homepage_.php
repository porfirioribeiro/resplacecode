<?php
/**
* Homepage
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 06-06-07
*/
//Set path then include the system into the page.
$path="OpenWebMS/";
//include_once $path.'WebMS.php';

//Setup the WebMS class
$page=new WebMS($path,"Homepage");
//add some meta keywords
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));


//begin adding modules...
//$page->add("Menu",Module::LEFT);
//$page->add("SkinChanger",Module::LEFT);
//$page->add("PageRate",Module::LEFT);


function WelcomeModule($mod){
	?>
	Welcome to my personal 'Higher National Diploma' web site, this site has been setup party as a requirement for an assignment but also so I can log and keep track of my work whilst doing my BTEC National Diploma.<br>
	Soon you will be able to browse all the units I have completed or I'm currently working on, aswell as get copy's of my current work and assignment sheets. You will also be able to read a blog I will be setting up shortly to talk about my course and my college, nothing too interesting though!<br><br>
	For now, you will just have to wait...
	<br><br>
	&nbsp;&nbsp;&nbsp; ;)<br><br>
	<?php
}
$page->addF("WelcomeModule","Welcome");
$page->addLayout("Default");
//$page->add("Box");


//$AbsRootPath=preg_replace("/\\\/","/",dirname(__FILE__));
//$RootPath=str_replace($_SERVER["DOCUMENT_ROOT"], "", $AbsRootPath);
//$page->addS($_SERVER['SERVER_ADMIN'].$_SERVER['HTTP_HOST'],"With string method");
$page->create();
?>
