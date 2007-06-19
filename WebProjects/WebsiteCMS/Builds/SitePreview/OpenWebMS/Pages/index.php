<?php
$path="OpenWebMS/";
include_once $path.'WebMS.php';
$page=new WebMS($path,"resplace.net, the home to under construction :)");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	?>
Check out our <a href="http://blog.resplace.net/" target="_blank">Development Blog</a>. <br />
<br />
Welcome to <strong>resplace.net</strong> the new home for <strong>tpvgames.co.uk</strong>, please stay tuned whilst we finish the engine   for this web site. If you would like to access our existing projects then go to   our <a href="http://tpvgames.co.uk">old web site</a> for now.<br />
<br />
This web site   is using a ALPHA version of WebMS, a project were developing for other   webmasters to use, more information about this project can be found on the   "WebMS" page.  <br />
<br />
Please take a look at the skins we have made available, try collapsing and un collapsing the widgets and generally mess about, then go to our <a href="http://forum.resplace.net/" target="_blank">forums</a> and tell us what you think of the latest preview. If you are a web master and you would like to obtain a copy of WebMS please check out the &quot;Obtain Source&quot; section of this web site.
<?php
}

function someContent2($mod){
	?>
<div class="BoxContent" id="MODULE_LatestNews_CT">
<strong>18/06/2007</strong> - Updated system preview to ALPHA 3, many of the changes will not be noticeable... We have made lots of additions and fixes to the core of the system as well as added an error logger, IE6 browser fix's, more functionality to the admin panel and there has been some progress with skins (as you see).
<br>
<br><strong>15/05/2007</strong> - Updated system   preview to ALPHA 2, changes include, only one rate per person per page, a   preview of our menu system and the new page handling system which didn't exist   before :). Internal changes include a new admin panel (preview will appear   sometime soon) and a DataBase system (a sub project) which is called ResDB, it   made all this possible and is an excellent PHP driven DataBase! </div>
<?php
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"Welcome");
$page->addF(someContent2,"Latest News");
$page->create();
?>








