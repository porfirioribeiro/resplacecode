<?php
session_start();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><?php
//include everything thats required, settings files FIRST!
$folderloc="ServerBrowse/";
include($folderloc."config/main_config.php");
include($folderloc."mime_class.php");
include($folderloc."functions.php");

include($folderloc."config/mime_types.php");

//read/write a session for icon size preference
if (isset($_GET['iconsize']))
	{ $_SESSION['ServBrowse_iconsize']=(int)$_GET['iconsize']; }

if (isset($_SESSION['ServBrowse_iconsize']))
	{ $iconsize=(int)$_SESSION['ServBrowse_iconsize']; }
	
//sort out view
if (isset($_GET['view']))
	{ $_SESSION['ServBrowse_view']=(int)$_GET['view']; }

if (isset($_SESSION['ServBrowse_view']))
	{ 
	switch($_SESSION['ServBrowse_view'])
		{
		case 1:
			$view="list";
		break;
		case 2:
			$view="tiles";
		break;
		}
	 }

//create arrays
$ignore=explode(",",$ignore);
$ignorefiletype=explode(",",$ignorefiletype);

//are we active?
if ($active==false)
	{ die('Closed.'); }

$browse=str_replace("..","[UHHAA]",str_replace(".SLSH.","/",$_GET['browse']));

//get each directory into an array.
$exploring=explode("/",$browse);

//make sure were not accessing a hidden directory (naughty naughty)
foreach ($exploring as $key => $val)
	{
	if (in_array(strtolower($val),$ignore) && !$val=="")
		{
		$browse="./";
		$_GET['browse']="./";
		break;
		}
	}

// sort out the message we see on the page.
if (!isset($_GET['browse']) || $browse=="./")
	{ $directoryListing = "Browsing: / <a href='".$_SERVER['PHP_SELF']."'>(ROOT)</a> /"; }
	else
	{ 
	$it="";
	$count=0;
	
	foreach ($exploring as $i)
		{
		$count+=1;
		if (!$i=="")
			{
			$it=$it.$i.'.SLSH.';
			$tag=$tag.'<a href="'.$_SERVER['PHP_SELF'].'?browse='.$it.'">'.$i.'</a> &frasl; ';
			}
		if ($count==10)
			{
			$tag=$tag.'<br>';
			$count=0;
			}
		}
	$directoryListing = "Browsing: / <a href='".$_SERVER['PHP_SELF']."'>(ROOT)</a> / ".$tag;
	
	}
	
$noDir = "no files or folders in this directory";
$presentation = "<div align='center' style='width:500px;'><b>Powered by <a href='http://resplace.net/?Projects.ServerBrowse' title='Probably the best server file browser in development'>ServerBrowse</a></b><br>Copyright © resplace.net
</div>";
//<div style='float:right'><img src='".$folderloc."powered.png' border='0' alt='Powered by ServerBrowse'/></div>
$biContinue = true;
			
?>
<html>
	<head>
		<title>Server Browser</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	    <link href="<?=$folderloc; ?>config/style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<script language="javascript" type="text/javascript">
			//function to display or hide a given element
			
			function showHideItems(myItem, myItem2){
			
			//this is the ID of the hidden item
			var myItem = document.getElementById(myItem);
			var myItem2 = document.getElementById(myItem2);
			
			
			//this is the ID of the plus/minus button image
			//var myButton = document.getElementById(myButton);
			
			
			if (myItem.style.display != "none") {
			//items are currently displayed, so hide them
			
			myItem.style.display = "none";
			myItem2.style.display = "block";
			
			//swapImage(myButton,"plus");
			}
			else {
			
			//items are currently hidden, so display them
			myItem.style.display = "block";
			myItem2.style.display = "none";
			
			//swapImage(myButton,"minus");
			}
			}
		</script>
 
		<div align="center">
			<a href="<?=$_SERVER['PHP_SELF']; ?>"><img src="<?=$folderloc; ?>logo_heading.png" alt="Return to root directory." border="0"></a>		
			<div align="left" style="width:390px">
				<div id="close" align="left" style="width:100px; font-size:13px">
					<a href="#" onClick="showHideItems('close','open');">View settings</a>
				</div>
				
				<div id="open" align="left" style=" font-size:13px; display:none">
					<a href="#" onClick="showHideItems('open','close');">View settings</a>
					<br><br>
					<div class="viewpane">
						<b>View:</b><br>
						<?php 
						if (isset($_GET['browse'])) {
						?>
						<a href="?view=1&amp;browse=<?=$_GET['browse']; ?>">List</a> - <a href="?view=2&amp;browse=<?=$_GET['browse']; ?>">Tiles</a><br>
						<br>
						<b>Icon Size:</b> <a href="?iconsize=16&amp;browse=<?=$_GET['browse']; ?>">16</a> - <a href="?iconsize=22&amp;browse=<?=$_GET['browse'] ?>">22</a> - <a href="?iconsize=32&amp;browse=<?=$_GET['browse'] ?>">32</a> - <a href="?iconsize=48&amp;browse=<?=$_GET['browse'] ?>">48</a> - <a href="?iconsize=64&amp;browse=<?=$_GET['browse'] ?>">64</a> - <a href="?iconsize=96&amp;browse=<?=$_GET['browse'] ?>">96</a> - <a href="?iconsize=128&amp;browse=<?=$_GET['browse'] ?>">128</a>
						<?php
						}
						else
						{
						?>
						<a href="?view=1">List</a> - <a href="?view=2">Tiles</a><br>
						<br>
						<b>Icon Size:</b> <a href="?iconsize=16">16</a> - <a href="?iconsize=22">22</a> - <a href="?iconsize=32">32</a> - <a href="?iconsize=48">48</a> - <a href="?iconsize=64">64</a> - <a href="?iconsize=96">96</a> - <a href="?iconsize=128">128</a>
						<?php } ?>
					</div>
				</div>
			</div>
			<br><br>
			
			<div align="left" style="width:550px">
				<a href="<?php echo str_replace('.SLSH.','/',$browse); ?>"><img src="<?=$folderloc; ?>arrow.png" alt='Open this directory' style="vertical-align:middle" border="0"></a>
				&nbsp;<? echo $directoryListing; ?>	
			</div>
		</div>
		
			<?php 
			if ($browse=="/")
				{ $browse="[UHAAA]"; }
			
			if (isset($_GET['browse']))
				{ $rep=opendir($browse); }
				else
				{ $rep=opendir("."); }
			
			$processed = false;
			
			//place directorys or files
			include($folderloc."revised_views.php");
			?>

		<br>

		<div align="center">
			<?=$presentation?> 
		</div>
	</body>
</html>
