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
	Helping us develop OpenWebMS will also help you and other OpenWebMS users, you can help us in many ways and you do not have to be a programmer to help! Here's what you could do for everyone:<br />
	<br />
		<b>General Users:</b>
		<ul>
			<li>Provide feedback on what you like/dislike and any suggestions for improvement or development you may have.</li>
			<li>Tell us how fast pages are loading for you, whether its satisfactory.</li>
			<li>Tell your friends about OpenWebMS, get them to send us their opinions!</li>
		</ul><br /><br />
		
		<b>Web Developers (PHP- HTML - JS):</b>
		<ul>
			<li>Help us track down and fix coding errors either on the rendered side or on the code base.</li>
			<li>Provide detailed analysis of loading speeds, browser compatibility and usability of the web site from both the developers and visitors point of view.</li>
			<li>Obtain the source code and assist with patches and additional features.</li>
			<li>Tell your friends about OpenWebMS, link to us from your web site! (please).</li>
		</ul><br /><br />
		
		<b>Web Developers / Graphics Artists (CSS + HTML):</b>
		<ul>
			<li>Create custom skins and templates to expand the OpenWebMS appearance choices.</li>
			<li>Create banners and art work so we can help get people to promote OpenWebMS</li>
		</ul><br /><br />
		
		We would be extremely grateful if anyone could help us with ANYTHING, you may speak to us by registering to our forums and posting a topic in the OpenWebMS section of the forums, THANKS TO EVERYONE!
	<?php
}
$page->add(internalHtml);
$page->add("SkinChanger",Module::LEFT);

//o.O a bug!! NOTE: look at output title?!?!
$page->addF(someContent,"Please help us to help you!");
$page->create();
?>








