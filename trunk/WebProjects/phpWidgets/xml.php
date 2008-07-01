<?php
include "PWidgets/PWidgets.php";

function has_ns($tag,$ns){
	return preg_match('/^'.$ns.':.*$/i', $tag);
}
//Initialize the XML parser
$parser=xml_parser_create();


function array_keys_tolower($arr){
	$narr=array();
	foreach ($arr as $k => $v) {
		$narr[strtolower($k)]=$v;
	}
	return $narr;
}

//Function to use at the start of an element
global $ct_tag, $ct_count, $stack, $depth;
$stack=array();
$depth=0;
class Test{
	function reqClass($name){
		
	}
	function start($parser,$element_name,$attrs){
		global $stack, $depth;
		$attrs=array_keys_tolower($attrs);
		$w=null;
		$cn=explode(":",$element_name);
		if (count($cn)>1){
			$ns=$cn[0];
			$cn=strtolower($cn[1]);
			$dir=dirname(__FILE__).DIRECTORY_SEPARATOR."PWidgets".DIRECTORY_SEPARATOR.strtolower($ns).DIRECTORY_SEPARATOR;
			$fn=$cn.".php";
			$cls=$ns."_".$cn;
			$f1=$dir.$fn;
			$f2=$dir.$cn.DIRECTORY_SEPARATOR.$fn;
			if (!class_exists($cls)){
				if (is_file($f1)){
					include_once $f1;
				}else if (is_file($f2)){
					include_once $f2;
				}			
			}
			$w=new $cls($attrs);
			echo($w);
			echo get_class($w);
		}else{
			$attrsl="";
			foreach ($attrs as $k => $v) {
				$k=strtolower($k);
				$attrsl.=" $k=\"$v\"";
			}
			echo "<$element_name$attrsl>";		
		}
		$stack[count($stack)] = $w;
		$depth++;
	}
	
	//Function to use at the end of an element
	function stop($parser,$element_name){
		global $stack, $depth;
		$element_name=strtolower($element_name);
		$w=$stack[$depth-1];
		if (has_ns($element_name,"pw")){	
			if ($w!=null){
				echo $w->close();
			}			
		}else{
			echo "</$element_name>";
		}
		array_pop($stack);
	    $depth--;
	}
	
	function char($parser,$data){
		echo $data;
	}

}

$test= new Test();

Test::reqClass("pw::label");
//Specify element handler
xml_set_element_handler($parser,array($test,"start"),array($test,"stop"));
xml_set_default_handler($parser,array($test,"char"));




ob_start();

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Insert title here</title>
		<link rel="stylesheet" href="PWidgets/srv.php?css" type="text/css"/>
		<script type="text/javascript" src="PWidgets/srv.php?js"></script>
	</head>
	<body>
		<pw:panel onclick="alert(this)">
			<pw:textfield onclick="alert(this)" id="idname" label="Name:" value="porfirio" bounds="50,150,200,210" textpos="top" style="border: 1px solid black;text-align:center;"/>
			<pw:input onclick="alert(this)" type="button" value="Click" onmousedown="this.setText(${idname}.getValue())"></pw:input>
		</pw:panel>
		<br/>
	</body>
</html>

<?php

xml_parse($parser,ob_get_clean(),true);

$error=xml_get_error_code($parser);
if ($error){
	echo xml_error_string($error);
}
//tests


//Free the XML parser
xml_parser_free($parser);

?>