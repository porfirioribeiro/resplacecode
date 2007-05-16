<?php
 $Nav['main']['Home']['url'] = "index.html";
 $Nav['main']['About']['url'] = "about.html";
?>
<?php
 $Count = 1;
 foreach( $Nav['main'] as $Name => $Link )
 {
	echo "<span><a href=\"{$Link['url']}\">{$Name}</a></span>";
 	if( $Count != count( $Nav['main'] ) )
	{
		echo " | ";
	}
	$Count++;
 }
?>
