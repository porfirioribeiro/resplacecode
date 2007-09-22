<?php
class ErrorLog extends Module {
	function ErrorLog($page){
		parent::Module($page);
		$this->title="Error Log";		
		$this->side=Module::CENTER;
	}
	function content() {
		global $path, $page;
		
		
		//delete
		if (isset($_GET['del'])) {
			?>
			<fieldset>
			<legend>Delete...</legend>
			Request should have succeeded.
			<?php
			unlink($path."Core/Includes/errors.log");
			?></fieldset><br><?php
			}
		
		
//		/$path."/Core/Includes/errors/0.log"

			if (!isset($_GET['error'])) {
				//list error files
				$logpath=$path."/Core/Includes/errors/";
				$filearray=GetFiles($logpath);
				$errcnt=0;

				foreach ($filearray as $file) {
					$fh=fopen($logpath.$file,'a+');
					if (!filesize($logpath.$file)==0) {
						//get length of error message (for caption)
						$errlength=fread($fh,2);
						if ($errlength>0){
							//get caption
							$errcaption=fread($fh,(int)$errlength);
							$a=array();
							preg_match("/\[.*\]/",$errcaption,$a);
							$errcaption=preg_split("/\[.*\]/",$errcaption);
							if (isset($errcaption[0])){
								echo '<a href="?nav=ErrorLog&amp;error='.$errcnt.'">'.$errcaption[0].'</a>';
							}
							if (isset($a[0])){
								$a=$a[0];
								$a=preg_replace("/\"function/","http://php.net/manual/en/function",$a);
								echo $a;
								//http://php.net/manual/en/function
							}	
							if (isset($errcaption[1])){
								echo $errcaption[1].'<br>';
							}						
							$errcnt+=1;
						}
						
					} else {
						
					}
				}
			} else {
				ShowError($path."/Core/Includes/errors/".(int)$_GET['error'].".log");	
			}
		
		
		//preg_match_all("/\|\|(.*?)\|\|\=\>\|\|(.*?)\|\|/",$err[1][$cnt],$err);
		//print_r($err3);
	}
}
	
$page->add("ErrorLog");


?>