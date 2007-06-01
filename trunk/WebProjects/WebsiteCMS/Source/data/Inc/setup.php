<?php
define("WebMS_ROOT_PATH",preg_replace("/\\\/","/",preg_replace("/data(\\\\|\/)Inc/","",dirname(__FILE__))));
define("WebMS_ROOT_URL",str_replace($_SERVER["DOCUMENT_ROOT"], "", WebMS_ROOT_PATH));
define("WebMS_DATA_PATH",WebMS_ROOT_PATH."data/");
define("WebMS_DATA_URL",WebMS_ROOT_URL."data/");
define("WebMS_FILES_PATH",WebMS_DATA_PATH."Files/");
define("WebMS_FILES_URL",WebMS_DATA_URL."Files/");
?>
