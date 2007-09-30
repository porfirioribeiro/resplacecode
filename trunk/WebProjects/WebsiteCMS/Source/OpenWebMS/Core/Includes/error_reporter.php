<?php
/**
* Error Reporter
* Logs generated errors
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 23-09-07
*/

error_reporting(E_ALL);

//setup error handling function
function errorHandler($errno, $errstr, $errfile, $errline, $othervars) {
	Global $WebMS;
	
	//Grab error code
	list($errno) = func_get_args();
	//Grab date/time
	$date=date("d-m-y g:i a");
	//Grab error severity array
	$severity=errorSeverity($errno);
	
	//format errstr for header
	//split it
	preg_match("/(.*?)\[(.*?)\](.*?)/",strip_tags($errstr),$splterrstr);
	//make sure there are 4 values returned (matched)
	if (count($splterrstr)==4) {
		$splterrstr[2]=strip_tags($splterrstr[2]);
		$errstr2=$splterrstr[1]."(".$splterrstr[2].")".$splterrstr[3];
		//change $errstr to what we actually want...
		$errstr=$splterrstr[1]."(<a href='http://php.net/".$splterrstr[2]."' target='_blank'>".$splterrstr[2]."</a>)".$splterrstr[3];
	} else {
		$errstr2=$errstr;
	}
	
	//Create the header
	$header="]@[{$errstr2}]@[{$errline}]@[{$errfile}]@[{$severity[0]}{$severity[1]}]@[{$date}]} \n";
	$headerlength=str_pad(strlen($header)+6,3,"0",STR_PAD_LEFT);
	$header="H{[".$headerlength.$header;
	
	//Create the error report
	$report="@{{$date}}@ @{{$_SERVER['SERVER_NAME']}}@ @{".gethostbyaddr($_SERVER['REMOTE_ADDR'])."}@ @{{$_SERVER['REMOTE_ADDR']}}@ @{{$errstr}}@ @{{$errfile}}@ @{{$errline}}@ @{{$_SERVER['REQUEST_METHOD']}}@ @{";
	
	//grab $WebMS values
	foreach($WebMS as $key=>$value) {
		$report=$report."||".strip_tags($key)."||@||".strip_tags($value)."||";
	}
	
	$report=$report."}@ @{";
	
	//grab $Request values
	foreach($_REQUEST as $key=>$value) {
		$report=$report."||".strip_tags($key)."||@||".strip_tags($value)."||";
	}
	
	$report=$report."}@";
	
	//Find out how many error reports exist
	$errordocs=GetFiles(dirname(__FILE__)."\errors\\");
  	$errcnt=count($errordocs)+1;
  	
  	//Write the error
  	$fh=fopen(dirname(__FILE__)."\errors\\".$errcnt.".log",'a');
		fwrite($fh,$header.$report);
	fclose($fh);
	
	//Show error if were in debug mode
	if (!isset($_SESSION['developer_mode']))
		$_SESSION['developer_mode']=false;
		
	if ($_SESSION['developer_mode']==true) {
		echo'<div align="center"><b>Developer Mode:</b><br>
		<i>There was an error doc!</i></div><br>
		<div align="left">
		An error has been reported by the system, the details of this error and it\'s severity are shown below. A log of this error has also been made, the error logging facility offers more advanced features.
		</div><br>';
		ShowError(dirname(__FILE__)."\errors\\".$errcnt.".log",$errcnt);
		die('<br><i>The system was halted by the error message, to stop halting of the system please turn off developer mode (or fix the bug of course).</i>');
	}
	
	
	
}

function ShowError($file,$id) {
	global $WebMS;
	$fh=fopen($file,'a+');
		if (!filesize($file)==0) {
			$filedata=fread($fh,filesize($file));
			$errlength=$filedata;
			
			//chop and grab the header infirmation
			if (preg_match("/\H\{\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\}/",$filedata,$header)) {
				//header was read successfully
				//echo Header title
				
				//grab data!
				if (preg_match("/\@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@\ \@\{(.*?)\}\@/",$filedata,$data)) {
					?>
						<div align="center">
						<div align="left" style="overflow:scroll;height:440px;width:97%;background-color:white; border: 1px solid black; padding:5px; font-size:14px;">
						<?="<div align='center'><b>" ?> 
						<?php 
							$errid=substr($header[5],0,1);
							$errstr=substr($header[5],1,strlen($header[5]));
							echo "<img src='{$WebMS['CoreUrl']}Images/error{$errid}.png' border='0' alt='[{$errid}]' title='{$errstr}' style='padding-right:5px;vertical-align:center' \>";
							echo"{$header['2']}</b></div><br>";
							?>
						<table>
					<?php
					errorGenerate($header,$data);
					?>
						</table>
						</div>
						</div>
					<?php
				}
			}
				
		} else {
			$filedata="No Errors Logged.";
		}
		fclose($fh);
		
		
		
}

function errorGenerate($header,$data) {
	global $WebMS;
	//output the error contents...
	$lang=array("Date","Server","Host","IP","Error","In File","Line","Method");
	
	$cnt=1;
		
	foreach ($lang as $t) {
		?>
			<tr>
				<td><b><?=$t ?> </b></td>
		  		<td width="25"><b>:</b></td>
				<td><?=$data[$cnt] ?></td>
		  	</tr>
		<?php
		$cnt+=1;
	}
	
	$cnt2=0;
		
	preg_match_all("/\|\|(.*?)\|\|\@\|\|(.*?)\|\|/",$data[$cnt],$err2);
	?>
		<tr>
			<td><b>$WebMS: </b></td>
		  	<td width="25"><b>:</b></td>
		  	<td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<table>
	<?php
	
	foreach ($err2[0] as $t) {
		?>
					<tr>
				    	<td ><?=$err2[1][$cnt2] ?></td>
				    	<td align="center" width="25"><b>=&gt;</b></td>
				    	<td ><?=(($err2[2][$cnt2]=="") ? "<div style='color:red'>null</div>":$err2[2][$cnt2]) ?></td>
					</tr>
		<?php
		$cnt2+=1;
	}
	?>
				</table>
				</td>
			</tr>
		<?php
		$cnt3=0;
		preg_match_all("/\|\|(.*?)\|\|\@\|\|(.*?)\|\|/",$data[$cnt+1],$err3);
		?>
			<tr>
				<td><b>$_REQUEST: </b></td>
			  	<td width="25"><b>:</b></td>
			  	<td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<table>
		<?php
		foreach ($err3[0] as $t) {
			?>
						<tr>
					    	<td ><?=$err3[1][$cnt3] ?></td>
					    	<td align="center" width="25"><b>=&gt;</b></td>
					    	<td ><?=(($err3[2][$cnt3]=="") ? "<div style='color:red'>null</div>":$err3[2][$cnt3]) ?></td>
						</tr>
			<?php
			$cnt3+=1;
		}
		?>
					</table>
				</td>
			</tr>
	<?php
	
}

function errorSeverity($errno) {
	switch ($errno) {
	    case E_ERROR:
	        return array(1,"ERROR");
	        break;
	        
	    case E_WARNING:
	        return array(2,"WARNING");
	        break;
	        
	    case E_PARSE:
	        return array(1,"PARSING ERROR");
	        break;
	        
	    case E_NOTICE:
	        return array(3,"NOTICE");
	        break;
	        
	    case E_CORE_ERROR:
	        return array(1,"CODE ERROR");
	        break;
		
	    case E_CORE_WARNING:
	        return array(1,"CORE WARNING");
	        break;
	        
	    case E_COMPILE_ERROR:
	        return array(1,"COMPILE ERROR");
	        break;
	        
	    case E_COMPILE_WARNING:
	        return array(2,"COMPILE WARNING");
	        break;
	        
		case E_USER_ERROR:
	        return array(1,"USER ERROR");
	        break;
	
	    case E_USER_WARNING:
	        return array(2,"USER WARNING");
	        break;
	
	    case E_USER_NOTICE:
	        return array(3,"USER NOTICE");
	        break;
	        
	    case E_RECOVERABLE_ERROR:
	        return array(3,"RECOVERABLE ERROR");
	        break;
	
	    default:
	        return array(1,"UNKNOWN ERROR");
	        break;
	}
}

$old_error_handler = set_error_handler("errorHandler"); 
?>