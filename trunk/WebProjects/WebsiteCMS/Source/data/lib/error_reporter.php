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
    $ret[] = "Date          : " . date("F j, Y, g:i:s a"); 
    $ret[] = "Server        : " . $_SERVER['SERVER_NAME']; 
    $ret[] = "Error No      : $errno"; 
    $ret[] = "On file       : $errfile"; 
    $ret[] = "On line       : $errline"; 
    $ret[] = "Error         : $errstr"; 
    $ret[] = "IP            : " . $_SERVER['REMOTE_ADDR']; 
    $ret[] = "Host          : " . gethostbyaddr($_SERVER['REMOTE_ADDR']); 
    $ret[] = "Method        : " . $_SERVER['REQUEST_METHOD']; 
    $ret[] = "Method Vars   :"; 
    foreach($_REQUEST as $key=>$value) 
      $ret[] = "           $key => $value"; 
	 
	if(function_exists('debug_backtrace')){
        //print "backtrace:\n";
		$ret[] = "Backtrace :"; 
        $backtrace = debug_backtrace();
        array_shift($backtrace);
        foreach($backtrace as $i=>$l){
            $ret[]= "[$i] in function <b>{$l['class']}{$l['type']}{$l['function']}</b>";
            if($l['file']) $ret[]= " in <b>{$l['file']}</b>";
            if($l['line']) $ret[]= " on line <b>{$l['line']}</b>";
            print "\n";
        }
    }

	  $ret[] = " ";
	  $ret[] = " ";
    $error = ""; 
    foreach($ret as $line) 
      $error .= "$line\n"; 
    
    //$to = "example@yahoo.com"; 
    //$from = "Error Catcher <errors@example.com>"; 
    //$headers = "To: $to\r\n"; 
    //$headers .= "From: $from\r\n"; 
    //mail($to, "Error on " . $_SERVER['SERVER_NAME'], $error, $headers); 
	
	//log the error instead of using mail :)
	if (file_exists("errors.log")) {
		$fh=fopen("errors.log",'w');
		fwrite($fh,$error);
		fclose($fh);
	}else{
		$fh=fopen("errors.log",'a');
		fwrite($fh,$error);
		fclose($fh);
	}
  } 
  
  $old_error_handler = set_error_handler("errorHandler");       
?> 