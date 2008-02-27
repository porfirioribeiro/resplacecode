<?php
 Header("Cache-Control: must-revalidate");

 $offset = 60 * 60 * 24 * 3;
 $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
 Header($ExpStr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1250">
		<meta name="generator" content="PSPad editor, www.pspad.com">
		<title>EM online</title>
		<link rel="stylesheet" href="core/style.css" type="text/css">
		<script src="core/include.js" type="text/javascript" language="JavaScript"></script>
		<script src="core/fl_inc.js" type="text/javascript" language="JavaScript"></script>
		<script src="core/msg.js" type="text/javascript" language="JavaScript"></script>
	    <style type="text/css">
<!--
.style1 {color: #135B86}
.style3 {color: #135B86; font-weight: bold; }
-->
        </style>
		<script language="javascript" type="text/javascript">
		var ccc=0
		</script>
</head>
  	<body onLoad="loaded();">
		<?php
		include 'core/f_e_m.php';
		include 'core/forms/custom.php';
		include 'core/forms/export.php';
		?>
		<table border="0" cellspacing="0" cellpadding="0" style="background-color:#ADDBF5; border-color:#9DC6EE; border-width:2px">
		  <tr>
		  	<td class="toolbar" colspan="3">
				<button onClick="doNew()" onMouseOver="setMsg(this,1)">New</button>
				<button onClick="doExport(this)" onMouseOver="setMsg(this,2)">Save</button>
			    <button onClick="" onMouseOver="setMsg(this,3)" disabled="disabled">Link's</button>			
			     <span class="style3">EmoteMaker Online V2 Release Candidate 1		    </span></td>
		  </tr>	
		  <tr>
			<td class="fields" style="border-color: #7C97F1;width:260px; border-style:solid;border-width:0px;  border-right-width:1px; border-bottom-width:1px; border-top-width:1px"><div style="height:500px;padding:5px;border:1px solid #7BBFF2">
			  <button type="button" class="btn" disabled="disabled" id="emfaces" onClick="showFaces()" onMouseOver="setMsg(this,4)">
				Faces			  </button>
			  <button type="button" class="btn" style="left:70px" id="emeyes" onClick="showEyes()" onMouseOver="setMsg(this,5)">
				Eyes			  </button>
			  <button type="button" class="btn" style="left:125px" id="ememouth" onClick="showMouth()" onMouseOver="setMsg(this,6)">
				Mouth			  </button>          
		      <?php include "core/include.php"; ?></div></td>
			<td class="fields" style="border-color: #7C97F1;width:210px; border-style:solid; border-width:0px;  border-right-width:1px; border-bottom-width:1px; border-top-width:1px">
				<div style="height:20px;padding:5px;border:1px solid #7BBFF2">
					<button onClick="setSize(20,20)" onMouseOver="setMsg(this,7)">20*20</button>
					<button onClick="setSize(40,40)" onMouseOver="setMsg(this,8)">40*40</button>
					<button onClick="$$('customForm').width.value=PageSizeW;$$('customForm').height.value=PageSizeH;showForm(this,'custom')" onMouseOver="setMsg(this,9)">Custom</button>
				</div>
				<table cellpadding="0" cellspacing="0" style="width:100%;height:150px;padding:5px;border:1px solid #7BBFF2;border-top-width:0px;background-color:#FFFFFF;text-align:center;vertical-align:middle">
					<tr>
						<td>
							<img src="emote.php" alt="Your emote" name="emote" id="emote" style="border:1px solid #0066FF">						</td>
					</tr>
				</table>
			  <script type="text/javascript" language="JavaScript">
			   document.getElementById("emote").src="emote.php?fi="+Fi+"&ei="+Ei+"&mi="+Mi
			  </script>
			  <div style="height:100px;text-align:center;border:1px solid #7BBFF2;border-top-width:0px;">
			    <div align="left" class="style1" style="height:30px"><u>Change object position:</u>			    </div>
				<table border="0" cellspacing="0" cellpadding="0" align="center">
				   <tr>
				   	   <td style="text-align:left"><span class="style1"  onMouseOver="setMsg(this,19)">Faces:</span></td>
					   <td><input type="checkbox" id="chfaces" checked="checked"  onMouseOver="setMsg(this,19)"> </td>
					   <td></td>
					   <td>
							<button class="barrow" onMouseDown="move.up()" onMouseOver="setMsg(this,11)">
								<img src="core/img/arr_up.gif" alt="Move Up" style="vertical-align:middle">							</button>					   </td>
					   <td></td>
					   <td class="barrow"></td>
					   <td>
							<button class="barrow" onMouseDown="speed.up()" onMouseOver="setMsg(this,16)">+</button>					   </td>
				   </tr>
				   <tr>
				   	   <td style="text-align:left"><span class="style1" onMouseOver="setMsg(this,20)">Eyes:</span></td>
					   <td><input type="checkbox" id="cheyes" checked="checked" onMouseOver="setMsg(this,20)"> </td>
					   <td>
						  	<button class="barrow" onMouseDown="move.left()" onMouseOver="setMsg(this,12)">
								<img src="core/img/arr_left.gif" alt="Move Left" style="vertical-align:middle">							</button>					   </td>
					   <td>
							<button class="barrow" onMouseDown="move.center()" onMouseOver="setMsg(this,13)">
								<img src="core/img/arr_mid.gif" alt="Center Image" style="vertical-align:middle">							</button>					   </td>
					   <td>
							<button class="barrow" onMouseDown="move.right()" onMouseOver="setMsg(this,14)">
								<img src="core/img/arr_right.gif" alt="Move Right" style="vertical-align:middle">							</button>					   </td>
					   <td class="barrow"></td>
					   <td style="color:#0033FF;border:1px solid #0066FF;width:18px;height:19px;" id="speedEl"><div align="center"  onMouseOver="setMsg(this,17)">1</div></td>
				   </tr>
				   <tr>
				   	   <td style="text-align:left"><span class="style1" onMouseOver="setMsg(this,21)">Mouths:</span></td>
					   <td><input type="checkbox" id="chmouths" checked="checked" onMouseOver="setMsg(this,21)"> </td>
					   <td></td>
					   <td>
							<button class="barrow" onMouseDown="move.down()" onMouseOver="setMsg(this,15)">
								<img src="core/img/arr_down.gif" alt="Move Down" style="vertical-align:middle">							</button>					   </td>
					   <td></td>
					   <td class="barrow"></td>
					   <td>
							<button class="barrow" onMouseDown="speed.down()" onMouseOver="setMsg(this,18)">-</button>					   </td>
				   </tr>
				</table>
				
		      </div>
			  <br>

			  <br>			</td>
			<td class="fields" style="border-color: #7C97F1;width:192px;  border-style:solid; border-width:0px;  border-bottom-width:1px; border-top-width:1px">
				<div style="height:20px;padding:5px;border:1px solid #7BBFF2">
				<button onClick="doRandom()"  onMouseOver="setMsg(this,10)">
					Random				</button>				
				</div>

				<div style="background:#FFFFFF; width:190px"><img style="border:1px solid #7BBFF2;border-top-width:0px;" id="zoom" name="zoom" src="emote.php" alt="Zoom" width="190" height="190"></div>
<script type="text/javascript" language="JavaScript">
			   document.getElementById("zoom").src="emote.php?fi="+Fi+"&ei="+Ei+"&mi="+Mi
			  </script>			</td>
		  </tr>
		  <tr>
		  	<td colspan="3" class="statusbar" style="border-width:0px">
				<?php include "core/counterimg.php";?>
				<span class="style1" id="messages" style="padding-left:10px">Welcome EmoteMaker Online V2</span>			</td>
		  </tr>		
		</table>
	</body>
</html>
