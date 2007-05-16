<?php
include_once $path.'site.php';
$page=new WebMS($path,"Main Site");
$page->addMeta(array('name' => 'keywords','content' => 'resplace,cms,website'));
$page->addDefaults();
$page->add("Menu");
$page->add("PageRate");

class internalHtml extends Module {
	function internalHtml($page){
		$this->title="Making settings DB";
		parent::Module($page);
	}
	function content(){
		?>
		Setting up default settings... Should be done :)		
		<?php
	}
}

$db= new ADB($path."db/settings.db");
				$somemap=$db->getMap("SiteTitle");//you only need maps for organize the db
				$somemap->put("set","My Website");
				$somemap->put("about","Default page title is none is specified.");
				
				$somemap=$db->getMap("SiteDesc");
				$somemap->put("set","This is my website and it's using the resplace.net Website Management System (WebMS).");
				$somemap->put("about","Default page description is none is specified.");
				$db->close();
				
				$somemap=$db->getMap("SiteKeywords");
				$somemap->put("set","WebMS,website");
				$somemap->put("about","Default page keywords is none is specified.");
				$db->close();
				
				$somemap=$db->getMap("ThemesPath");
				$somemap->put("set","Themes/");
				$somemap->put("about","Path to the themes directory, always relative to the data/ directory.");
				$db->close();
				
				$somemap=$db->getMap("ModulesPath");
				$somemap->put("set","Modules/");
				$somemap->put("about","Path to the modules directory, always relative to the data/ directory.");
				$db->close();
				$somemap=$db->getMap("FunctionsPath");
				$somemap->put("set","Functions/");
				$somemap->put("about","Path to the functions directory, always relative to the data/ directory.");
				$db->close();
				
				$somemap=$db->getMap("LibPath");
				$somemap->put("set","lib/");
				$somemap->put("about","Path to the lib directory, always relative to the data/ directory.");
				$db->close();
				
				$somemap=$db->getMap("StylesPath");
				$somemap->put("set","Style/");
				$somemap->put("about","Path to the styles directory, always relative to the data/ directory.");
				$db->close();
				
				$somemap=$db->getMap("DefaultSkin");
				$somemap->put("set","Rigid/Blue");
				$somemap->put("about","Path to the default skin, example Rigid/Blue (no final /!!)");
				$db->close();

$page->add(internalHtml);
$page->create();
?>

