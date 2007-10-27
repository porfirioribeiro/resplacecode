<?php
/**
* Error Log Reader
* Allows user to read/remove errors
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright ? 2007 ResPlace Team
* @lastedit 03-10-07
*/

class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content() {
		global $WebMS, $path;
		
	$exists=false;
	$dataz="";
	$file="{$WebMS['IncPath']}errors/log/errors.log";
	if (file_exists($file)) {
		$size=filesize($file);
		$fh=fopen($file,"r");
		$serstr=fread($fh,$size);
		fclose($fh);
		$serialized=unserialize($serstr);
		//remove bad lines
		if (count($serialized)) {
			$cn=0;
			foreach ($serialized as $i) {
				$cn+=1;
				if (!file_exists("{$WebMS['IncPath']}errors/{$i[0]}.log")) {
					unset($serialized[$cn]);
				}
			}
		}
	}
		
		
		if (isset($_GET['del'])) {
			$del=(int)$_GET['del'];
			if (file_exists("{$WebMS["IncPath"]}errors/{$del}.log")) {
				unlink("{$WebMS["IncPath"]}errors/{$del}.log");
			}
		}
		
		if (isset($_GET['err'])) {
			//Load error viewer
			$err=(int)$_GET['err'];
			
			ShowError("{$WebMS["IncPath"]}errors/{$err}.log",$err);
		} else {
			//load list of errors
			$logpath="{$WebMS['IncPath']}errors/";
			$efiles=GetFiles($logpath);
			unset($efiles["errors.log"]);
			sort($efiles);
			
			//read sort
			$sort=0;
			if (isset($_GET['sort']))
			$sort=(int)$_GET['sort'];
			if ($sort==1) {
				asort($efiles,SORT_NUMERIC);
			} else {
				arsort($efiles,SORT_NUMERIC);
			}
			
			//check there are some errors
			if (count($efiles)) {
				//How many errors per page?
				$errperpage=10;
				
				
				if (isset($_GET['errpage'])) {
					$errpage=(int)$_GET['errpage'];
				} else {
					$errpage=1;
				}
				
				//Begin the table
				MakeHeader($errpage, $errperpage, $efiles);
				
				//run through each error file
				$foreachcnt=0;
				$datarray=array();
				foreach ($efiles as $file) {
					$foreachcnt+=1;
					//start/end at
					if ($errpage==1) {
						$estart=1;
						$eend=10;
					} else {
						$estart=$errperpage*($errpage-1)+($errpage-1);
						$eend=$errperpage*$errpage+($errpage-1);
					}

					if ($foreachcnt>=$estart && $foreachcnt<=$eend) {
						$fh=fopen($logpath.$file,'a+');
						if (!filesize($logpath.$file)==0) {
							//load out the header only (man was easy)
							$str1=fread($fh,3);
							$headerlength=fread($fh,3);
							$header=$str1.$headerlength.fread($fh,(int)$headerlength-6);
							
							//chop and grab the header infirmation
							if (preg_match("/\H\{\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\@\[(.*?)\]\}/",$header,$head)) {
								//header was read successfully
								//list the error
								$datarray[]=array($file,$head);
								//ListError($head,1,$file);
							} else {
								//TODO provoke error handler
								echo 'There was an error loading the header data!';
							}
							
						} else {
							echo 'File was empty?';
						}
					}
				}
				
				//apply sorting to array
				
				//display errors
				foreach ($datarray as $i) {
					ListError($i[1],1,$i[0]);
				}
				
				//End the table
				ListError(null,2,null);
			} else {
				echo'No Errors!';
			}
		}
	}
}
	
$page->add("ErrorLog");

function MakeHeader($errpage, $errperpage, $efiles) {
	global $WebMS;
	
	$sort=0;
	if (isset($_GET['sort']))
	$sort=(int)$_GET['sort'];
	
	
	//Start table
	?>
		<table class="tbl" cellspacing=0 cellpadding=4>
		<tr>
			<td class="main" align="center">
				<b>-</b>
			</td>
			<td class="main">
				<b>Description:</b>
			</td>
			<td class="main">
				<b>File:</b>
			</td>
			<td class="main">
				<?php
					if ($sort==1) {
						//sort ascending
						?>
						<a href="?Admin.ErrorLog&amp;sort=2"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortup.png" border="0" style="vertical-align:middle"></a>
						<?php
					} else if ($sort==2) {
						//sort descending
						?>
						<a href="?Admin.ErrorLog&amp;sort=1"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortdown.png" border="0" style="vertical-align:middle"></a>
						<?php
					} else {
						//no sorting :(
						?>
						<a href="?Admin.ErrorLog&amp;sort=1"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortdown.png" border="0" style="vertical-align:middle"></a>
						<?php
					}
				?>
				<b>Date:</b>
			</td>
			<td class="main">
				<b>Action:</b>
			</td>
		</tr>
		<tr>
			<td class="sub" style="text-align:left" colspan="5">
			Page: 
			<?php
				//how many pages?
				if (count($efiles)<=$errperpage) {
					$epages=1;
				} else {
					$epages=ceil(count($efiles)/$errperpage);
				}

				$current = 0;
				while ($current < $epages) {
					++$current;
					if ($errpage==$current) {
						echo "$current ";
					} else {
						echo "<a href='?Admin.ErrorLog&amp;errpage={$current}'>{$current}</a> ";
					}
				}
			?>
			</td>
		</tr>
	<?
}

function ListError($head,$mode=1,$file) {
	global $WebMS;
	
	if ($mode==2) {
		//end table
		?>
			</table>
		<?
	} else {
		//print a line
		$errid=substr($head[5],0,1);
		$errstr=substr($head[5],1,strlen($head[5]));
		//TODO
		//onmouseover="new Effect.Highlight(this);" onmouseout="this.style.backgroundColor='transparent'"
		$file=explode('.',$file);
		$file=$file[0];
		?>
			<tr onMouseOver="this.className='highlight'" onMouseOut="this.className=''" onClick="window.location = '?Admin.ErrorLog&amp;err=<?=$file ?>'">
				<td align="center">
					<img src='<?=$WebMS['CoreUrl'] ?>Images/error<?=$errid ?>.png' border='0' alt='[<?=$errid ?>]' title='<?=$errstr ?>' style='padding-right:5px;vertical-align:center' \>
				</td>
				<td style="padding-right:20px">
					<?=$head[2] ?>
				</td>
				<td style="padding-right:20px">
					<?php
					$filesplit=explode("\\",$head[4]);
					echo $filesplit[count($filesplit)-1];
					?>
				</td>
				<td style="padding-right:20px">
					<?=$head[6]; ?>
				</td>
				<td>
					<a href="?Admin.ErrorLog&amp;del=<?=$file ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/button_cancel.png" border="0"></a>
				</td>
			</tr>
		<?
	}
}

function array_sort($array, $key)
{
   for ($i = 0; $i < sizeof($array); $i++) {
        $sort_values[$i] = $array[$i][$key];
   }
   asort ($sort_values);
   reset ($sort_values);
   while (list ($arr_key, $arr_val) = each ($sort_values)) {
          $sorted_arr[] = $array[$arr_key];
   }
   return $sorted_arr;
}

?>