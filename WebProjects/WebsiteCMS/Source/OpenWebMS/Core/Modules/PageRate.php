<?php
/**
* Page Rate module<br>
* This module allows a visitor to rate a page
* Licenced under GPLv2 read GPL.txt for details
* @version 1
* @copyright � 2007 ResPlace Team
* @lastedit 12-05-07
*
*@notes Need to gather IP address to stop multiple rating.
*/

if (isset($_GET["RatePage"]) && isset($_GET["page"]) && isset($_GET["path"])){
	include_once '../../config.php';
	$db=new ResDB("PageRater");
	$page=$db->getMap($_GET["page"]);
	$ips=explode(",",$page->get("ip",""));
	$nope=0;
	foreach ($ips as $ipc){
		if ($ipc==$_SERVER['REMOTE_ADDR']){
		$nope=1;
		break;
		}
	}
	if ($nope=0){
		$votes=$page->get("votes","0")+1;
		$rank=$page->get("rank","0")+$_GET["RatePage"];
		$ip=$page->get("ip","").','.$_SERVER['REMOTE_ADDR'];
		$page->put("votes",$votes);
		$page->put("rank" ,$rank);
		$page->put("ip" ,$ip);
		$rv=round($rank/$votes,2);
		echo $votes."-".$rank."-".$rv."- You rated this page ".$_GET["RatePage"];
	}else{
		$votes=$page->get("votes","0");
		$rank=$page->get("rank","0");
		$rv=round($rank/$votes,2);
		echo $votes."-".$rank."-".$rv."-<br><b>You already rated this page.</b>";
	}
	$db->close();
	
}else{
	class PageRate extends Module {
		var $url;
		var $base;
		function PageRate($page){
			$this->page=$page;
			$this->side=Module::LEFT;
			$this->title="Rate this Page";	
			$this->db=new ResDB("PageRater");
			$this->pg=$this->db->getMap($this->page->id);
			$this->url=str_replace($_SERVER["DOCUMENT_ROOT"],"", preg_replace("/\\\/","/",__FILE__));
			$this->base=str_replace("PageRate.php","",$this->url);
			$this->page->addJSCode("
				function PageRate(rate){
					var url='".$this->url."';
					new Ajax.Request(
						url, 
						{
							method: 'get', 
							parameters: '?RatePage='+rate+'&page='+'".$this->page->id."'+'&path='+'".$this->page->absRoot."', 
							onComplete: function(req){
								var opts=req.responseText.split('-');
								$('PageRate_votes').innerHTML=opts[0];
								$('PageRate_rank').innerHTML=opts[2];
								$('PageRate_progress').style.width=(parseFloat(opts[2])*100)/5+'px';
								$('PageRate_rate').innerHTML=opts[3];
							}
					});				
				}
			");
		}
		function content(){
			if (isset($_GET["RatePage"])){
				$r=$_GET["RatePage"];
				if ($r=="1" || $r=="2" || $r=="3" || $r=="4" || $r=="5"){
					$this->pg->put("votes",$this->pg->get("votes","0")+1);
					$this->pg->put("rank",$this->pg->get("rank","0")+$r);				
				}
			}
			$rank=$this->pg->get("rank");
			$votes=$this->pg->get("votes");
			if ($votes>0){		
				$rv=round($rank/$votes,2);
			}else{
				$rv=0;	
			}		
			$p=$_SERVER['PHP_SELF'];
			
			?>
				Rank: <span id="PageRate_rank"><?=$rv?></span> / 5  Votes: <span id="PageRate_votes"><?=$votes?></span>
				<div style="width:100px;background-color:white;border:1px solid black;height: 10px;">			
					<div id="PageRate_progress" style="position: static;left:0px;top:0px;background-image:URL(<?=$this->base."PageRate/PR.png"?>) ;height: 100%;width: <?=(100*$rv)/5?>px;font-size:0px"></div>
				</div>
                <?php

				;
				$ips=explode(",",$this->pg->get("ip",""));
				$nope=0;
				foreach ($ips as $ipc){
					if ($ipc==$_SERVER['REMOTE_ADDR'])
					{
					$nope=1;
					break;
					}
				}
				
				if (!$nope==1){
					?>
					<div id="PageRate_rate">
						<a href="javascript:;" onclick="PageRate(1)">1</a>
						<a href="javascript:;" onclick="PageRate(2)">2</a>
						<a href="javascript:;" onclick="PageRate(3)">3</a>
						<a href="javascript:;" onclick="PageRate(4)">4</a>
						<a href="javascript:;" onclick="PageRate(5)">5</a>
					</div>
					<?php
				}else{
					?>
                    <div id="PageRate_rate">
                    	<b>Thanks!</b>
                    </div>
                    <?php
				}
		}
	}
}
?>
