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
<b>WebMS </b>is a Website Management System that is being developed for webmasters that wish to setup a website that is fully HTML 4.01 complient yet easy to manage, update and adapt to their needs. WebMS fullfills those needs by offering a completely editable terrain in which to create a skin for a website, setup the output layout and then set individual or global content for the website. The system has some key features which are pointed out below:<br />
<br />
<ul>
	<li>Allow the use of skins and ability to switch skins in real time.</li>
    <li>Ability to create your own skins (including modifying the output layout).</li>
    <li>Apply third-party "modules" simply by dragging a file into a directory and calling it within a page.</li>
    <li>Create pages by calling "modules" or creating "content modules" with simple functions.</li>
    <li>Simple administration interface:</li>
    <li>Add new pages to the website with simple forms.</li>
    <li>Add new modules or edit existing modules.</li>
    <li>Create a website navigation menu with an advanced menu creator.</li>
    <li>Upload misc files to the server for use within the site.</li>
    <li>Simple to backup and/or move to another server.</li>
</ul>
Anyone wishing to alpha test WebMS can do so by requesting on our forums (new or old, prefer new).
<?php
}

$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"About WebMS");
$page->create();
?>








