<?php
/**
* Error Reporter
* Logs generated errors
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 03-10-07
*/

error_reporting(E_ALL);

//setup error handling function
function errorHandler($errno, $errstr, $errfile, $errline, $othervars) {
	Global $WebMS;
	//echo "<br>$errno, $errstr, $errfile, $errline, $othervars<br>";
		//ob_end_clean();
	
	$OwnDir=preg_replace("/\\\/","/",dirname(__FILE__));
	
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
		$errstr2="{$splterrstr[1]}({$splterrstr[2]}){$splterrstr[3]}";
		//change $errstr to what we actually want...
		$errstr=$splterrstr[1]."(<a href='http://php.net/{$splterrstr[2]}' target='_blank'>{$splterrstr[2]}</a>){$splterrstr[3]}";
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
		//array fix
		if (is_array($value)) {
			$e="";
			foreach($value as $v) {
				$e.=$v;
			}
			$value=$e;
		}
		$report=$report."||".strip_tags($key)."||@||".strip_tags($value)."||";
	}
	
	$report=$report."}@ @{";
	
	//grab $Request values
	foreach($_REQUEST as $key=>$value) {
		$report=$report."||".strip_tags($key)."||@||".strip_tags($value)."||";
	}
	
	$report=$report."}@";
	
	//Find out largest error id
	$errordocs=GetFiles("{$OwnDir}/errors/");
	if (count($errordocs)) {
		rsort($errordocs,SORT_NUMERIC);
		//print_r($errordocs);
		$hf=explode('.',$errordocs[0]);
	  	$errcnt=(int)$hf[0]+1;
	} else {
		$errcnt=1;
	}
	
	//write the grouping data
	$uniquestring=preg_replace('/[^a-zA-Z0-9]/i', '_', $errstr2.$errline.$errfile);
	$group=grouping("{$OwnDir}/errors/log/errors.log",$errcnt,$uniquestring);
	if ($group==0) {
	  	//Write the error
	  	$fh=fopen("{$OwnDir}/errors/{$errcnt}.log",'a');
			fwrite($fh,$header.$report);
		fclose($fh);
	} else {
		$errcnt=$group;
	}
	
	//Show error if were in debug mode
	if (!isset($_SESSION['developer_mode']))
		$_SESSION['developer_mode']=false;
		
	if ($_SESSION['developer_mode']==true) {
		//$_SESSION['DevError']=$errcnt;
		//echo '<meta http-equiv="refresh" content="1;url='.url(array("Admin")).'">';
		//die('<b>An error has occured, you should be <a href="'.url(array("Admin")).'">redirected</a>.');
		//$page->addMeta(array('http-equiv' => 'refresh','content' => '3;'.url(array("Admin"))));
		//$page->addAlert("Page Redirection...","Ooops there was an error!<br>Redirecting you to the error...");
		
		//lose the data
		$handlers = ob_list_handlers();
		while ( ! empty($handlers) )    {
		    ob_end_clean();
		    $handlers = ob_list_handlers();
		}
		
		ob_start();
		
		//echo error
		//load the error
 		echo'<html>
 		<head>
 			<link rel="stylesheet" href="'.$WebMS["CoreUrl"].'Styles/ErrorReporter.css" type="text/css">
			<script src="'.$WebMS["JSUrl"].'prototype.js" type="text/javascript" language="JavaScript"></script>
		</head>
 		<body style="background-color:#F7EEBA">
 		<div class="ErrorO">
		<div class="Title"><div class="modefloat">Debug Mode</div>
		<b>An error has occurred!</b></div>
		<div class="Content">
		An error has been reported by the system, the details of this error and it\'s severity are shown below. A log of this error has also been made.
		<br><br>';
		ShowError("{$WebMS["IncPath"]}/errors/{$errcnt}.log",$errcnt);
		die('<br><i>The system was halted by Developer Mode to stop halting of the system please turn off Developer Mode (or fix the bug of course).</i></div></div></body></html>');
		
		$cont= ob_get_contents();
		ob_end_clean();
		
		echo $cont;
		die(' ');
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
						<div align="left" class="Error">
						<div style="float:right">
							<?php
								if (function_exists('url')) {
									?><a href="<?=url(array("Admin","ErrorLog","Print",$id)) ?>"><img src='<?=$WebMS['CoreUrl'] ?>Images/print.png' border='0' alt='[=]' title='Print this error' style="vertical-align:middle" \></a><a href="<?=url(array("Admin","ErrorLog","Print",$id)) ?>">Print</a> <a href="<?=url(array("Admin","ErrorLog",'Del',$id)); ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/button_cancel.png" alt="[x]" title="Delete this error" border="0" style="vertical-align:middle"></a><a href="<?=url(array("Admin","ErrorLog",'Del',$id)); ?>">Delete</a><?php
								} else {
									echo '(Functions Unavailable)';
								}
							?>
							</div>
						<b>
						<?php 
							$errid=substr($header[5],0,1);
							$errstr=substr($header[5],1,strlen($header[5]));
							echo "<img src='{$WebMS['CoreUrl']}Images/error{$errid}.png' border='0' alt='[{$errid}]' title='{$errstr}' style='padding-right:5px;vertical-align:middle' \>";
							echo"{$header['2']}</b><br><br>";
							?>
						<table>
					<?php
					$uniquestring=preg_replace('/[^a-zA-Z0-9]/i', '_', $header[2].$header[3].$header[4]);
					errorGenerate($header,$data,$uniquestring);
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

function errorGenerate($header,$data,$uniquestring) {
	global $WebMS;
	$OwnDir=preg_replace("/\\\/","/",dirname(__FILE__));
	
	//Figure out if this error occured once or more
	$sdate="Date";
	$exists=false;
	$dataz="";
	$file="{$OwnDir}/errors/log/errors.log";
	if (file_exists($file)) {
		$size=filesize($file);
		$fh=fopen($file,"r");
		$serstr=fread($fh,$size);
		fclose($fh);
		$serialized=unserialize($serstr);
		
		foreach ($serialized as $i) {
			if ($i[1]==$uniquestring) {
				$dataz=$i[2];
				if (count($dataz)) {
					$exists=true;
				}
				break;
			}
		}
	}
	
	if ($exists==true) {
		$sdate="First Date";
		?>
		<tr>
			<td valign="top"><b>Occurred</b></td>
	  		<td valign="top" width="25"><b>:</b></td>
			<td>
			<?php
				//remove duplicates
				echo (count($dataz)+1).' Times. ';
				?><a href="javascript:;" style="text-decoration: none;" onclick="$('REQUEST_DATES').toggle()">(More Details...)</a>
				<div style="display: none;padding-left:15px" id="REQUEST_DATES"><?php
				$dataz = array_flip(array_flip($dataz));
				
				foreach ($dataz as $i):
					echo $i.'<br>';
				endforeach;
			?>
				<br></div>
			</td>
	  	</tr>
		<?php
	}
	
	//output the error contents...
	$lang=array($sdate,"Server","Host","IP","Error","In File","Line","Method");
	
	$cnt=1;
		
	foreach ($lang as $t) {
		?>
			<tr>
				<td valign="top"><b><?=$t ?> </b></td>
		  		<td valign="top" width="25"><b>:</b></td>
		  		<?php
					//split out HREF tag
					//TODO fix weird URL bug here :s
			     preg_match("/(.*?)\(\<(.*?)\>\)(.*?)/",$data[$cnt],$strstg1);
			     if (count($strstg1)==4) {
						//there was a HREF there
						$strstg1[1]=preg_replace( "/([^\n\r \.,]{5})/i" , '$1<span style="font-size:1px"> </span>',$strstg1[1]);
						$strstg1[3]=preg_replace( "/([^\n\r \.,]{5})/i" , '$1<span style="font-size:1px"> </span>',$strstg1[3]);
						$strstg2=$strstg1[1].'<'.$strstg1[2].'>'.$strstg1[3];
						
					} else {
						$strstg2 =preg_replace( "/([^\n\r \.,]{5})/i" , '$1<span style="font-size:1px"> </span>', $data[$cnt] );
					}
          	?>
				<td><?=$strstg2 ?></td>
		  	</tr>
		<?php
		$cnt+=1;
	}

	$cnt2=0;
		
	preg_match_all("/\|\|(.*?)\|\|\@\|\|(.*?)\|\|/",$data[$cnt],$err2);
	?>
		<tr>
			<td><b>$WebMS </b></td>
		  	<td width="25"><b>:</b></td>
		  	<td><a href="javascript:;" id="AHREF1" style="text-decoration: none;" onclick="$('WEBMS_LOG_VAR').toggle()">(Click here for expand\contract)</a></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>
				<table style="display: none;" id="WEBMS_LOG_VAR">
	<?php
	
	foreach ($err2[0] as $t) {
		?>
					<tr>
				    	<td valign="top"><?=$err2[1][$cnt2] ?></td>
				    	<td valign="top" align="center" width="25"><b>=&gt;</b></td>

				    	<td valign="top" style="width:100%"><?=(($err2[2][$cnt2]=="") ? "<div style='color:red'>null</div>":preg_replace( "/([^\n\r \.,]{10})/i" , '$1<span style="font-size:1px"> </span>',$err2[2][$cnt2])) ?></td>
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
				<td><b>$_REQUEST </b></td>
			  	<td width="25"><b>:</b></td>
			  	<td><a href="javascript:;" id="AHREF2" style="text-decoration: none;" onclick="$('REQUEST_LOG_VAR').toggle()">(Click here for expand\contract)</a></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<table style="display: none;" id="REQUEST_LOG_VAR">
		<?php
		foreach ($err3[0] as $t) {
			?>
						<tr>
					    	<td valign="top"><?=$err3[1][$cnt3] ?></td>
					    	<td valign="top" align="center" width="25"><b>=&gt;</b></td>
					    	<td valign="top" style="width:100%"><?=(($err3[2][$cnt3]=="") ? "<div style='color:red'>null</div>":preg_replace( "/([^\n\r \.,]{10})/i" , '$1<span style="font-size:1px"> </span>',$err3[2][$cnt3])) ?></td>
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

function grouping($file,$fileno,$string) {
	$OwnDir=preg_replace("/\\\/","/",dirname(__FILE__));
	
	//unserialize...
	$filen=0;
	
	if (file_exists($file)) {
		$size=filesize($file);
		$fh=fopen($file,"r");
		$serstr=fread($fh,$size);
		fclose($fh);
	
		$fh=fopen($file,"w");
		$serialized=unserialize($serstr);
	
		//check if error already exists in array
		$exists=false;
		$cn=0-1;
		foreach ($serialized as $i) {
			$cn+=1;
			if (!file_exists("{$OwnDir}/errors/{$i[0]}.log")) {
				unset($serialized[$cn]);
			}
		}
		$cn=0-1;
		sort($serialized);
		foreach ($serialized as $i) {
			$cn+=1;
			if ($i[1]==$string) {
				$exists=true;
				$filen=$i[0];
				$idt=$cn;
			}
		}
	} else {
		$fh=fopen($file,"w");
		$serstr="";
		$exists=false;
	}
	if ($exists==true) {
		//again!!
		
		$serialized[$idt][2][]=date("d-m-y g:i a");
		
		//re-serialize...
		$serstr=serialize($serialized);
	} else {
		//first time
		$times=array();
		$serialized[]=array($fileno,$string,$times);
		//re-serialize...
		$serstr=serialize($serialized);
	}
	fwrite($fh,$serstr);
	fclose($fh);
	return $filen;
	
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
	        return array(4,"UNKNOWN ERROR");
	        break;
	}
}

$old_error_handler = set_error_handler("errorHandler"); 
?>