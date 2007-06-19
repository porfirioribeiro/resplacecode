<?php
$path="data/";
include_once $path.'site.php';
$page=new WebMS($path,"resplace.net, the home to under construction :)");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	?>
Welcome to <strong>resplace.net</strong> the new home for <strong>tpvgames.co.uk</strong>, please stay tuned whilst we finish the engine   for this web site. If you would like to access our existing projects then go to   our <a href="http://tpvgames.co.uk">old web site</a> for now.<br />
<br />
This web site   is using a ALPHA version of WebMS, a project were developing for other   webmasters to use, more information about this project can be found on the   "WebMS" page.  <br />
Look how you can change the site skin and collapse the site   widgets, cool huh? MORE TO COME! Please vote on how much you like the system!   Our new community forums are up and running for you to register to, why not   reserve your account now and even begin posting for support. <a href="http://forum.resplace.net" target="_blank">The resplace forums</a> The <a href="http://blog.resplace.net/" target="_blank">resplace blog</a> has also been   setup and you can now read the blog and comment, please comment!
<?php
}

function someContent2($mod){
	?>
<div class="BoxContent" id="MODULE_LatestNews_CT"><strong>15/05/2007</strong> - Updated system   preview to ALPHA 2, changes include, only one rate per person per page, a   preview of our menu system and the new page handling system which didn't exist   before :). Internal changes include a new admin panel (preview will appear   sometime soon) and a DataBase system (a sub project) which is called ResDB, it   made all this possible and is an excellent PHP driven DataBase! </div>
<?php
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"Welcome");
$page->addF(someContent2,"Latest News");
$page->create();
?>








