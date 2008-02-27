<?php
$path="../../data/";

include_once $path.'data.php';
$page=new Website("emO - EmoteMaker Online");
$page->path($path);

$page->addMeta(array("name"=>"description","content"=>"Simple Machines Forums (SMF) Gallery software"));
$page->addMeta(array("name"=>"keywords","content"=>"SMF, smf gallery, gallery system, simple, machines, forums"));
$page->addDefaults();
$page->pagetitle("SMF Gallery");

$page->writeHeader();
?>
 <div style="float:right"><img src="emoshot.png" alt="EMO - Product Shot" width="270" height="206"  /></div>
Welcome, EmoteMaker Online (or EMO) is a powerful web-based appication which tries to mimic the EmoteMaker application, it offers an easy click and position system that can be easyly used by children and adults. it currently has <strong>eyes, mouths &amp; faces</strong> but further in developement it should include the other sections like in EmoteMaker, it also includes a &quot;random emoticon&quot; button and even has a zoomer! Currently you cannot make signs, and you will definately find more features in the EmoteMaker program as apposed to this online system.<br />
 <br />
 EMO will take a little while to load at first, it should then load much faster upon reloads, please have patients with the loading time, there are alot of images to load!<br />
 <br />
 <a href="emonline.php">Launch EmoteMaker Online!</a>
 <br />
 <br />
 emO works was tested on this browsers:<br />
 <ul>
   <li>InternetExplorer 6\7-Beta1\2  - 100% ok </li>
   <li>Mozilla Firefox 1.5.0.1&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;- 100% ok </li>
   <li>Opera 9.00 Build 8212&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Works but i got some wheird   problems</li>
   <li>PSP (PlayStation Portable)&nbsp;&nbsp;&nbsp; - Browser (unknown of versions etc??)</li>
   <li>Konqueror&nbsp;                                &nbsp;&nbsp;                                                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Linux browser </li>
 </ul>
 It should work on any other browser with this specs:<br />
 <ul>
   <li>Html 4.0 </li>
   <li>JavaScript 1.2 or highter </li>
   <li>Css 2 or highter<br />
</li>
 </ul>
 <?php
 include "core/counterimg.php";
$page->writeFooter();
?>
