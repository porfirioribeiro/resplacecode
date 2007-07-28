<?php

include_once "Template.php";
$fuck="aha i know";
$tpl=new Template('
	#{IIF:go,good,bad}
	<br>
	#{if:go}
		#{if:go}
			Aha
		#{else}
			Nah
		#{endif}
	#{else}
		Nah
	#{endif}
');

echo $tpl->parse(array("go"=>true));

?>