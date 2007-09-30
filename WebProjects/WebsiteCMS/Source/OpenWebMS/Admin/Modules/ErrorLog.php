<?php
class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content() {
		global $WebMS, $path;
		
		if (isset($_GET['err'])) {
			//Load error viewer
		} else {
			//load list of errors
			$logpath=$path."/Core/Includes/errors/";
			$efiles=GetFiles($logpath);
			
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
				foreach ($efiles as $file) {
					$foreachcnt+=1;
					//start/end at
					if ($errpage==1) {
						$estart=1;
						$eend=10;
					} else {
						$estart=$errperpage*($errpage-1);
						$eend=$errperpage*$errpage;
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
								ListError($head,1,$file);
							} else {
								echo 'There was an error loading the header data!';
							}
							
						} else {
							echo 'File was empty?';
						}
					}
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
				<b>Date:</b>
			</td>
			<td class="main">
				<b>Action:</b>
			</td>
		</tr>
		<tr class="sub">
			<td colspan="5">
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
						echo "<a href='?nav=ErrorLog&amp;errpage={$current}'>{$current}</a> ";
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
			<tr onMouseOver="this.className='highlight'" onMouseOut="this.className=''" onClick="window.location = '?nav=ErrorLog&amp;errid=<?=$file ?>'">
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
					<b>ToDo.</b>
				</td>
			</tr>
		<?
	}
}

?>