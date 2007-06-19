<?php
$path="OpenWebMS/";
include_once $path.'WebMS.php';
$page=new WebMS($path,"OpenWebMS - About");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website,webms,openwebms,website,management,system'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

function someContent($mod){
	?>
<b>WebMS </b>is a Web site Management System that is being developed for webmasters that wish to setup a web site that is fully HTML 4.01 compliant yet easy to manage, update and adapt to their needs. WebMS fulfills those needs by offering a completely editable terrain in which to create a skin for a web site, setup the output layout and then set individual or global content for the web site. The system has some key features which are pointed out below:<br />
<br />
<ul>
	<li>Allow the use of skins and ability to switch skins in real time.</li>
    <li>Ability to create your own skins (including modifying the output layout).</li>
    <li>Apply third-party "modules" simply by dragging a file into a directory and calling it within a page.</li>
    <li>Create pages by calling "modules" or creating "content modules" with simple functions.</li>
	<li>Built in IE5.5-IE6 compatibility (such as alpha PNG support).</li>
	<li>HTML 4.01 compliant code (except for IE compatibility mode)</li>
    <li>Simple administration interface:</li>
    <li>Add new pages to the web site with simple forms.</li>
    <li>Add new modules or edit existing modules.</li>
    <li>Create a web site navigation menu with an advanced menu creator.</li>
    <li>Upload misc files to the server for use within the site.</li>
    <li>Simple to backup and/or move to another server.</li>
</ul>
If you are a web master and you wish to obtain a copy of OpenWebMS then please goto the &quot;Obtain Source&quot; section of this website.
<?php
}

$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"About WebMS");
$page->create();
?>