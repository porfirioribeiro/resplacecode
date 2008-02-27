<?php
 header("Cache-Control: must-revalidate");

 $offset = 60 * 60 * 24 * 3;
 $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
 header($ExpStr);
 $timerbegin=microtime(true);
	ob_start("ob_gzhandler");

$path="../../data/";

include_once $path.'data.php';
$page=new Website("EMO - Online emoticon creation software");
$page->path($path);

$page->addMeta(array("name"=>"description","content"=>"Create emoticons online, its fast and free!"));
$page->addMeta(array("name"=>"online emote, online emoticon, EMO, emote, emoticon, emotion, emote maker, maker, create emotes. emoticon creator, emoticon monster, game maker, gamemaker, dean williams, tpvgames, dean, free, gml, game maker language, php, program, software, pc, games, utility, 100% free, freeware, emoticon maker, emoticon maker, emoticons, smileys, animated emoticons, moving emoticons, adult emoticons, sex emoticons, rude emoticons, yahoo emoticons, funny emoticons, smileys yahoo, text emoticons, sexy emoticons, 7.0 emoticons, yahoo smileys, hidden emoticons, messenger smileys, rude smileys, cool emoticons, my emoticons, emoticons animated, new emoticons, download smileys, playboy emoticons, winks and emoticons, alphabet emoticons, cute emoticons, emoticons rude, emoticons for messenger, emoticons and winks, emoticons sex, 3d smileys, yahoo hidden emoticons, forum emoticons, emotions and emoticons, funny animated emoticons, forum smileys, make emoticons, emoticons downloads, email smileys, im smileys, create emoticons, best smileys, messenger 7 emoticons, glitter emoticons, emoticons words, big emoticons, make your own emoticons, dancing emoticons, emoticons smileys, downloadable emoticons, emotions and smileys, porn smileys, star wars emoticons, talking emoticons, erotic emoticons, anime emoticons, trillian emoticons, animated adult emoticons, animated sex emoticons, emoticons smilies, love smileys, smileys and emotions, smileys animated, virus smileys, celebrity emoticons, cool smileys, smileys for yahoo, aim smileys, emoticons list, emoticons gifs, emoticons yahoo, all emoticons, cool animated emoticons, get emoticons, hello emoticons, secret emoticons, emoticons 7.5, windows messenger emoticons, 18 emoticons, ichat smileys, emoticons guide, emoticons text, emoticons virus, smileys com, emoticons and display pics, how to make emoticons, emoticons and smilies, dirty yahoo emoticons, big smileys, naruto emoticons, emoticons com, gaim smileys, get smileys, sexual emoticons, smiley emoticons, space emoticons pro, animated custom emoticons, online emoticons, emoticons for mac, large smileys, copy emoticons, newest emoticons, animated text emoticons, question mark emoticons, spongebob emoticons, good emoticons, porno emoticons, 3d animated emoticons, fun emoticons, video emoticons, cow emoticons, kopete emoticons, ragnarok emoticons, simpson emoticons, smileys gifs, hotmail emoticons"));
$page->addDefaults();
$page->pagetitle("EMO - EmoteMaker Online");

$page->writeHeader();
?><div align="center"><iframe width="700" src="include_emonline.php" allowtransparency="true" frameborder="0" scrolling="no" style="height:580px;"></iframe></div><?php 

$page->writeFooter();
?>
