<?php
include dirname(__FILE__).'/config.php';
foreach ($WebMS as $key=>$value) {
	if (strpos($key,"Path")!==false){
    echo "Test ".$key." with the path ".$value.": ".((is_dir($value))?"Suceed!":"Fail!")."<br>";
  }
}
?>
