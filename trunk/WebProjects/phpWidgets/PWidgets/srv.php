<?php

session_start();

if (isset($_GET["css"])){
	$styles=$_SESSION['PW_CSS_INC'];
	foreach ($styles as $style) {
		if (is_file($style)){
			include_once($style);
		}
	}	
} else if (isset($_GET["js"])){
	$scripts=$_SESSION['PW_JS_INC'];
	foreach ($scripts as $script) {
		if (is_file($script)){
			include_once($script);
		}
	}	
}




?>