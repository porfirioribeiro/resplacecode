<?php
include "PWidgets/PWidgets.php";

function has_ns($tag,$ns){
	return preg_match('/^'.$ns.':.*$/i', $tag);
}
//Initialize the XML parser
$parser=xml_parser_create();

//Function to use at the start of an element
function start($parser,$element_name,$element_attrs){
	if (has_ns($element_name,"pw")){
		switch($element_name){
			case "PW:NOTE":
				echo "-- Note --<br />";
				break;
			case "PW:TO":
				echo "To: ";
				break;
			case "PW:FROM":
				echo "From: ";
				break;
			case "PW:HEADING":
				echo "Heading: ";
				break;
			case "PW:BODY":
				echo "Message: ";
		}
	}else{
		$element_name=strtolower($element_name);
		$attrs="";
		foreach ($element_attrs as $k => $v) {
			$k=strtolower($k);
			$attrs.=" $k=\"$v\"";
		}
		echo "<$element_name$attrs>";
	}
}

//Function to use at the end of an element
function stop($parser,$element_name){
	$element_name=strtolower($element_name);
	if (has_ns($element_name,"pw")){
		echo "<br />";
	}else{
		echo "</$element_name>";
	}
}

//Function to use when finding character data
function char($parser,$data)
{
	echo $data;
}


//Specify element handler
xml_set_element_handler($parser,"start","stop");

//Specify data handler
xml_set_character_data_handler($parser,"char");



ob_start();

?>

<pw:note>
	<pw:to>Tove</pw:to>
	<pw:from>Jani</pw:from>
	<pw:heading>Reminder</pw:heading>
	<pw:body>
	Don't forget me <b style="color:red;" onclick="alert(this)">this</b> weekend!
	</pw:body>
</pw:note>
<b>nixe</b>
<?php

xml_parse($parser,ob_get_clean(),true);

//Free the XML parser
xml_parser_free($parser);

	?>