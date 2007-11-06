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

      if (isset($WebMS['URLArray'][2]) && $WebMS['URLArray'][2]=="ThisOne") {
         trigger_error("oooops! This one we missed! (Test Error)",E_USER_NOTICE);
      }
      
		if (isset($WebMS['URLArray'][2]) && $WebMS['URLArray'][2]=="Del" && isset($WebMS['URLArray'][3])) {
			$del=(int)$WebMS['URLArray'][3];
			if (file_exists("{$WebMS["IncPath"]}errors/{$del}.log")) {
				unlink("{$WebMS["IncPath"]}errors/{$del}.log");
			}
		}

      if (isset($WebMS['URLArray'][2]) && $WebMS['URLArray'][2]=="Print" && isset($WebMS['URLArray'][3])) {
         //lose the buffer
			$handlers = ob_list_handlers();
			while ( ! empty($handlers) )    {
			    ob_end_clean();
			    $handlers = ob_list_handlers();
			}
			ob_start();
			echo'<html><head>
			<style>
			td {
				border-bottom:1px solid black;
			}
			table {
				border-spacing:0px;
				padding:3px;
				width:100%;
			}
			</style>
			</head><body>
			';
			//Load error viewer
			$err=(int)$WebMS['URLArray'][3];
			ShowError("{$WebMS["IncPath"]}errors/{$err}.log",$err);
			$cont= ob_get_contents();
			ob_end_clean();
			echo $cont;
			echo '
         <script type="text/javascript" language="javascript">
            document.getElementById("WEBMS_LOG_VAR").style.display="block";
            document.getElementById("REQUEST_LOG_VAR").style.display="block";
            document.getElementById("AHREF1").innerHTML="";
            document.getElementById("AHREF2").innerHTML="";
            window.print();
			</script>
			</body></html>';
			exit;
		} else if (isset($WebMS['URLArray'][2]) && $WebMS['URLArray'][2]=="Show" && isset($WebMS['URLArray'][3])) {
			//Load error viewer
			$err=(int)$WebMS['URLArray'][3];

			ShowError("{$WebMS["IncPath"]}errors/{$err}.log",$err);
		} else {
			//load list of errors
			$logpath="{$WebMS['IncPath']}errors/";
			$efiles=GetFiles($logpath);
			unset($efiles["errors.log"]);
			sort($efiles);

			//read sort
			$sort=0;
			if (isset($WebMS['URLArray'][5]))
			$sort=(int)$WebMS['URLArray'][5];
			if ($sort==1) {
				asort($efiles,SORT_NUMERIC);
			} else {
				arsort($efiles,SORT_NUMERIC);
			}

			//check there are some errors
			if (count($efiles)) {
				//How many errors per page?
				$errperpage=20;


				if (isset($WebMS['URLArray'][4])) {
					$errpage=(int)$WebMS['URLArray'][4];
					if ($errpage==0) {
						$errpage=1;
					}
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
						$eend=$errperpage;
					} else {
						$estart=($errperpage*$errpage)-($errperpage-1);
						$eend=($errperpage*$errpage);
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
								trigger_error("An error log file could not be read correctly at: ".$logpath.$file,E_WARNING);
								//unset($logpath.$file);
							}

						} else {
							trigger_error("An error log file was found empty and has been deleted",E_WARNING);
							$wtf=$logpath.$file;
							unset($wtf);
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
				echo'Well fortunately there are no errors to list... Oh did we forget <a href="'.url(array("*","*","ThisOne")).'">this one</a>?';
			}
		}
	}
}
	
$page->add("ErrorLog");
function MakeHeader($errpage, $errperpage, $efiles) {
	global $WebMS;
	
	$sort=0;
	if (isset($WebMS['URLArray'][5]))
	$sort=(int)$WebMS['URLArray'][5];
	
	//Start table
	?>
		<table style="width:100%" class="tbl" cellspacing=0 cellpadding=4>
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
						<a href="<?=url(array('*','*','*','*','*','2')); ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortup.png" border="0" style="vertical-align:middle"></a>
						<?php
					} else if ($sort==2) {
						//sort descending
						?>
						<a href="<?=url(array('*','*','*','*','*','1')); ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortdown.png" border="0" style="vertical-align:middle"></a>
						<?php
					} else {
						//no sorting :(
						?>
						<a href="<?=url(array('*','*','*','*','*','1')); ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/sortdown.png" border="0" style="vertical-align:middle"></a>
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
						echo "<a href='".url(array('*','*','*','*',$current,'*'))."'>{$current}</a> ";
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
			<tr onMouseOver="this.className='highlight'" onMouseOut="this.className=''" onClick="window.location = '<?=url(array('*','*','Show',$file)); ?>'">
				<td align="center">
					<img src='<?=$WebMS['CoreUrl'] ?>Images/error<?=$errid ?>.png' border='0' alt='[<?=$errid ?>]' title='<?=$errstr ?>' style='padding-right:5px;vertical-align:center' \>
				</td>
				<td style="padding-right:20px;">
					<?php
						$strstg2 = preg_replace( "/([^\n\r \.,]{5})/i" , '$1<span style="font-size:1px"> </span>', $head[2] );
          			echo $strstg2
					?>
				</td>
				<td style="padding-right:20px;">
					<?php
					$filesplit=explode("/",$head[4]);
					if (count($filesplit)==1) {
            $filesplit=explode("\\",$head[4]);
          }
					echo $filesplit[count($filesplit)-1];
					?>
				</td>
				<td style="padding-right:20px">
					<?=$head[6]; ?>
				</td>
				<td>
					<a href="<?=url(array("*","*","Print",$file)) ?>"><img src='<?=$WebMS['CoreUrl'] ?>Images/print.png' border='0' alt='Print' title='Print this error' \></a> <a href="<?=url(array('*','*','Del',$file)); ?>"><img src="<?=$WebMS['AdminUrl'] ?>icons/button_cancel.png" alt="Delete" title="Delete this error" border="0"></a>
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
