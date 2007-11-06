<?php

/*
#################################
## FUNCTIONS FOR FILES/FOLDERS ##
#################################
*/

//display a folder	
function ConvertSize($fs) 
	{ 
	if ($fs >= 1073741824) 
		  $fs = round($fs / 1073741824 * 100) / 100 . " GB"; 
	elseif ($fs >= 1048576) 
		  $fs = round($fs / 1048576 * 100) / 100 . " MB"; 
	else
		  $fs = round($fs / 1024 * 100) / 100 . " KB"; 
	
	return $fs; 
	}  
	
//get folder size:
function GetFolderSize($d,$chachecount=2,$folderloc)
		{
		
		$h = @opendir($d); 
		if($h==0)return 0; 
		
		//check if chache file exists...
		if (file_exists($folderloc."chache/".hash('md5', $d).'.tmp'))
			{
			//echo"*$d*";
			$read=explode("|",file_get_contents($folderloc."chache/".hash('md5', $d).'.tmp'));
			$sf=$read['3'];
			
			//is the chache too old now?
			$filedate=strtotime($read['2'].'-'.$read['1'].'-'.$read['0']);
			$difference=((strtotime(date("Y-n-d"))-$filedate)/(60 * 60 * 24));
			if ($difference > 1)
				{
				unlink($folderloc."chache/".hash('md5', $d).'.tmp');
				
				}
			}
			else
			{
			$chachecount+=1;
			//echo ' >'.$d.' - '.$chachecount.'< ';
			while ($f=readdir($h))
				{
				
				//do calculation
				 if ($chachecount>=30) { $void="STOP"; break; }
				 
				
				if ( $f!= "..")
					{ 
					$sf+=filesize($nd=$d."/".$f); 
					if($f!="." && is_dir($nd))
						{ 
						$returned=explode("|",GetFolderSize($nd,$chachecount,$folderloc));
						$chachecount=$returned[1];
						$sf+=$returned[0];
							
							//$sf+=$sp;
							echo $retirned[2];
						if ($returned[2]=="STOP")
							{
							$void="STOP";
							}
						
						} 
					}
				}

				
				
				if (!$void=="STOP")
				{ file_put_contents($folderloc."chache/".hash('md5', $d).'.tmp',date('j')."|".date('n')."|".date('Y')."|".$sf); }
				//echo'Put: '.$folderloc."chache/".hash('md5', $d).'.tmp - <b>'.$d.'</b><br>';
			} 
		closedir($h); 
		
		return $sf."|".$chachecount."|".$void; 
		}
		
?>