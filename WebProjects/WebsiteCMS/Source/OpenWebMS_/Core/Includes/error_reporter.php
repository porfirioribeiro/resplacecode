<?php 
//*************************************************************** 
//** title  : Error mailing logging facility 
//** 
//** file   : error.php 
//** 
//** story  : When your site is live you never want people to see 
//**          php errors no matter what. Sometimes this is possible 
//**          though because your host might upgrade PHP or MySQL 
//**          or something else can go bad. The usual advice given 
//**          is to have error_reporting(0) on the live sites. But 
//**          then you will never get to know that an error is there. 
//**          
//**          I use a different approach here. I set error reporting 
//**          to E_ALL (that is report all errors) but I have 
//**          over-ridden the error handler to construct a nice 
//**          error report and mail it to me. The application 
//**          continues, and if the error was not major, the user 
//**          will never get to notice anything. You on the other 
//**          side though will know that something has gone wrong 
//**          and you'll run to fix it. 
//** 
//**          Customize the $to and $from variables, include this 
//**          file and enjoy. 
//**          
//**          You are going to get something like this: 
//**          
//**          Date    : December 3, 2005, 3:55:12 am 
//**          Server  : example.com 
//**          Error No: 8 
//**          On file : /home/example/public_html/temp/error.php 
//**          On line : 35 
//**          Error   : Use of undefined constant bar - assumed 'bar' 
//**          IP      : 87.203.242.37 
//**          Host    : athedsl-12355.otenet.gr 
//**          Method  : GET 
//**          Vars    : 
//**                    name => test 
//**                    age = 55 
//** 
//** 
//** author : Ioannis Cherouvim 
//** web    : http://cherouvim.com 
//** date   : 2005-12-03 
//*************************************************************** 
  
  
  error_reporting(E_ALL); 
  
  function errorHandler($errno, $errstr, $errfile, $errline, $othervars) { 
  	global $WebMS;
	//wordwrap(str_replace("\\","\ ",$errfile),50,"&hellip;\n              : ",false)
	$errlen="";
	$errlen=strlen($errstr);
	if (strlen($errlen)==1) {
		$errlen="0".$errlen;
	}
	
    $ret[] = $errlen.$errstr."
[[" . date("F j, Y, g:i:s a")."]]
[[{$_SERVER['SERVER_NAME']}]]
[[" . gethostbyaddr($_SERVER['REMOTE_ADDR']). "]]
[[{$_SERVER['REMOTE_ADDR']}]]
[[$errno]]
[[$errfile]]
[[$errstr]]
[[$errline]]
[[{$_SERVER['REQUEST_METHOD']}]]"; 
    $ret[] = '[['; 
    foreach($_REQUEST as $key=>$value) 
      $ret[] = "||$key||=>||$value||";
    $ret[]="]]\n";
    $ret[] = '[['; 
    foreach($WebMS as $key=>$value) 
      $ret[] = "||$key||=>||$value||"; 
	$ret[]="]]";
	//if(function_exists('debug_backtrace')){
        //print "backtrace:\n";
		//$ret[] = "Backtrace :"; 
        //$backtrace = debug_backtrace();
        //array_shift($backtrace);
        //foreach($backtrace as $i=>$l){
        //    $ret[]= "[$i] in function <b>{$l['class']}{$l['type']}{$l['function']}</b>";
        //    if($l['file']) $ret[]= " in <b>{$l['file']}</b>";
        //    if($l['line']) $ret[]= " on line <b>{$l['line']}</b>";
        //    print "\n";
        //}
    //}
    $error = ""; 
    foreach($ret as $line) 
      $error .= "$line"; 
    
    //$to = "example@yahoo.com"; 
    //$from = "Error Catcher <errors@example.com>"; 
    //$headers = "To: $to\r\n"; 
    //$headers .= "From: $from\r\n"; 
    //mail($to, "Error on " . $_SERVER['SERVER_NAME'], $error, $headers); 
	
	//log the error instead of using mail :)
	
      	$errordocs=GetFiles(dirname(__FILE__)."\errors\\");
  		$errordoccount=count($errordocs);
  		
	
		$fh=fopen(dirname(__FILE__)."\errors\\".$errordoccount.".log",'a');
		fwrite($fh,$error);
		fclose($fh);
		
		//get hash of error file
		//$errorhash=md5_file(dirname(__FILE__)."\errors\\".$errordoccount.".log");
		//
		//foreach ($errordocs as $doc) {
		//	if ($errorhash==md5_file(dirname(__FILE__)."\errors\\".$doc)) {
		//		//delete our log, it exists already!
		//		unlink(dirname(__FILE__)."\errors\\".$errordoccount.".log");
		//	}
		//}
		
		if (!isset($_SESSION['developer_mode']))
			$_SESSION['developer_mode']=false;
		
		if ($_SESSION['developer_mode']==true) {
		echo'<div align="center"><b>Developer Mode: CODE ERROR!</b><br>
		<i>Fix the error or report it and disable developer mode to view this page.</i></div><br><br>
		';
		ShowError(dirname(__FILE__)."\errors\\".$errordoccount.".log");
		die('<br><br><i>This error has been logged.</i>');
		}
  } 
  
  $old_error_handler = set_error_handler("errorHandler"); 
  
	function ShowError($file) {
		$fh=fopen($file,'a+');
		if (!filesize($file)==0) {
			$filedata=fread($fh,filesize($file));
		} else {
			$filedata="No Errors Logged.";
		}
		fclose($fh);
		
		//chop and style the error report :)
		
		//date
		preg_match_all("/\[\[(.*?)\]\]/",$filedata,$err);
		$lang=array("Date","Server","Host","IP","Error No","In File","Error","At Line","Method");
		
		?>
		<div align="left" style="background-color:white; border: 1px solid black; padding:5px; font-family:\'Lucida Console\', Times, serif; font-size:14px;">

		<table>
		<?php
		$cnt=0;
		
		foreach ($lang as $t) {
			?>
				<tr>
					<td><b><?=$t ?> </b></td>
			  		<td width="25"><b>:</b></td>
					<td><?=$err[1][$cnt] ?></td>
			  	</tr>
			<?php
			$cnt+=1;
		}
		$cnt2=0;
		
		preg_match_all("/\|\|(.*?)\|\|\=\>\|\|(.*?)\|\|/",$err[1][$cnt],$err2);
		?>
			<tr>
				<td><b>$REQUEST </b></td>
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
		preg_match_all("/\|\|(.*?)\|\|\=\>\|\|(.*?)\|\|/",$err[1][$cnt+1],$err3);
		?>
			<tr>
				<td><b>$WebMS </b></td>
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
		</table>
		</div>
		<?php
	}
?>