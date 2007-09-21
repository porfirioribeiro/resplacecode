<?php
class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content(){
		global $path, $page;
		
		
		//delete
		if (isset($_GET['del']))
			{
			?>
			<fieldset>
			<legend>Delete...</legend>
			Request should have succeeded.
			<?php
			unlink($path."Core/Includes/errors.log");
			?></fieldset><br><?php
			}
		
		
		
		$file=$path."/Core/Includes/errors/0.log";
		$fh=fopen($path."/Core/Includes/errors/0.log",'a+');
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
					    	<td ><?=$err2[2][$cnt2] ?></td>
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
					    	<td ><?=$err3[2][$cnt3] ?></td>
						</tr>
			<?php
			$cnt3+=1;
		}
		?>
					</table>
				</td>
			</tr>
		</table>
		<?php
		
		//preg_match_all("/\|\|(.*?)\|\|\=\>\|\|(.*?)\|\|/",$err[1][$cnt],$err);
		//print_r($err3);
	}
}
	
$page->add("ErrorLog");
?>
