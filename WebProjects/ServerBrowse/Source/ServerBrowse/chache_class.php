<?php
class FolderChache{
	var $chachecount;
	
	function GetFolderSize($d,$chachecount,$folderloc)
			{
			$this->chachecount=$chachecount;
			$h = @opendir($d); 
			if($h==0)return 0; 
			
			//check if chache file exists...
			if (file_exists($folderloc."chache/".hash('md5', $d).'.tmp'))
				{
				//echo"*$d*";
				$read=explode("|",file_get_contents($folderloc."chache/".hash('md5', $d).'.tmp'));
				$sf=$read['3'];
				}
				else
				{
				while ($f=readdir($h))
					{
					
					//do calculation
					 if ($chachecount>=30) { $void=1; break; }
					
					if ( $f!= "..")
						{ 
						$sf+=filesize($nd=$d."/".$f); 
						if($f!="." && is_dir($nd))
							{ 
							$sp=$this->GetFolderSize($nd,$chachecount,$folderloc);
							$sf+=$sp;
							echo $sp;
							if (strstr($sf,"*")==false) {} else
								{
								$void=1;
								}
							
							} 
						}
					}
	
					$chachecount+=1;
					
					if (!$void==1)
					{ file_put_contents($folderloc."chache/".hash('md5', $d).'.tmp',date('j')."|".date('n')."|".date('Y')."|".$sf); }
					//echo'Put: '.$folderloc."chache/".hash('md5', $d).'.tmp - <b>'.$d.'</b><br>';
				} 
			closedir($h); 
			
			return ConvertSize($sf)."|".$chachecount."|".$void; 
			}
			
		}
?>